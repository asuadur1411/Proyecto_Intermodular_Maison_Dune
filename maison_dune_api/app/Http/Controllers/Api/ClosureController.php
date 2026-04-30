<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Closure;
use Illuminate\Http\Request;

class ClosureController extends Controller
{
    public function index()
    {
        $closures = Closure::where('to_date', '>=', now()->toDateString())
            ->orderBy('from_date')
            ->get();

        return response()->json(['success' => true, 'data' => $closures]);
    }

    public function active()
    {
        $closure = Closure::where('from_date', '<=', now()->toDateString())
            ->where('to_date', '>=', now()->toDateString())
            ->first();

        return response()->json([
            'success' => true,
            'closed'  => $closure !== null,
            'data'    => $closure,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_date' => 'required|date|after_or_equal:today',
            'to_date'   => 'required|date|after_or_equal:from_date',
            'reason'    => 'nullable|string|max:255',
        ]);

        $closure = Closure::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Restaurant closure scheduled.',
            'data'    => $closure,
        ], 201);
    }

    public function destroy($id)
    {
        $closure = Closure::findOrFail($id);
        $closure->delete();

        return response()->json([
            'success' => true,
            'message' => 'Closure removed.',
        ]);
    }
}
