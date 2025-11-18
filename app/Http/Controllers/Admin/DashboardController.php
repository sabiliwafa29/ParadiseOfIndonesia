<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Booking;
use App\Models\User;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek apakah model Booking ada, jika tidak gunakan data dummy
        $hasBookingModel = class_exists('App\Models\Booking');
        
        // Cek apakah kolom status ada di tabel tours
        $hasStatusColumn = \Schema::hasColumn('tours', 'status');
        
        // Total Statistics
        $totalTours = Tour::count();
        $activeTours = $hasStatusColumn ? Tour::where('status', 'active')->count() : $totalTours;
        $totalBookings = $hasBookingModel ? Booking::count() : 247;
        $totalRevenue = $hasBookingModel ? Booking::where('status', 'completed')->sum('total_price') : 42500;
        
        // Cek apakah kolom role ada di tabel users
        $hasRoleColumn = \Schema::hasColumn('users', 'role');
        $totalCustomers = $hasRoleColumn ? User::where('role', 'customer')->count() : User::count();
        
        $pendingBookings = $hasBookingModel ? Booking::where('status', 'pending')->count() : 12;

        // Recent Bookings (Last 5)
        if ($hasBookingModel) {
            $recentBookings = Booking::with(['user', 'tour', 'package'])
                ->latest()
                ->take(5)
                ->get()
                ->filter(function($booking) {
                    // Only show bookings that have user and (tour or package)
                    return $booking->user && ($booking->tour || $booking->package);
                });
        } else {
            $recentBookings = collect([]);
        }

        // Popular Tours (Top 5 by bookings)
        if ($hasBookingModel) {
            // Cek apakah relasi bookings ada di model Tour
            try {
                $popularTours = Tour::withCount('bookings')
                    ->orderBy('bookings_count', 'desc')
                    ->take(5)
                    ->get();
            } catch (\Exception $e) {
                // Jika relasi tidak ada, ambil tour terbaru saja
                $popularTours = Tour::latest()->take(5)->get();
            }
        } else {
            $popularTours = Tour::latest()->take(5)->get();
        }

        // Monthly Revenue Chart Data (Last 6 months)
        if ($hasBookingModel) {
            // Deteksi database driver
            $driver = DB::connection()->getDriverName();
            
            if ($driver === 'pgsql') {
                // PostgreSQL syntax
                $monthlyRevenue = Booking::where('status', 'completed')
                    ->where('created_at', '>=', Carbon::now()->subMonths(6))
                    ->select(
                        DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                        DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                        DB::raw('SUM(total_price) as revenue')
                    )
                    ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at)'), DB::raw('EXTRACT(MONTH FROM created_at)'))
                    ->orderBy(DB::raw('EXTRACT(YEAR FROM created_at)'), 'asc')
                    ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'), 'asc')
                    ->get();
            } else {
                // MySQL syntax
                $monthlyRevenue = Booking::where('status', 'completed')
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
        } else {
            // Dummy data untuk chart
            $monthlyRevenue = collect([
                (object)['month' => 6, 'year' => 2024, 'revenue' => 5000],
                (object)['month' => 7, 'year' => 2024, 'revenue' => 7500],
                (object)['month' => 8, 'year' => 2024, 'revenue' => 6200],
                (object)['month' => 9, 'year' => 2024, 'revenue' => 8900],
                (object)['month' => 10, 'year' => 2024, 'revenue' => 9500],
                (object)['month' => 11, 'year' => 2024, 'revenue' => 10200],
            ]);
        }

        // Booking Status Distribution
        if ($hasBookingModel) {
            $bookingsByStatus = Booking::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status');
        } else {
            // Dummy data untuk status
            $bookingsByStatus = collect([
                'pending' => 12,
                'confirmed' => 45,
                'completed' => 180,
                'cancelled' => 10,
            ]);
        }

        // Recent Activities (Last 10)
        $recentActivities = collect([]);
        
        // Get recent tours
        $recentTours = Tour::latest()->take(3)->get()->map(function($tour) {
            return [
                'type' => 'tour',
                'message' => "New tour package '{$tour->name}' was created",
                'created_at' => $tour->created_at,
                'icon' => 'tour'
            ];
        });

        // Get recent bookings
        if ($hasBookingModel) {
            $recentBookingActivities = Booking::with(['user', 'tour', 'package'])
                ->latest()
                ->take(7)
                ->get()
                ->filter(function($booking) {
                    // Filter out bookings without user or without tour/package
                    return $booking->user && ($booking->tour || $booking->package);
                })
                ->map(function($booking) {
                    // Get user name (from user or booking data)
                    $userName = $booking->user->name ?? $booking->full_name ?? 'Guest';
                    
                    // Get tour/package name
                    if ($booking->tour) {
                        $itemName = $booking->tour->name;
                        $itemType = 'tour';
                    } elseif ($booking->package) {
                        $itemName = $booking->package->name;
                        $itemType = 'package';
                    } else {
                        $itemName = 'Unknown';
                        $itemType = 'booking';
                    }
                    
                    return [
                        'type' => 'booking',
                        'message' => "{$userName} booked {$itemType} '{$itemName}'",
                        'created_at' => $booking->created_at,
                        'icon' => 'booking'
                    ];
                });
            
            $recentActivities = $recentTours->concat($recentBookingActivities)
                ->sortByDesc('created_at')
                ->take(10);
        } else {
            $recentActivities = $recentTours;
        }

        // Top Destinations
        if (class_exists('App\Models\Destination')) {
            try {
                $topDestinations = Destination::withCount('tours')
                    ->orderBy('tours_count', 'desc')
                    ->limit(5)
                    ->get()
                    ->filter(function($destination) {
                        return $destination->tours_count > 0;
                    });
            } catch (\Exception $e) {
                $topDestinations = collect([]);
            }
        } else {
            $topDestinations = collect([]);
        }

        return view('admin.dashboard', compact(
            'totalTours',
            'activeTours',
            'totalBookings',
            'totalRevenue',
            'totalCustomers',
            'pendingBookings',
            'recentBookings',
            'popularTours',
            'monthlyRevenue',
            'bookingsByStatus',
            'recentActivities',
            'topDestinations'
        ));
    }
}