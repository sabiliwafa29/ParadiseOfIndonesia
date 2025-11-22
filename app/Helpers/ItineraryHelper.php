<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

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
                
                // Get description based on locale
                $locale = App::getLocale();
                $description = $activity['description_' . $locale]
                    ?? $activity['description_id']
                    ?? $activity['description_en']
                    ?? $activity['description']
                    ?? '';
                
                // If still empty, try to implode string values
                if (empty($description) && !empty($activity)) {
                    $description = implode(' ', array_filter($activity, 'is_string'));
                }
                
                return compact('time', 'description');
            }

            // Case 2: Activity adalah string
            $activityStr = trim(strval($activity));

            // Format 1: [HH:MM – HH:MM] atau [HH:MM] dengan bracket (support dash dan en-dash)
            if (preg_match('/^\[(\d{1,2}[:.]\d{2}\s*[–\-]\s*\d{1,2}[:.]\d{2}|\d{1,2}[:.]\d{2})\]\s*(.*)$/u', $activityStr, $matches)) {
                $time = trim($matches[1]);
                $description = trim($matches[2]);
            }
            // Format 2: HH:MM – HH:MM: atau HH:MM: (tanpa bracket, with colon after time)
            elseif (preg_match('/^(\d{1,2}[:.]\d{2}\s*[–\-]\s*\d{1,2}[:.]\d{2}|\d{1,2}[:.]\d{2})\s*[:\-–]\s*(.+)$/u', $activityStr, $matches)) {
                $time = trim($matches[1]);
                $description = trim($matches[2]);
            }
            // Format 3: -> HH:MM atau arrow prefix
            elseif (preg_match('/^(?:->|→)\s*(\d{1,2}[:.]\d{2}(?:\s*[–\-]\s*\d{1,2}[:.]\d{2})?)\s*[:\-–]?\s*(.*)$/u', $activityStr, $matches)) {
                $time = trim($matches[1]);
                $description = trim($matches[2]);
            }
            // Format 4: HH:MM di awal tanpa separator (misal: "08:00 Breakfast")
            elseif (preg_match('/^(\d{1,2}[:.]\d{2})\s+([A-Za-z].*)$/u', $activityStr, $matches)) {
                $time = trim($matches[1]);
                $description = trim($matches[2]);
            }
            // Format 5: Plain text (no time)
            else {
                $description = $activityStr;
            }

        } catch (\Exception $e) {
            Log::error('ItineraryHelper::parseActivity error: ' . $e->getMessage());
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

    /**
     * Parse complete itinerary data from database
     * Handles both string (JSON) and array formats
     * 
     * @param mixed $itinerary Raw itinerary data from database
     * @return array Parsed and filtered itinerary array
     */
    public static function parseItinerary($itinerary): array
    {
        try {
            // Safety check: ensure itinerary is not null
            if (empty($itinerary)) {
                return [];
            }
            
            // If JSON string, decode with error handling
            if (is_string($itinerary)) {
                $decoded = json_decode($itinerary, true);
                // Check if json_decode succeeded and result is array
                $itinerary = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [$itinerary];
            }
            
            // Ensure it's an array, if not convert to array
            if (!is_array($itinerary)) {
                $itinerary = [$itinerary];
            }
            
            // Filter empty values and reindex
            return array_values(array_filter($itinerary, function($item) {
                return !empty($item);
            }));
            
        } catch (\Exception $e) {
            Log::error('ItineraryHelper::parseItinerary error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Parse single day data from itinerary
     * Extracts day title and activities list
     * 
     * @param mixed $dayData Raw day data
     * @param int $dayIndex Zero-based index of the day
     * @return array ['title' => string, 'activities' => array]
     */
    public static function parseDayData($dayData, int $dayIndex): array
    {
        try {
            $dayTitle = 'DAY ' . ($dayIndex + 1);
            $activities = [];
            $locale = App::getLocale();
            
            // Case 1: Array with 'day' and 'activities' structure
            if (is_array($dayData) && isset($dayData['day'])) {
                // Handle multilingual day title
                if (is_array($dayData['day'])) {
                    $dayTitle = $dayData['day'][$locale]
                        ?? $dayData['day']['id']
                        ?? $dayData['day']['en']
                        ?? 'DAY ' . ($dayIndex + 1);
                } else {
                    $dayTitle = $dayData['day'];
                }
                
                if (isset($dayData['activities'])) {
                    if (is_array($dayData['activities'])) {
                        $activities = $dayData['activities'];
                    } elseif (is_string($dayData['activities'])) {
                        $activities = [$dayData['activities']];
                    }
                }
            } 
            // Case 2: Array with 'description' key
            elseif (is_array($dayData) && isset($dayData['description'])) {
                $activities = [strval($dayData['description'])];
            }
            // Case 3: Plain array (list of activities)
            elseif (is_array($dayData)) {
                $activities = array_values($dayData);
            }
            // Case 4: Direct string
            else {
                $activities = [strval($dayData)];
            }
            
            // Filter empty activities
            $activities = array_filter($activities, function($act) {
                return !empty($act);
            });
            
            // Log warning if no activities found
            if (empty($activities)) {
                Log::warning('ItineraryHelper: Empty activities for day ' . $dayTitle);
            }
            
            return [
                'title' => $dayTitle,
                'activities' => array_values($activities)
            ];
            
        } catch (\Exception $e) {
            Log::error('ItineraryHelper::parseDayData error: ' . $e->getMessage() . ' | Day index: ' . $dayIndex . ' | Data: ' . json_encode($dayData));
            return [
                'title' => 'DAY ' . ($dayIndex + 1),
                'activities' => []
            ];
        }
    }
}