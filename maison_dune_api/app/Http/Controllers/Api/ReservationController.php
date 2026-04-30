<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\AdminCancellationNotice;
use App\Mail\BookingCancellationRefund;
use App\Mail\EventRegistrationConfirmation;
use App\Mail\ReservationConfirmation;
use App\Mail\RoomBookingConfirmation;
use App\Mail\WaitlistAvailable;
use App\Models\Reservation;
use App\Models\Waitlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'phone'      => 'required|digits:9',
            'date'       => 'required|date|after_or_equal:today',
            'time'       => 'required|date_format:H:i',
            'guests'     => 'required|in:1,2,3,4,5,6,7+',
            'section'    => 'nullable|in:interior,terrace,private',
            'table_number' => 'nullable|integer',
            'room_number'  => 'nullable|string|max:20',
            'notes'      => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['email']   = Auth::user()->email;

        $exists = Reservation::where('user_id', $validated['user_id'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a reservation at that date and time.',
            ], 422);
        }

        $reservation = Reservation::create($validated);

        Mail::to($reservation->email)->send(new ReservationConfirmation($reservation));

        return response()->json([
            'success' => true,
            'message' => 'Reservation created successfully.',
            'data'    => $reservation,
        ], 201);
    }

    public function eventStore(Request $request)
    {
        $validated = $request->validate([
            'event_slug'     => 'required|string|max:200',
            'event_title'    => 'required|string|max:200',
            'event_date'     => 'required|date|after_or_equal:today',
            'event_time'     => 'required|date_format:H:i',
            'event_location' => 'nullable|string|max:120',
            'event_capacity' => 'nullable|integer|min:1',
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'phone'          => 'required|digits:9',
            'guests'         => 'required|integer|min:1|max:20',
            'notes'          => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        $duplicate = Reservation::where('user_id', $user->id)
            ->where('event_slug', $validated['event_slug'])
            ->exists();

        if ($duplicate) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this event.',
            ], 422);
        }

        if (!empty($validated['event_capacity'])) {
            $bookedSeats = (int) Reservation::where('event_slug', $validated['event_slug'])
                ->sum('guests');

            $remaining = (int) $validated['event_capacity'] - $bookedSeats;

            if ($validated['guests'] > $remaining) {
                return response()->json([
                    'success' => false,
                    'message' => $remaining > 0
                        ? "Only {$remaining} seat(s) left for this event."
                        : 'This event is sold out.',
                ], 422);
            }
        }

        $reservation = Reservation::create([
            'user_id'      => $user->id,
            'first_name'   => $validated['first_name'],
            'last_name'    => $validated['last_name'],
            'email'        => $user->email,
            'phone'        => $validated['phone'],
            'date'         => $validated['event_date'],
            'time'         => $validated['event_time'],
            'guests'       => (string) $validated['guests'],
            'section'      => 'private',
            'room_number'  => $validated['event_location'] ?? null,
            'notes'        => $validated['notes'] ?? null,
            'event_slug'   => $validated['event_slug'],
            'event_title'  => $validated['event_title'],
        ]);

        try {
            Mail::to($reservation->email)->send(new EventRegistrationConfirmation($reservation));
        } catch (\Throwable $e) {
        }

        return response()->json([
            'success' => true,
            'message' => 'You are registered. Check your dashboard to view the QR ticket.',
            'data'    => $reservation,
        ], 201);
    }

    public function roomStore(Request $request)
    {
        $validated = $request->validate([
            'room_slug'     => 'required|string|max:200',
            'room_title'    => 'required|string|max:200',
            'checkin_date'  => 'required|date|after_or_equal:today',
            'checkout_date' => 'required|date|after:checkin_date',
            'guests'        => 'required|integer|min:1|max:12',
            'total_price'   => 'required|numeric|min:0',
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'phone'         => 'nullable|digits:9',
            'notes'         => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        // Maximum stay: 7 nights.
        $checkIn  = \Illuminate\Support\Carbon::parse($validated['checkin_date'])->startOfDay();
        $checkOut = \Illuminate\Support\Carbon::parse($validated['checkout_date'])->startOfDay();
        $nights   = $checkIn->diffInDays($checkOut);
        if ($nights < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Check-out must be after check-in.',
            ], 422);
        }
        if ($nights > 7) {
            return response()->json([
                'success' => false,
                'message' => 'The maximum stay is 7 nights. Please shorten your reservation.',
            ], 422);
        }

        // One active room booking per user: block if the user already has any
        // room reservation whose stay has not yet ended.
        $today = now()->toDateString();
        $hasActive = Reservation::where('user_id', $user->id)
            ->whereNotNull('room_slug')
            ->whereNotNull('checkout_date')
            ->where('checkout_date', '>', $today)
            ->exists();

        if ($hasActive) {
            return response()->json([
                'success' => false,
                'message' => 'You already have an active room reservation. You can book another stay once your current one ends.',
            ], 422);
        }

        // Cross-user availability check: a room can only be booked once per overlapping date range.
        // Standard interval-overlap: [A_in, A_out) overlaps [B_in, B_out) iff A_in < B_out AND A_out > B_in.
        $overlap = Reservation::where('room_slug', $validated['room_slug'])
            ->where('date', '<', $validated['checkout_date'])
            ->where('checkout_date', '>', $validated['checkin_date'])
            ->exists();

        if ($overlap) {
            return response()->json([
                'success' => false,
                'message' => 'This room is not available for the selected dates. Please choose different dates.',
            ], 422);
        }

        $reservation = Reservation::create([
            'user_id'       => $user->id,
            'first_name'    => $validated['first_name'],
            'last_name'     => $validated['last_name'],
            'email'         => $user->email,
            'phone'         => $validated['phone'] ?? null,
            'date'          => $validated['checkin_date'],
            'time'          => '15:00',
            'guests'        => (string) $validated['guests'],
            'section'       => 'private',
            'notes'         => $validated['notes'] ?? null,
            'room_slug'     => $validated['room_slug'],
            'room_title'    => $validated['room_title'],
            'checkout_date' => $validated['checkout_date'],
            'total_price'   => $validated['total_price'],
        ]);

        try {
            Mail::to($reservation->email)->send(new RoomBookingConfirmation($reservation));
        } catch (\Throwable $e) {
            \Log::warning('RoomBookingConfirmation email failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Room reservation confirmed.',
            'data'    => $reservation,
        ], 201);
    }

    public function eventAvailability(Request $request, string $slug)
    {
        $bookedSeats = (int) Reservation::where('event_slug', $slug)->sum('guests');

        return response()->json([
            'success'      => true,
            'event_slug'   => $slug,
            'booked_seats' => $bookedSeats,
        ]);
    }

    public function roomAvailability(Request $request, string $slug)
    {
        // Return all booked ranges from today onwards.
        // checkin = inclusive (date), checkout = exclusive (checkout_date) — guest leaves that morning.
        $today = now()->toDateString();

        $ranges = Reservation::where('room_slug', $slug)
            ->whereNotNull('checkout_date')
            ->where('checkout_date', '>', $today)
            ->orderBy('date')
            ->get(['date', 'checkout_date'])
            ->map(function ($r) {
                return [
                    'from' => \Illuminate\Support\Carbon::parse($r->date)->format('Y-m-d'),
                    'to'   => \Illuminate\Support\Carbon::parse($r->checkout_date)->format('Y-m-d'),
                ];
            });

        return response()->json([
            'success'   => true,
            'room_slug' => $slug,
            'booked'    => $ranges,
        ]);
    }

    public function myReservations(Request $request)
    {
        $reservations = Reservation::where('user_id', $request->user()->id)
                                   ->orderBy('date', 'asc')
                                   ->orderBy('time', 'asc')
                                   ->get();

        return response()->json([
            'success' => true,
            'data'    => $reservations,
        ]);
    }

    public function index()
    {
        Reservation::where('date', '<', now()->toDateString())->delete();

        $reservations = Reservation::orderBy('date', 'asc')
                                   ->orderBy('time', 'asc')
                                   ->get();

        return response()->json([
            'success' => true,
            'data'    => $reservations,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($request->user()->is_admin) {
            $this->notifyWaitlist($reservation);

            // Notify the booking owner that their reservation has been cancelled by admin.
            try {
                if (!empty($reservation->email)) {
                    Mail::to($reservation->email)->send(new AdminCancellationNotice($reservation));
                }
            } catch (\Throwable $e) {
                \Log::warning('AdminCancellationNotice email failed: ' . $e->getMessage());
            }

            $reservation->delete();
            return response()->json([
                'success' => true,
                'message' => 'Reservation deleted by admin.',
            ]);
        }

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, $request->user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect password.',
            ], 403);
        }

        if ($reservation->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to cancel this reservation.',
            ], 403);
        }

        // Compute refund (only relevant for room bookings — restaurant/event reservations
        // are unpaid in this system).
        $refundData = null;
        $isRoomBooking = !empty($reservation->room_slug) && $reservation->total_price !== null;

        if ($isRoomBooking) {
            $refundMethod = $request->input('refund_method', 'original');
            if (!in_array($refundMethod, ['original', 'card', 'paypal', 'applepay'], true)) {
                $refundMethod = 'original';
            }

            $total      = (float) $reservation->total_price;
            $checkIn    = \Illuminate\Support\Carbon::parse($reservation->date)->setTime(15, 0);
            $now        = now();
            $hoursUntil = $now->diffInHours($checkIn, false); // negative if already started

            if ($hoursUntil >= 48) {
                $percent      = 1.00;
                $percentLabel = '100% refund';
                $reason       = 'Cancelled more than 48 hours before check-in.';
            } elseif ($hoursUntil >= 24) {
                $percent      = 0.50;
                $percentLabel = '50% refund';
                $reason       = 'Cancelled within 48 hours of check-in.';
            } elseif ($hoursUntil >= 0) {
                $percent      = 0.00;
                $percentLabel = 'No refund';
                $reason       = 'Cancelled within 24 hours of check-in.';
            } else {
                $percent      = 0.00;
                $percentLabel = 'No refund';
                $reason       = 'Stay has already started.';
            }

            $refundAmount = round($total * $percent, 2);

            $refundData = [
                'eligible'        => $percent > 0,
                'amount'          => $refundAmount,
                'original_amount' => $total,
                'percent_label'   => $percentLabel,
                'reason'          => $reason,
                'method'          => $refundMethod,
            ];

            try {
                Mail::to($reservation->email)->send(new BookingCancellationRefund(
                    $reservation,
                    $refundAmount,
                    $percentLabel,
                    $refundMethod,
                    $reason
                ));
            } catch (\Throwable $e) {
                \Log::warning('BookingCancellationRefund email failed: ' . $e->getMessage());
            }
        }

        $this->notifyWaitlist($reservation);
        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => $refundData
                ? 'Booking cancelled. ' . $refundData['percent_label'] . ' of €' . number_format($refundData['amount'], 2) . ' will be processed.'
                : 'Reservation cancelled successfully.',
            'refund'  => $refundData,
        ]);
    }

    private function notifyWaitlist(Reservation $reservation): void
    {
        $timeMin = date('H:i', strtotime($reservation->time) - 119 * 60);
        $timeMax = date('H:i', strtotime($reservation->time) + 119 * 60);

        $entries = Waitlist::where('date', $reservation->date)
            ->where('section', $reservation->section)
            ->where('time', '>=', $timeMin)
            ->where('time', '<=', $timeMax)
            ->whereNull('notified_at')
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($entries as $entry) {
            Mail::to($entry->email)->send(new WaitlistAvailable($entry));
            $entry->update(['notified_at' => now()]);
        }
    }

    public function lookupByCode(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $raw = trim($request->input('code'));
        $firstPart = explode('|', $raw)[0];
        $digits = preg_replace('/[^0-9]/', '', $firstPart);
        if ($digits === '') {
            return response()->json(['success' => false, 'message' => 'Invalid code.'], 422);
        }

        $reservation = Reservation::find((int) $digits);
        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Reservation not found.'], 404);
        }

        return response()->json(['success' => true, 'data' => $reservation]);
    }

    public function checkIn(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->checked_in_at) {
            return response()->json([
                'success' => false,
                'message' => 'Already checked in at ' . $reservation->checked_in_at->format('H:i'),
                'data'    => $reservation,
            ], 409);
        }

        $reservation->checked_in_at = now();
        $reservation->save();

        return response()->json([
            'success' => true,
            'message' => 'Guest checked in successfully.',
            'data'    => $reservation,
        ]);
    }

    public function cancelBySlug(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:event,room',
            'slug' => 'required|string|max:200',
        ]);

        $field = $validated['type'] === 'event' ? 'event_slug' : 'room_slug';

        $reservations = Reservation::where($field, $validated['slug'])->get();

        $count = 0;
        foreach ($reservations as $reservation) {
            try {
                if (!empty($reservation->email)) {
                    Mail::to($reservation->email)->send(new AdminCancellationNotice($reservation));
                }
            } catch (\Throwable $e) {
                \Log::warning('AdminCancellationNotice (bulk) failed: ' . $e->getMessage());
            }
            $reservation->delete();
            $count++;
        }

        return response()->json([
            'success'   => true,
            'message'   => $count . ' reservation(s) cancelled and notified.',
            'cancelled' => $count,
        ]);
    }
}