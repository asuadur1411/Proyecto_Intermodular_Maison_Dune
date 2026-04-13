<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function availability(Request $request)
    {
        $request->validate([
            'section' => 'required|in:interior,terrace',
            'guests'  => 'required|string',
            'date'    => 'required|date',
            'time'    => 'required|date_format:H:i',
        ]);

        $hour = (int) date('H', strtotime($request->query('time')));
        if ($hour >= 1 && $hour < 9) {
            return response()->json([
                'success' => false,
                'message' => 'The restaurant is closed at this hour. We are open from 9:00 to 00:00.',
                'data'    => [],
            ]);
        }

        $guestsRaw = $request->query('guests');
        $minCapacity = $guestsRaw === '7+' ? 7 : (int) $guestsRaw;

        $tables = Table::where('section', $request->query('section'))
            ->where('capacity', '>=', $minCapacity)
            ->orderBy('table_number')
            ->get();

        $requestedTime = $request->query('time');
        $requestedDate = $request->query('date');

        $timeFrom = date('H:i', strtotime($requestedTime) - 7140);
        $timeTo   = date('H:i', strtotime($requestedTime) + 7140);

        $reservedTableNumbers = Reservation::where('date', $requestedDate)
            ->where('time', '>=', $timeFrom)
            ->where('time', '<=', $timeTo)
            ->whereNotNull('table_number')
            ->pluck('table_number')
            ->toArray();

        $result = $tables->map(function ($table) use ($reservedTableNumbers) {
            return [
                'table_number' => $table->table_number,
                'capacity'     => $table->capacity,
                'available'    => !in_array($table->table_number, $reservedTableNumbers),
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $result->values(),
        ]);
    }
}
