<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DebugController extends Controller
{
    /**
     * Return the last N lines of the laravel.log as JSON.
     * Accessible only to admin routes (route registered under admin middleware).
     */
    public function laravelLog(Request $request)
    {
        $limit = (int) $request->query('limit', 200);
        $file = storage_path('logs/laravel.log');

        if (!file_exists($file)) {
            return response()->json(['error' => 'Log file not found'], 404);
        }

        try {
            $lines = $this->tailFile($file, $limit);
            return response()->json(['lines' => $lines]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to read log: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Efficiently read last $lines from $file.
     * Adapted for portability without relying on `tail` binary.
     */
    private function tailFile(string $file, int $lines = 200): array
    {
        $handle = fopen($file, 'r');
        if ($handle === false) {
            throw new \RuntimeException('Unable to open log file');
        }

        $buffer = '';
        $chunkSize = 4096;
        $pos = -1;
        $lineCount = 0;
        $fileSize = filesize($file);

        if ($fileSize === 0) {
            fclose($handle);
            return [];
        }

        // Seek from the end and read backwards until we have enough lines
        while ($lineCount <= $lines && abs($pos) <= $fileSize) {
            $seek = fseek($handle, $pos, SEEK_END);
            if ($seek === 0) {
                $char = fgetc($handle);
                $buffer = $char . $buffer;
                if ($char === "\n") {
                    $lineCount++;
                }
                $pos--;
            } else {
                break;
            }
        }

        // If we reached start of file, rewind and read all
        if (abs($pos) > $fileSize) {
            rewind($handle);
            $buffer = stream_get_contents($handle);
        }

        fclose($handle);

        $allLines = preg_split('/\r\n|\n|\r/', trim($buffer));
        // Return the last $lines (or fewer if file has less)
        $start = max(0, count($allLines) - $lines);
        return array_slice($allLines, $start);
    }
}
