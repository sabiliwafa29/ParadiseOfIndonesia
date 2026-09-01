<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected bool $hasBookingModel;
    protected bool $hasStatusColumn;
    protected bool $hasRoleColumn;

    protected function prepareStats(): array
    {
        $this->hasBookingModel = class_exists(Booking::class);
        $this->hasStatusColumn = \Schema::hasColumn('tours', 'status');
        $this->hasRoleColumn = \Schema::hasColumn('users', 'role');

        return $this->calculateStats();
    }

    protected function calculateStats(): array
    {
        $totalTours = Tour::count();
        $activeTours = $this->hasStatusColumn
            ? Tour::where('status', 'active')->count()
            : $totalTours;
        $totalBookings = $this->hasBookingModel ? Booking::count() : 247;

        $totalRevenue = $this->calculateTotalRevenue();
        $totalCustomers = $this->calculateTotalCustomers();
        $pendingBookings = $this->hasBookingModel ? Booking::where('status', 'pending')->count() : 12;

        $recentBookings = $this->hasBookingModel
            ? Booking::with(['user', 'tour', 'package'])
                ->latest()
                ->take(5)
                ->get()
                ->filter(fn($b) => $b->user && ($b->tour || $b->package))
            : collect([]);

        $popularTours = $this->getPopularTours();
        $monthlyRevenue = $this->getMonthlyRevenue();
        $revenueChange = $this->calculateRevenueChange($monthlyRevenue);

        $bookingsByStatus = $this->getBookingsByStatus();
        $recentActivities = $this->getRecentActivities();
        $topDestinations = $this->getTopDestinations();

        return compact(
            'totalTours', 'activeTours', 'totalBookings', 'totalRevenue',
            'totalCustomers', 'pendingBookings', 'recentBookings',
            'popularTours', 'monthlyRevenue', 'bookingsByStatus',
            'recentActivities', 'topDestinations'
        ) + $revenueChange;
    }

    protected function calculateTotalRevenue(): float
    {
        if (!$this->hasBookingModel) {
            return 42500;
        }

        $successfulStatuses = config('bookings.success_statuses', ['confirmed', 'completed']);
        $totalRevenue = Booking::whereIn('status', $successfulStatuses)->sum('total_price');

        return $totalRevenue ?: Booking::sum('total_price');
    }

    protected function calculateTotalCustomers(): int
    {
        if (!$this->hasRoleColumn) {
            return User::count();
        }

        $customersByRole = User::where('role', 'customer')->count();

        return $customersByRole > 0 ? $customersByRole : User::count();
    }

    protected function getPopularTours()
    {
        try {
            return Tour::withCount('bookings')
                ->orderBy('bookings_count', 'desc')
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            return Tour::latest()->take(5)->get();
        }
    }

    protected function getMonthlyRevenue()
    {
        if (!$this->hasBookingModel) {
            return collect([
                (object)['month' => 6, 'year' => 2024, 'revenue' => 5000],
                (object)['month' => 7, 'year' => 2024, 'revenue' => 7500],
                (object)['month' => 8, 'year' => 2024, 'revenue' => 6200],
                (object)['month' => 9, 'year' => 2024, 'revenue' => 8900],
                (object)['month' => 10, 'year' => 2024, 'revenue' => 9500],
                (object)['month' => 11, 'year' => 2024, 'revenue' => 10200],
            ]);
        }

        $driver = DB::connection()->getDriverName();

        $status = 'completed';

        return $driver === 'pgsql'
            ? $this->getMonthlyRevenuePostgres($status)
            : $this->getMonthlyRevenueMySQL($status);
    }

    protected function getMonthlyRevenuePostgres(string $status)
    {
        return Booking::where('status', $status)
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(
                DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at)'), DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->orderByRaw('EXTRACT(YEAR FROM created_at), EXTRACT(MONTH FROM created_at)')
            ->get();
    }

    protected function getMonthlyRevenueMySQL(string $status)
    {
        return Booking::where('status', $status)
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
    }

    protected function calculateRevenueChange($monthlyRevenue): array
    {
        $values = $monthlyRevenue->values();
        $count = $values->count();

        if ($count === 0) {
            return ['revenueChangePercent' => 0, 'revenueChangePositive' => true];
        }

        $lastRevenue = $values[$count - 1]->revenue ?? 0;
        $prevRevenue = $count > 1 ? ($values[$count - 2]->revenue ?? 0) : 0;

        $percent = $prevRevenue == 0
            ? ($lastRevenue == 0 ? 0 : 100)
            : (($lastRevenue - $prevRevenue) / $prevRevenue) * 100;

        $processed = collect();
        $prevRev = null;

        foreach ($values as $m) {
            $rev = $m->revenue ?? 0;

            if ($prevRev === null) {
                $pct = 0;
                $pos = true;
            } else {
                if ($prevRev == 0) {
                    $pct = $rev == 0 ? 0 : 100;
                } else {
                    $pct = (($rev - $prevRev) / $prevRev) * 100;
                }
                $pos = $pct >= 0;
            }

            $processed->push((object)[
                'month' => $m->month,
                'year' => $m->year,
                'revenue' => $rev,
                'percent_change' => round($pct, 1),
                'percent_positive' => $pos,
            ]);

            $prevRev = $rev;
        }

        return [
            'monthlyRevenue' => $processed,
            'revenueChangePercent' => round($percent, 1),
            'revenueChangePositive' => $percent >= 0,
        ];
    }

    protected function getBookingsByStatus()
    {
        if ($this->hasBookingModel) {
            return Booking::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status');
        }

        return collect([
            'pending' => 12,
            'confirmed' => 45,
            'completed' => 180,
            'cancelled' => 10,
        ]);
    }

    protected function getRecentActivities()
    {
        $recentTours = Tour::latest()->take(3)->get()->map(fn($tour) => [
            'type' => 'tour',
            'message' => "New tour package '{$tour->name}' was created",
            'created_at' => $tour->created_at,
            'icon' => 'tour',
        ]);

        if (!$this->hasBookingModel) {
            return $recentTours;
        }

        $recentBookingActivities = Booking::with(['user', 'tour', 'package'])
            ->latest()
            ->take(7)
            ->get()
            ->filter(fn($b) => $b->user && ($b->tour || $b->package))
            ->map(fn($booking) => $this->formatBookingActivity($booking));

        return $recentTours->concat($recentBookingActivities)
            ->sortByDesc('created_at')
            ->take(10);
    }

    protected function formatBookingActivity($booking): array
    {
        $userName = $booking->user->name ?? $booking->full_name ?? 'Guest';

        if ($booking->tour) {
            $itemName = \App\Helpers\LanguageHelper::get($booking->tour, 'name');
            $itemType = 'tour';
        } elseif ($booking->package) {
            $itemName = \App\Helpers\LanguageHelper::get($booking->package, 'name');
            $itemType = 'package';
        } else {
            $itemName = 'Unknown';
            $itemType = 'booking';
        }

        return [
            'type' => 'booking',
            'message' => "{$userName} booked {$itemType} '{$itemName}'",
            'created_at' => $booking->created_at,
            'icon' => 'booking',
        ];
    }

    protected function getTopDestinations()
    {
        if (!class_exists(Destination::class)) {
            return collect([]);
        }

        try {
            return Destination::withCount('tours')
                ->orderBy('tours_count', 'desc')
                ->limit(5)
                ->get()
                ->filter(fn($d) => $d->tours_count > 0);
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    public function index()
    {
        $stats = $this->prepareStats();

        return view('admin.dashboard', $stats)->with([
            'revenueChangePercent' => $stats['revenueChangePercent'] ?? 0,
            'revenueChangePositive' => $stats['revenueChangePositive'] ?? true,
        ]);
    }
}