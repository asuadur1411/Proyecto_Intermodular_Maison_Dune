<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function overview()
    {
        $today = Carbon::today();
        $now = Carbon::now();

        $activeReservations = Reservation::where('date', '>=', $today)->count();
        $todayReservations = Reservation::where('date', $today)->count();
        $totalUsers = User::count();
        $totalMessages = Contact::count();

        $upcomingGuests = Reservation::where('date', '>=', $today)
            ->selectRaw("SUM(CASE WHEN guests = '7+' THEN 7 ELSE CAST(guests AS UNSIGNED) END) as total")
            ->value('total') ?? 0;

        $sections = Reservation::where('date', '>=', $today)
            ->whereNull('event_slug')
            ->select('section', DB::raw('COUNT(*) as count'))
            ->groupBy('section')
            ->pluck('count', 'section');

        $eventCount = Reservation::where('date', '>=', $today)
            ->whereNotNull('event_slug')
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'active_reservations' => $activeReservations,
                'today_reservations' => $todayReservations,
                'total_users' => $totalUsers,
                'total_messages' => $totalMessages,
                'upcoming_guests' => (int) $upcomingGuests,
                'sections' => $sections,
                'event_reservations' => $eventCount,
            ],
        ]);
    }

    public function reservationsByDay()
    {
        $start = Carbon::today();
        $end = Carbon::today()->addDays(13);

        $reservations = Reservation::whereBetween('date', [$start, $end])
            ->select('date', DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $labels = [];
        $values = [];
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $key = $d->toDateString();
            $labels[] = $d->format('M d');
            $values[] = $reservations[$key] ?? 0;
        }

        return response()->json([
            'success' => true,
            'data' => ['labels' => $labels, 'values' => $values],
        ]);
    }

    public function guestsByDay()
    {
        $start = Carbon::today();
        $end = Carbon::today()->addDays(13);

        $guests = Reservation::whereBetween('date', [$start, $end])
            ->select('date', DB::raw("SUM(CASE WHEN guests = '7+' THEN 7 ELSE CAST(guests AS UNSIGNED) END) as total"))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $labels = [];
        $values = [];
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $key = $d->toDateString();
            $labels[] = $d->format('M d');
            $values[] = (int) ($guests[$key] ?? 0);
        }

        return response()->json([
            'success' => true,
            'data' => ['labels' => $labels, 'values' => $values],
        ]);
    }

    public function peakHours()
    {
        $hours = Reservation::where('date', '>=', Carbon::today())
            ->select(DB::raw('HOUR(time) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('count', 'hour');

        $labels = [];
        $values = [];
        for ($h = 9; $h <= 23; $h++) {
            $labels[] = sprintf('%02d:00', $h);
            $values[] = $hours[$h] ?? 0;
        }

        return response()->json([
            'success' => true,
            'data' => ['labels' => $labels, 'values' => $values],
        ]);
    }

    public function userGrowth()
    {
        $start = Carbon::today()->subDays(29);

        $users = User::where('created_at', '>=', $start)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $labels = [];
        $values = [];
        $cumulative = User::where('created_at', '<', $start)->count();

        for ($d = $start->copy(); $d->lte(Carbon::today()); $d->addDay()) {
            $key = $d->toDateString();
            $cumulative += $users[$key] ?? 0;
            $labels[] = $d->format('M d');
            $values[] = $cumulative;
        }

        return response()->json([
            'success' => true,
            'data' => ['labels' => $labels, 'values' => $values],
        ]);
    }

    public function tableSaturation()
    {
        $today = Carbon::today();
        $end = Carbon::today()->addDays(6);

        $tables = DB::table('tables')->get();
        $totalTables = $tables->count();

        $reservations = Reservation::whereBetween('date', [$today, $end])
            ->select('date', DB::raw('COUNT(DISTINCT table_number) as occupied'))
            ->whereNotNull('table_number')
            ->groupBy('date')
            ->pluck('occupied', 'date');

        $labels = [];
        $values = [];
        for ($d = $today->copy(); $d->lte($end); $d->addDay()) {
            $key = $d->toDateString();
            $occupied = $reservations[$key] ?? 0;
            $labels[] = $d->format('D');
            $values[] = $totalTables > 0 ? round(($occupied / $totalTables) * 100) : 0;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'labels' => $labels,
                'values' => $values,
                'total_tables' => $totalTables,
            ],
        ]);
    }
}
