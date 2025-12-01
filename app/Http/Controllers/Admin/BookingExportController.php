<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Helpers\LanguageHelper;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingExportController extends Controller
{
    public function export(Request $request)
    {
        $query = Booking::with(['user', 'tour', 'tour.destination', 'package']);
        
        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'ILIKE', "%{$search}%");
                })
                ->orWhereHas('tour', function($q) use ($search) {
                    $q->where('name_id', 'ILIKE', "%{$search}%")
                      ->orWhere('name_en', 'ILIKE', "%{$search}%")
                      ->orWhere('name_zh', 'ILIKE', "%{$search}%");
                })
                ->orWhereHas('package', function($q) use ($search) {
                    $q->where('name_id', 'ILIKE', "%{$search}%")
                      ->orWhere('name_en', 'ILIKE', "%{$search}%")
                      ->orWhere('name_zh', 'ILIKE', "%{$search}%");
                })
                ->orWhere('full_name', 'ILIKE', "%{$search}%")
                ->orWhere('email', 'ILIKE', "%{$search}%");
            });
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }
        
        $bookings = $query->latest()->get();
        
        $filename = 'bookings_report_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
        
        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for Excel UTF-8 compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header row
            fputcsv($file, [
                'Booking ID',
                'Type',
                'Tour/Package Name',
                'Destination',
                'Customer Name',
                'Customer Email',
                'Customer Phone',
                'Guest Type',
                'Travel Date',
                'Number of Guests',
                'Price per Person (USD)',
                'Total Price (USD)',
                'Status',
                'Payment Status',
                'Notes',
                'Booking Date',
            ]);
            
            // Data rows
            foreach ($bookings as $booking) {
                // Determine type and name
                $type = $booking->tour_id ? 'Tour' : ($booking->package_id ? 'Package' : 'Unknown');
                
                if ($booking->tour) {
                    $name = LanguageHelper::get($booking->tour, 'name');
                    $destination = $booking->tour->destination ? LanguageHelper::get($booking->tour->destination, 'name') : '-';
                } elseif ($booking->package) {
                    $name = LanguageHelper::get($booking->package, 'name');
                    $destination = '-';
                } else {
                    $name = '-';
                    $destination = '-';
                }
                
                // Customer info
                $customerName = $booking->user->name ?? $booking->full_name ?? 'Guest';
                $customerEmail = $booking->user->email ?? $booking->email ?? '-';
                $customerPhone = $booking->user->phone ?? $booking->phone ?? '-';
                $guestType = $booking->user_id ? 'Registered' : 'Guest';
                
                fputcsv($file, [
                    $booking->id,
                    $type,
                    $name,
                    $destination,
                    $customerName,
                    $customerEmail,
                    $customerPhone,
                    $guestType,
                    $booking->date ? $booking->date->format('Y-m-d') : '-',
                    $booking->guests ?? 1,
                    number_format($booking->price_per_person ?? 0, 2, '.', ''),
                    number_format($booking->total_price ?? 0, 2, '.', ''),
                    ucfirst($booking->status ?? 'pending'),
                    ucfirst($booking->payment_status ?? 'unpaid'),
                    $booking->notes ?? '-',
                    $booking->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };
        
        return new StreamedResponse($callback, 200, $headers);
    }
    
    public function exportExcel(Request $request)
    {
        $query = Booking::with(['user', 'tour', 'tour.destination', 'package']);
        
        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'ILIKE', "%{$search}%");
                })
                ->orWhereHas('tour', function($q) use ($search) {
                    $q->where('name_id', 'ILIKE', "%{$search}%")
                      ->orWhere('name_en', 'ILIKE', "%{$search}%")
                      ->orWhere('name_zh', 'ILIKE', "%{$search}%");
                })
                ->orWhereHas('package', function($q) use ($search) {
                    $q->where('name_id', 'ILIKE', "%{$search}%")
                      ->orWhere('name_en', 'ILIKE', "%{$search}%")
                      ->orWhere('name_zh', 'ILIKE', "%{$search}%");
                })
                ->orWhere('full_name', 'ILIKE', "%{$search}%")
                ->orWhere('email', 'ILIKE', "%{$search}%");
            });
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }
        
        $bookings = $query->latest()->get();
        
        $filename = 'bookings_report_' . date('Y-m-d_His') . '.xls';
        
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
        
        $callback = function() use ($bookings) {
            echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">' . "\n";
            echo '<Styles>';
            echo '<Style ss:ID="header"><Font ss:Bold="1" ss:Size="12"/><Interior ss:Color="#4F81BD" ss:Pattern="Solid"/><Font ss:Color="#FFFFFF"/></Style>';
            echo '<Style ss:ID="tour"><Interior ss:Color="#E2EFDA" ss:Pattern="Solid"/></Style>';
            echo '<Style ss:ID="package"><Interior ss:Color="#FCE4D6" ss:Pattern="Solid"/></Style>';
            echo '<Style ss:ID="confirmed"><Font ss:Color="#006400"/></Style>';
            echo '<Style ss:ID="pending"><Font ss:Color="#DAA520"/></Style>';
            echo '<Style ss:ID="cancelled"><Font ss:Color="#DC143C"/></Style>';
            echo '<Style ss:ID="completed"><Font ss:Color="#0000CD"/></Style>';
            echo '<Style ss:ID="currency"><NumberFormat ss:Format="$#,##0.00"/></Style>';
            echo '</Styles>';
            
            echo '<Worksheet ss:Name="Bookings Report">' . "\n";
            echo '<Table>' . "\n";
            
            // Column widths
            echo '<Column ss:Width="60"/>';  // ID
            echo '<Column ss:Width="70"/>';  // Type
            echo '<Column ss:Width="200"/>';  // Name
            echo '<Column ss:Width="150"/>';  // Destination
            echo '<Column ss:Width="150"/>';  // Customer Name
            echo '<Column ss:Width="180"/>';  // Email
            echo '<Column ss:Width="120"/>';  // Phone
            echo '<Column ss:Width="80"/>';  // Guest Type
            echo '<Column ss:Width="100"/>';  // Travel Date
            echo '<Column ss:Width="60"/>';  // Guests
            echo '<Column ss:Width="100"/>';  // Price/Person
            echo '<Column ss:Width="100"/>';  // Total
            echo '<Column ss:Width="80"/>';  // Status
            echo '<Column ss:Width="100"/>';  // Payment
            echo '<Column ss:Width="200"/>';  // Notes
            echo '<Column ss:Width="140"/>';  // Booking Date
            
            // Header row
            echo '<Row ss:StyleID="header">' . "\n";
            $headers = [
                'Booking ID', 'Type', 'Tour/Package Name', 'Destination',
                'Customer Name', 'Customer Email', 'Customer Phone', 'Guest Type',
                'Travel Date', 'Guests', 'Price/Person (USD)', 'Total (USD)',
                'Status', 'Payment Status', 'Notes', 'Booking Date'
            ];
            foreach ($headers as $header) {
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($header) . '</Data></Cell>';
            }
            echo '</Row>' . "\n";
            
            // Data rows
            foreach ($bookings as $booking) {
                $type = $booking->tour_id ? 'Tour' : ($booking->package_id ? 'Package' : 'Unknown');
                $rowStyle = $booking->tour_id ? 'tour' : 'package';
                
                if ($booking->tour) {
                    $name = LanguageHelper::get($booking->tour, 'name');
                    $destination = $booking->tour->destination ? LanguageHelper::get($booking->tour->destination, 'name') : '-';
                } elseif ($booking->package) {
                    $name = LanguageHelper::get($booking->package, 'name');
                    $destination = '-';
                } else {
                    $name = '-';
                    $destination = '-';
                }
                
                $customerName = $booking->user->name ?? $booking->full_name ?? 'Guest';
                $customerEmail = $booking->user->email ?? $booking->email ?? '-';
                $customerPhone = $booking->user->phone ?? $booking->phone ?? '-';
                $guestType = $booking->user_id ? 'Registered' : 'Guest';
                
                $statusStyle = match($booking->status) {
                    'confirmed' => 'confirmed',
                    'pending' => 'pending',
                    'cancelled' => 'cancelled',
                    'completed' => 'completed',
                    default => ''
                };
                
                echo '<Row ss:StyleID="' . $rowStyle . '">' . "\n";
                echo '<Cell><Data ss:Type="Number">' . $booking->id . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($type) . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($name) . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($destination) . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($customerName) . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($customerEmail) . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($customerPhone) . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($guestType) . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . ($booking->date ? $booking->date->format('Y-m-d') : '-') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="Number">' . ($booking->guests ?? 1) . '</Data></Cell>';
                echo '<Cell ss:StyleID="currency"><Data ss:Type="Number">' . ($booking->price_per_person ?? 0) . '</Data></Cell>';
                echo '<Cell ss:StyleID="currency"><Data ss:Type="Number">' . ($booking->total_price ?? 0) . '</Data></Cell>';
                echo '<Cell ss:StyleID="' . $statusStyle . '"><Data ss:Type="String">' . ucfirst($booking->status ?? 'pending') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . ucfirst($booking->payment_status ?? 'unpaid') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($booking->notes ?? '-') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . $booking->created_at->format('Y-m-d H:i:s') . '</Data></Cell>';
                echo '</Row>' . "\n";
            }
            
            // Summary section
            echo '<Row></Row>' . "\n";
            echo '<Row><Cell ss:MergeAcross="3" ss:StyleID="header"><Data ss:Type="String">SUMMARY REPORT</Data></Cell></Row>' . "\n";
            
            $totalBookings = $bookings->count();
            $tourBookings = $bookings->where('tour_id', '!=', null)->count();
            $packageBookings = $bookings->where('package_id', '!=', null)->count();
            $totalRevenue = $bookings->sum('total_price');
            $confirmedRevenue = $bookings->whereIn('status', ['confirmed', 'completed'])->sum('total_price');
            
            echo '<Row><Cell><Data ss:Type="String">Total Bookings:</Data></Cell><Cell><Data ss:Type="Number">' . $totalBookings . '</Data></Cell></Row>';
            echo '<Row><Cell><Data ss:Type="String">Tour Bookings:</Data></Cell><Cell ss:StyleID="tour"><Data ss:Type="Number">' . $tourBookings . '</Data></Cell></Row>';
            echo '<Row><Cell><Data ss:Type="String">Package Bookings:</Data></Cell><Cell ss:StyleID="package"><Data ss:Type="Number">' . $packageBookings . '</Data></Cell></Row>';
            echo '<Row><Cell><Data ss:Type="String">Total Revenue:</Data></Cell><Cell ss:StyleID="currency"><Data ss:Type="Number">' . $totalRevenue . '</Data></Cell></Row>';
            echo '<Row><Cell><Data ss:Type="String">Confirmed Revenue:</Data></Cell><Cell ss:StyleID="currency"><Data ss:Type="Number">' . $confirmedRevenue . '</Data></Cell></Row>';
            
            // Status breakdown
            echo '<Row></Row>' . "\n";
            echo '<Row><Cell><Data ss:Type="String">Status Breakdown:</Data></Cell></Row>';
            echo '<Row><Cell><Data ss:Type="String">- Pending:</Data></Cell><Cell><Data ss:Type="Number">' . $bookings->where('status', 'pending')->count() . '</Data></Cell></Row>';
            echo '<Row><Cell><Data ss:Type="String">- Confirmed:</Data></Cell><Cell><Data ss:Type="Number">' . $bookings->where('status', 'confirmed')->count() . '</Data></Cell></Row>';
            echo '<Row><Cell><Data ss:Type="String">- Completed:</Data></Cell><Cell><Data ss:Type="Number">' . $bookings->where('status', 'completed')->count() . '</Data></Cell></Row>';
            echo '<Row><Cell><Data ss:Type="String">- Cancelled:</Data></Cell><Cell><Data ss:Type="Number">' . $bookings->where('status', 'cancelled')->count() . '</Data></Cell></Row>';
            
            echo '</Table>' . "\n";
            echo '</Worksheet>' . "\n";
            echo '</Workbook>';
        };
        
        return new StreamedResponse($callback, 200, $headers);
    }
}
