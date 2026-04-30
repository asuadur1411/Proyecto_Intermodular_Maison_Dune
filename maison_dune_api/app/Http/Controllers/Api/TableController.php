<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function bookedHours(Request $request)
    {
        $request->validate([
            'section' => 'required|in:interior,terrace',
            'guests'  => 'required|string',
            'date'    => 'required|date',
        ]);

        $guestsRaw   = $request->query('guests');
        $minCapacity = $guestsRaw === '7+' ? 7 : (int) $guestsRaw;

        $totalTables = Table::where('section', $request->query('section'))
            ->where('capacity', '>=', $minCapacity)
            ->count();

        if ($totalTables === 0) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $allHours = ['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00',
                     '19:00','20:00','21:00','22:00','23:00','00:00'];

        $bookedHours = [];

        foreach ($allHours as $hour) {
            $timeFrom = date('H:i', strtotime($hour) - 7140);
            $timeTo   = date('H:i', strtotime($hour) + 7140);

            $reservedCount = Reservation::where('date', $request->query('date'))
                ->where('time', '>=', $timeFrom)
                ->where('time', '<=', $timeTo)
                ->whereNotNull('table_number')
                ->distinct('table_number')
                ->count('table_number');

            $sectionReserved = Reservation::where('date', $request->query('date'))
                ->where('section', $request->query('section'))
                ->where('time', '>=', $timeFrom)
                ->where('time', '<=', $timeTo)
                ->count();

            if ($sectionReserved >= $totalTables) {
                $bookedHours[] = $hour;
            }
        }

        return response()->json(['success' => true, 'data' => $bookedHours]);
    }

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

    public function statusNow(Request $request)
    {
        $now       = now();
        $today     = $now->toDateString();
        $nowTime   = $now->format('H:i');
        $soonTime  = $now->copy()->addMinutes(60)->format('H:i');

        $activeFrom = $now->copy()->subMinutes(119)->format('H:i');
        $activeTo   = $now->copy()->addMinutes(119)->format('H:i');

        $tables = Table::orderBy('section')->orderBy('table_number')->get();

        $todaysReservations = Reservation::where('date', $today)
            ->whereNotNull('table_number')
            ->get();

        $result = $tables->map(function ($t) use ($todaysReservations, $activeFrom, $activeTo, $nowTime, $soonTime) {
            $status = 'free';
            $info   = null;

            $reservationsForTable = $todaysReservations->where('table_number', $t->table_number);

            foreach ($reservationsForTable as $r) {
                if ($r->time >= $activeFrom && $r->time <= $activeTo) {
                    $status = 'occupied';
                    $info   = [
                        'guest' => trim(($r->first_name ?? '') . ' ' . ($r->last_name ?? '')),
                        'time'  => substr($r->time, 0, 5),
                        'guests'=> $r->guests,
                    ];
                    break;
                }
                if ($status === 'free' && $r->time > $nowTime && $r->time <= $soonTime) {
                    $status = 'upcoming';
                    $info   = [
                        'guest' => trim(($r->first_name ?? '') . ' ' . ($r->last_name ?? '')),
                        'time'  => substr($r->time, 0, 5),
                        'guests'=> $r->guests,
                    ];
                }
            }

            return [
                'table_number' => $t->table_number,
                'section'      => $t->section,
                'capacity'     => $t->capacity,
                'status'       => $status,
                'info'         => $info,
            ];
        });

        return response()->json(['success' => true, 'data' => $result->values()]);
    }
}
