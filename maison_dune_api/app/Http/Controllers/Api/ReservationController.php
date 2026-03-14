<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Crear reserva — asociar al usuario si está logueado
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|max:100',
            'phone'      => 'nullable|string|max:30',
            'date'       => 'required|date|after:today',
            'time'       => 'required|date_format:H:i',
            'guests'     => 'required|in:1,2,3,4,5,6,7+',
            'section'    => 'nullable|in:interior,terrace,private',
            'notes'      => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = Auth::id();

        $reservation = Reservation::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Reservation created successfully.',
            'data'    => $reservation,
        ], 201);
    }

    // Mis reservas — solo las del usuario autenticado
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

    // Listar todas las reservas (solo admin autenticado)
    public function index()
    {
        $reservations = Reservation::orderBy('date', 'asc')
                                   ->orderBy('time', 'asc')
                                   ->get();

        return response()->json([
            'success' => true,
            'data'    => $reservations,
        ]);
    }

    // Eliminar reserva (solo admin autenticado)
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reservation deleted successfully.',
        ]);
    }
}