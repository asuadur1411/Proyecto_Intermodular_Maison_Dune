<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ReservationConfirmation;
use App\Models\Reservation;
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
            'date'       => 'required|date|after:today',
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
        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, $request->user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect password.',
            ], 403);
        }

        $reservation = Reservation::findOrFail($id);

        if ($reservation->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to cancel this reservation.',
            ], 403);
        }

        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reservation cancelled successfully.',
        ]);
    }
}