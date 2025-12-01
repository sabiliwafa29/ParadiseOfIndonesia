<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        // Get booking statistics for bulk actions
        $bookingStats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'old_bookings' => Booking::where('date', '<', now()->subMonths(6))->count(),
        ];

        // Get current display settings from cache/config
        $displaySettings = $this->getDisplaySettings();

        return view('admin.settings.index', compact('bookingStats', 'displaySettings'));
    }

    /**
     * Delete bookings based on criteria.
     */
    public function deleteBookings(Request $request)
    {
        $request->validate([
            'delete_type' => 'required|in:selected,status,old,all',
            'status' => 'nullable|in:pending,confirmed,completed,cancelled',
            'booking_ids' => 'nullable|array',
            'booking_ids.*' => 'exists:bookings,id',
            'months_old' => 'nullable|integer|min:1',
            'confirm_delete' => 'required|accepted',
        ]);

        $deletedCount = 0;

        switch ($request->delete_type) {
            case 'selected':
                if ($request->booking_ids) {
                    $deletedCount = Booking::whereIn('id', $request->booking_ids)->delete();
                }
                break;

            case 'status':
                if ($request->status) {
                    $deletedCount = Booking::where('status', $request->status)->delete();
                }
                break;

            case 'old':
                $months = $request->months_old ?? 6;
                $deletedCount = Booking::where('date', '<', now()->subMonths($months))->delete();
                break;

            case 'all':
                $deletedCount = Booking::truncate();
                $deletedCount = 'all';
                break;
        }

        $message = $deletedCount === 'all' 
            ? 'All bookings have been deleted successfully.' 
            : "{$deletedCount} booking(s) deleted successfully.";

        return redirect()->route('admin.settings.index')
            ->with('success', $message);
    }

    /**
     * Update display settings.
     */
    public function updateDisplay(Request $request)
    {
        $request->validate([
            'items_per_page' => 'required|integer|in:10,15,20,25,50,100',
            'default_currency' => 'required|string|in:USD,IDR,EUR',
            'date_format' => 'required|string|in:d/m/Y,m/d/Y,Y-m-d,d M Y',
            'enable_animations' => 'boolean',
            'show_stats_cards' => 'boolean',
            'sidebar_style' => 'required|in:default,compact',
            'theme_color' => 'required|in:emerald,blue,purple,red,orange',
        ]);

        $settings = [
            'items_per_page' => $request->items_per_page,
            'default_currency' => $request->default_currency,
            'date_format' => $request->date_format,
            'enable_animations' => $request->boolean('enable_animations'),
            'show_stats_cards' => $request->boolean('show_stats_cards'),
            'sidebar_style' => $request->sidebar_style,
            'theme_color' => $request->theme_color,
        ];

        // Store in cache (or you can use database)
        Cache::forever('admin_display_settings', $settings);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Display settings updated successfully.');
    }

    /**
     * Get display settings from cache or defaults.
     */
    private function getDisplaySettings(): array
    {
        return Cache::get('admin_display_settings', [
            'items_per_page' => 15,
            'default_currency' => 'USD',
            'date_format' => 'd M Y',
            'enable_animations' => true,
            'show_stats_cards' => true,
            'sidebar_style' => 'default',
            'theme_color' => 'emerald',
        ]);
    }

    /**
     * Get bookings for AJAX selection.
     */
    public function getBookings(Request $request)
    {
        $query = Booking::with(['tour', 'package', 'user'])
            ->orderBy('created_at', 'desc');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('full_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $bookings = $query->paginate(20);

        return response()->json($bookings);
    }

    /**
     * Clear all cache.
     */
    public function clearCache()
    {
        Cache::flush();

        return redirect()->route('admin.settings.index')
            ->with('success', 'All cache cleared successfully.');
    }
}
