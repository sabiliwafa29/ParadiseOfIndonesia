<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Helpers\LanguageHelper;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingExportController extends Controller
{
    protected function getFilteredBookings(Request $request)
    {
        $query = Booking::with(['user', 'tour', 'tour.destination', 'package']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('tour', fn($q) => $q->where('name_id', 'like', "%{$search}%")
                        ->orWhere('name_en', 'like', "%{$search}%")
                        ->orWhere('name_zh', 'like', "%{$search}%"))
                    ->orWhereHas('package', fn($q) => $q->where('name_id', 'like', "%{$search}%")
                        ->orWhere('name_en', 'like', "%{$search}%")
                        ->orWhere('name_zh', 'like', "%{$search}%"))
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        return $query->latest()->get();
    }

    public function export(Request $request)
    {
        $bookings = $this->getFilteredBookings($request);
        $filename = 'bookings_report_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = fn() => $this->streamCsv($bookings);

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportExcel(Request $request)
    {
        $bookings = $this->getFilteredBookings($request);
        $filename = 'bookings_report_' . date('Y-m-d_His') . '.xls';

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = fn() => $this->streamExcel($bookings);

        return new StreamedResponse($callback, 200, $headers);
    }

    protected function streamCsv($bookings): void
    {
        $file = fopen('php://output', 'w');
        fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($file, $this->getCsvHeaders());

        foreach ($bookings as $booking) {
            fputcsv($file, $this->formatCsvRow($booking));
        }

        fclose($file);
    }

    protected function streamExcel($bookings): void
    {
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">' . "\n";
        echo $this->getExcelStyles();
        echo '<Worksheet ss:Name="Bookings Report">' . "\n";
        echo '<Table>' . "\n";
        echo $this->getExcelColumnWidths();
        echo $this->getExcelHeaderRow();

        foreach ($bookings as $booking) {
            echo $this->getExcelDataRow($booking);
        }

        echo $this->getExcelSummary($bookings);
        echo '</Table></Worksheet></Workbook>';
    }

    protected function getCsvHeaders(): array
    {
        return [
            'Booking ID', 'Type', 'Tour/Package Name', 'Destination',
            'Customer Name', 'Customer Email', 'Customer Phone', 'Guest Type',
            'Travel Date', 'Number of Guests', 'Price per Person (USD)', 'Total Price (USD)',
            'Status', 'Payment Status', 'Notes', 'Booking Date',
        ];
    }

    protected function formatCsvRow($booking): array
    {
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

        $customerName = $booking->user->name ?? $booking->full_name ?? 'Guest';
        $customerEmail = $booking->user->email ?? $booking->email ?? '-';
        $customerPhone = $booking->user->phone ?? $booking->phone ?? '-';
        $guestType = $booking->user_id ? 'Registered' : 'Guest';

        return [
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
        ];
    }

    protected function getExcelStyles(): string
    {
        return '<Styles>'
            . '<Style ss:ID="header"><Font ss:Bold="1" ss:Size="12"/><Interior ss:Color="#4F81BD" ss:Pattern="Solid"/><Font ss:Color="#FFFFFF"/></Style>'
            . '<Style ss:ID="tour"><Interior ss:Color="#E2EFDA" ss:Pattern="Solid"/></Style>'
            . '<Style ss:ID="package"><Interior ss:Color="#FCE4D6" ss:Pattern="Solid"/></Style>'
            . '<Style ss:ID="confirmed"><Font ss:Color="#006400"/></Style>'
            . '<Style ss:ID="pending"><Font ss:Color="#DAA520"/></Style>'
            . '<Style ss:ID="cancelled"><Font ss:Color="#DC143C"/></Style>'
            . '<Style ss:ID="completed"><Font ss:Color="#0000CD"/></Style>'
            . '<Style ss:ID="currency"><NumberFormat ss:Format="$#,##0.00"/></Style>'
            . '</Styles>';
    }

    protected function getExcelColumnWidths(): string
    {
        return '<Column ss:Width="60"/>'  . // ID
            '<Column ss:Width="70"/>'   . // Type
            '<Column ss:Width="200"/>' . // Name
            '<Column ss:Width="150"/>' . // Destination
            '<Column ss:Width="150"/>' . // Customer Name
            '<Column ss:Width="180"/>' . // Email
            '<Column ss:Width="120"/>' . // Phone
            '<Column ss:Width="80"/>'  . // Guest Type
            '<Column ss:Width="100"/>' . // Travel Date
            '<Column ss:Width="60"/>'  . // Guests
            '<Column ss:Width="100"/>' . // Price/Person
            '<Column ss:Width="100"/>' . // Total
            '<Column ss:Width="80"/>'  . // Status
            '<Column ss:Width="100"/>' . // Payment
            '<Column ss:Width="200"/>'; // Notes
    }

    protected function getExcelHeaderRow(): string
    {
        $headers = [
            'Booking ID', 'Type', 'Tour/Package Name', 'Destination',
            'Customer Name', 'Customer Email', 'Customer Phone', 'Guest Type',
            'Travel Date', 'Guests', 'Price/Person (USD)', 'Total (USD)',
            'Status', 'Payment Status', 'Notes', 'Booking Date',
        ];

        $cells = array_map(fn($h) => '<Cell><Data ss:Type="String">' . htmlspecialchars($h) . '</Data></Cell>', $headers);

        return '<Row ss:StyleID="header">' . implode('', $cells) . '</Row>' . "\n";
    }

    protected function getExcelDataRow($booking): string
    {
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

        return '<Row ss:StyleID="' . $rowStyle . '">'
            . '<Cell><Data ss:Type="Number">' . $booking->id . '</Data></Cell>'
            . '<Cell><Data ss:Type="String">' . htmlspecialchars($type) . '</Data></Cell>'
            . '<Cell><Data ss:Type="String">' . htmlspecialchars($name) . '</Data></Cell>'
            . '<Cell><Data ss:Type="String">' . htmlspecialchars($destination) . '</Data></Cell>'
            . '<Cell><Data ss:Type="String">' . htmlspecialchars($customerName) . '</Data></Cell>'
            . '<Cell><Data ss:Type="String">' . htmlspecialchars($customerEmail) . '</Data></Cell>'
            . '<Cell><Data ss:Type="String">' . htmlspecialchars($customerPhone) . '</Data></Cell>'
            . '<Cell><Data ss:Type="String">' . htmlspecialchars($guestType) . '</Data></Cell>'
            . '<Cell><Data ss:Type="String">' . ($booking->date ? $booking->date->format('Y-m-d') : '-') . '</Data></Cell>'
            . '<Cell><Data ss:Type="Number">' . ($booking->guests ?? 1) . '</Data></Cell>'
            . '<Cell ss:StyleID="currency"><Data ss:Type="Number">' . ($booking->price_per_person ?? 0) . '</Data></Cell>'
            . '<Cell ss:StyleID="currency"><Data ss:Type="Number">' . ($booking->total_price ?? 0) . '</Data></Cell>'
            . '<Cell ss:StyleID="' . $statusStyle . '"><Data ss:Type="String">' . ucfirst($booking->status ?? 'pending') . '</Data></Cell>'
            . '<Cell><Data ss:Type="String">' . ucfirst($booking->payment_status ?? 'unpaid') . '</Data></Cell>'
            . '<Cell><Data ss:Type="String">' . htmlspecialchars($booking->notes ?? '-') . '</Data></Cell>'
            . '<Cell><Data ss:Type="String">' . $booking->created_at->format('Y-m-d H:i:s') . '</Data></Cell>'
            . '</Row>' . "\n";
    }

    protected function getExcelSummary($bookings): string
    {
        $totalBookings = $bookings->count();
        $tourBookings = $bookings->where('tour_id', '!=', null)->count();
        $packageBookings = $bookings->where('package_id', '!=', null)->count();
        $totalRevenue = $bookings->sum('total_price');
        $confirmedRevenue = $bookings->whereIn('status', ['confirmed', 'completed'])->sum('total_price');

        return '<Row></Row>'
            . '<Row><Cell ss:MergeAcross="3" ss:StyleID="header"><Data ss:Type="String">SUMMARY REPORT</Data></Cell></Row>'
            . '<Row><Cell><Data ss:Type="String">Total Bookings:</Data></Cell><Cell><Data ss:Type="Number">' . $totalBookings . '</Data></Cell></Row>'
            . '<Row><Cell><Data ss:Type="String">Tour Bookings:</Data></Cell><Cell ss:StyleID="tour"><Data ss:Type="Number">' . $tourBookings . '</Data></Cell></Row>'
            . '<Row><Cell><Data ss:Type="String">Package Bookings:</Data></Cell><Cell ss:StyleID="package"><Data ss:Type="Number">' . $packageBookings . '</Data></Cell></Row>'
            . '<Row><Cell><Data ss:Type="String">Total Revenue:</Data></Cell><Cell ss:StyleID="currency"><Data ss:Type="Number">' . $totalRevenue . '</Data></Cell></Row>'
            . '<Row><Cell><Data ss:Type="String">Confirmed Revenue:</Data></Cell><Cell ss:StyleID="currency"><Data ss:Type="Number">' . $confirmedRevenue . '</Data></Cell></Row>'
            . '<Row></Row><Row><Cell><Data ss:Type="String">Status Breakdown:</Data></Cell></Row>'
            . '<Row><Cell><Data ss:Type="String">- Pending:</Data></Cell><Cell><Data ss:Type="Number">' . $bookings->where('status', 'pending')->count() . '</Data></Cell></Row>'
            . '<Row><Cell><Data ss:Type="String">- Confirmed:</Data></Cell><Cell><Data ss:Type="Number">' . $bookings->where('status', 'confirmed')->count() . '</Data></Cell></Row>'
            . '<Row><Cell><Data ss:Type="String">- Completed:</Data></Cell><Cell><Data ss:Type="Number">' . $bookings->where('status', 'completed')->count() . '</Data></Cell></Row>'
            . '<Row><Cell><Data ss:Type="String">- Cancelled:</Data></Cell><Cell><Data ss:Type="Number">' . $bookings->where('status', 'cancelled')->count() . '</Data></Cell></Row>';
    }
}