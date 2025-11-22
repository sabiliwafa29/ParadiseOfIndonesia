<?php

namespace App\Helpers;

class ItineraryHelper
{
    /**
     * Supported time formats for itinerary activities
     */
    const SUPPORTED_FORMATS = [
        '[08:00 - 10:00] Activity description',
        '[08:00] Activity description',
        '08:00 - 10:00: Activity description',
        '08:00: Activity description',
        '-> 08:00 - 10:00: Activity description',
        '-> 08:00: Activity description',
        '08:00 – 10:00: Activity description',
        'Plain activity description (no time)',
    ];

    /**
     * Parse activity string and extract time and description
     */
    public static function parseActivity($activity): array
    {
        $time = '';
        $description = '';

        try {
            // Safety check
            if (empty($activity)) {
                return compact('time', 'description');
            }

            // Case 1: Activity adalah array
            if (is_array($activity)) {
                $time = $activity['time'] ?? '';
                $description = $activity['description'] ?? '';
                
                if (empty($description) && !empty($activity)) {
                    $description = implode(' ', array_filter($activity, 'is_string'));
                }
                
                return compact('time', 'description');
            }

            // Case 2: Activity adalah string
            $activityStr = trim(strval($activity));

            // Format 1: [HH:MM - HH:MM] atau [HH:MM]
            if (preg_match('/^\[?([\d:]+(?:\s*[-–]\s*[\d:]+)?)\]?:?\s*(.*)$/i', $activityStr, $matches)) {
                $time = trim($matches[1]);
                $description = trim($matches[2]);
            }
            // Format 2: -> HH:MM - HH:MM: atau HH:MM:
            elseif (preg_match('/^->?\s*([\d:]+(?:\s*[-–]\s*[\d:]+)?):?\s*(.*)$/i', $activityStr, $matches)) {
                $time = trim($matches[1]);
                $description = trim($matches[2]);
            }
            // Format 3: Plain text
            else {
                $description = $activityStr;
            }

        } catch (\Exception $e) {
            \Log::error('ItineraryHelper::parseActivity error: ' . $e->getMessage());
        }

        return compact('time', 'description');
    }

    /**
     * Validate itinerary format
     */
    public static function validate($itinerary): array
    {
        $errors = [];
        
        if (empty($itinerary)) {
            $errors[] = 'Itinerary is empty';
            return $errors;
        }

        // Convert to array if needed
        if (is_string($itinerary)) {
            $decoded = json_decode($itinerary, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $errors[] = 'Invalid JSON format: ' . json_last_error_msg();
                return $errors;
            }
            $itinerary = $decoded;
        }

        if (!is_array($itinerary)) {
            $errors[] = 'Itinerary must be an array';
            return $errors;
        }

        // Validate each day
        foreach ($itinerary as $dayIndex => $dayData) {
            if (empty($dayData)) {
                $errors[] = "Day {$dayIndex} is empty";
                continue;
            }

            // Check for activities
            $activities = [];
            if (is_array($dayData) && isset($dayData['activities'])) {
                $activities = is_array($dayData['activities']) 
                    ? $dayData['activities'] 
                    : [$dayData['activities']];
            } elseif (is_array($dayData)) {
                $activities = $dayData;
            } else {
                $activities = [$dayData];
            }

            if (empty(array_filter($activities))) {
                $errors[] = "Day {$dayIndex} has no valid activities";
            }
        }

        return $errors;
    }

    /**
     * Get supported formats documentation
     */
    public static function getSupportedFormats(): array
    {
        return self::SUPPORTED_FORMATS;
    }
}