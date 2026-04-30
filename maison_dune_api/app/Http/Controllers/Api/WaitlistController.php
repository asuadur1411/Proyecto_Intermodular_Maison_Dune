<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Waitlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaitlistController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'required|string|max:100',
            'phone'        => 'required|digits:9',
            'date'         => 'required|date|after_or_equal:today',
            'time'         => 'required|date_format:H:i',
            'guests'       => 'required|in:1,2,3,4,5,6,7+',
            'section'      => 'required|in:interior,terrace',
            'table_number' => 'nullable|integer',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['email']   = Auth::user()->email;

        $exists = Waitlist::where('user_id', $validated['user_id'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->where('section', $validated['section'])
            ->whereNull('notified_at')
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'You are already on the waitlist for this date, time and section.',
            ], 422);
        }

        $entry = Waitlist::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'You have been added to the waitlist. We will notify you by email if a table becomes available.',
            'data'    => $entry,
        ], 201);
    }

    public function myWaitlist(Request $request)
    {
        $entries = Waitlist::where('user_id', $request->user()->id)
            ->whereNull('notified_at')
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $entries,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $entry = Waitlist::findOrFail($id);

        if ($entry->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to remove this entry.',
            ], 403);
        }

        $entry->delete();

        return response()->json([
            'success' => true,
            'message' => 'Removed from waitlist.',
        ]);
    }
}
