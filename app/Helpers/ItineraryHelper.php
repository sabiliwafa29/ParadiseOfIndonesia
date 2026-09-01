<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ItineraryHelper
{
    public const SUPPORTED_FORMATS = [
        '[08:00 - 10:00] Activity description',
        '[08:00] Activity description',
        '08:00 - 10:00: Activity description',
        '08:00: Activity description',
        '-> 08:00 - 10:00: Activity description',
        '-> 08:00: Activity description',
        'Plain activity description (no time)',
    ];

    public static function parseActivity($activity): array
    {
        $time = '';
        $description = '';
        $note = '';

        try {
            if (empty($activity)) {
                return compact('time', 'description');
            }

            if (is_array($activity)) {
                return self::parseArrayActivity($activity);
            }

            $activityStr = trim(strval($activity));
            $result = self::parseStringActivity($activityStr);

            $time = $result['time'];
            $description = $result['description'];
            $note = $result['note'];
        } catch (\Exception $e) {
            Log::error('ItineraryHelper::parseActivity error: ' . $e->getMessage());
        }

        return compact('time', 'description', 'note');
    }

    protected static function parseArrayActivity(array $activity): array
    {
        $time = $activity['time'] ?? '';
        $locale = App::getLocale();
        $description = $activity['description_' . $locale]
            ?? $activity['description_id']
            ?? $activity['description_en']
            ?? $activity['description']
            ?? '';

        if (empty($description) && !empty($activity)) {
            $description = implode(' ', array_filter($activity, 'is_string'));
        }

        return ['time' => $time, 'description' => $description];
    }

    protected static function parseStringActivity(string $activityStr): array
    {
        $time = '';
        $description = $activityStr;

        $result = self::matchTimeFormats($activityStr);
        if ($result) {
            $time = $result['time'];
            $description = $result['description'];
        }

        if (!empty($description)) {
            $noteResult = self::extractNoteFromText($description);
            $description = $noteResult['description'];
            $note = $noteResult['note'];
        }

        return compact('time', 'description', 'note');
    }

    protected static function matchTimeFormats(string $activityStr): ?array
    {
        if (preg_match('/^\[([^\]]+)\]\s*(.*)$/us', $activityStr, $matches)) {
            $potentialTime = trim($matches[1]);
            $potentialDesc = trim($matches[2]);

            if (preg_match('/[A-Za-z]/u', $potentialTime)) {
                return ['time' => $potentialTime, 'description' => $potentialDesc];
            }

            if (preg_match('/\d{1,2}[:.]\d{2}/', $potentialTime)) {
                return ['time' => $potentialTime, 'description' => $potentialDesc];
            }
        }

        if (preg_match('/^(\d{1,2}[:.]\d{2}\s*[–\-]\s*\d{1,2}[:.]\d{2}|\d{1,2}[:.]\d{2})\s*[:\-–]\s*(.+)$/u', $activityStr, $matches)) {
            return ['time' => trim($matches[1]), 'description' => trim($matches[2])];
        }

        if (preg_match('/^(?:->|→)\s*(\d{1,2}[:.]\d{2}(?:\s*[–\-]\s*\d{1,2}[:.]\d{2})?)\s*[:\-–]?\s*(.*)$/u', $activityStr, $matches)) {
            return ['time' => trim($matches[1]), 'description' => trim($matches[2])];
        }

        if (preg_match('/^(\d{1,2}[:.]\d{2})\s+([A-Za-z].*)$/u', $activityStr, $matches)) {
            return ['time' => trim($matches[1]), 'description' => trim($matches[2])];
        }

        return null;
    }

    protected static function extractNoteFromText(string $description): array
    {
        $note = '';

        if (preg_match('/(.*?)[\.\s]+(Note|Catatan|Hinweis|注意):\s*(.+)$/uis', $description, $noteMatches)) {
            $description = trim($noteMatches[1]);
            $note = trim($noteMatches[3]);
        }

        return ['description' => $description, 'note' => $note];
    }

    public static function validate($itinerary): array
    {
        $errors = [];

        if (empty($itinerary)) {
            $errors[] = 'Itinerary is empty';
            return $errors;
        }

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

        foreach ($itinerary as $dayIndex => $dayData) {
            if (empty($dayData)) {
                $errors[] = "Day {$dayIndex} is empty";
                continue;
            }

            $activities = self::extractActivitiesFromDay($dayData);

            if (empty(array_filter($activities))) {
                $errors[] = "Day {$dayIndex} has no valid activities";
            }
        }

        return $errors;
    }

    protected static function extractActivitiesFromDay($dayData): array
    {
        if (is_array($dayData) && isset($dayData['activities'])) {
            return is_array($dayData['activities'])
                ? $dayData['activities']
                : [$dayData['activities']];
        }

        if (is_array($dayData)) {
            return $dayData;
        }

        return [$dayData];
    }

    public static function getSupportedFormats(): array
    {
        return self::SUPPORTED_FORMATS;
    }

    public static function parseItinerary($itinerary): array
    {
        try {
            if (empty($itinerary)) {
                return [];
            }

            if (is_string($itinerary)) {
                $decoded = json_decode($itinerary, true);
                $itinerary = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [$itinerary];
            }

            if (!is_array($itinerary)) {
                $itinerary = [$itinerary];
            }

            return array_values(array_filter($itinerary, fn($item) => !empty($item)));
        } catch (\Exception $e) {
            Log::error('ItineraryHelper::parseItinerary error: ' . $e->getMessage());

            return [];
        }
    }

    public static function parseDayData($dayData, int $dayIndex): array
    {
        try {
            $dayTitle = 'DAY ' . ($dayIndex + 1);
            $activities = [];
            $note = '';
            $locale = App::getLocale();

            if (is_array($dayData) && isset($dayData['day'])) {
                $dayTitle = self::getMultilingualValue($dayData['day'], $locale);

                if (isset($dayData['activities'])) {
                    $activities = is_array($dayData['activities'])
                        ? $dayData['activities']
                        : self::splitMultiActivityString($dayData['activities']);
                }

                if (isset($dayData['note'])) {
                    $note = self::getMultilingualValue($dayData['note'], $locale);
                }
            } elseif (is_array($dayData) && (isset($dayData['title_id']) || isset($dayData['title_en']))) {
                $dayTitle = self::extractMultilingualTitle($dayData, $locale);

                $desc = self::getMultilingualValue(
                    $dayData['description_' . $locale] ?? $dayData['description_id'] ?? $dayData['description_en'] ?? $dayData['description'] ?? '',
                    $locale
                );

                if (!empty($desc)) {
                    $separated = self::separateNotesFromActivities($desc);
                    $activities = self::splitMultiActivityString($separated['activities']);
                    $note = $separated['note'];
                }

                if (empty($note)) {
                $note = $dayData['note_' . $locale] ?? $dayData['note_id'] ?? $dayData['note_en'] ?? null;
            }
            } elseif (is_array($dayData) && isset($dayData['description'])) {
                $desc = strval($dayData['description']);
                $activities = preg_match_all('/\[[^\]]+\]/u', $desc) > 1
                    ? self::splitMultiActivityString($desc)
                    : [$desc];
            } elseif (is_array($dayData)) {
                $activities = array_values($dayData);
            } else {
                $stringData = strval($dayData);
                $activities = preg_match_all('/\[[^\]]+\]/u', $stringData) > 1
                    ? self::splitMultiActivityString($stringData)
                    : [$stringData];
            }

            $activities = array_filter($activities, fn($act) => !empty($act));

            if (empty($activities)) {
                Log::warning('ItineraryHelper: Empty activities for day ' . $dayTitle);
            }

            return [
                'title' => $dayTitle,
                'activities' => array_values($activities),
                'note' => $note,
            ];
        } catch (\Exception $e) {
            Log::error('ItineraryHelper::parseDayData error: ' . $e->getMessage());

            return [
                'title' => 'DAY ' . ($dayIndex + 1),
                'activities' => [],
                'note' => '',
            ];
        }
    }

    protected static function getMultilingualValue($value, string $locale): string
    {
        if (is_array($value)) {
            return $value[$locale] ?? $value['id'] ?? $value['en'] ?? $value['zh'] ?? '';
        }

        return strval($value);
    }

    protected static function extractMultilingualTitle(array $data, string $locale): string
    {
        return $data['title_' . $locale] ?? $data['title_id'] ?? $data['title_en'] ?? $data['title_zh'] ?? 'DAY ' . ($data['day_index'] ?? 1);
    }

    protected static function separateNotesFromActivities(string $desc): array
    {
        $lines = explode("\n\n", $desc);
        $activities = [];
        $noteLines = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (preg_match('/^\[/', $line)) {
                $activities[] = $line;
            } else {
                $noteLines[] = $line;
            }
        }

        return [
            'activities' => implode("\n\n", $activities),
            'note' => implode("\n\n", $noteLines),
        ];
    }

    protected static function splitMultiActivityString(string $activityString): array
    {
        $activities = preg_split('/\n\n+(?=\[)/u', trim($activityString));

        if (count($activities) === 1) {
            $activities = preg_split('/\n(?=\[)/u', trim($activityString));
        }

        return array_values(array_filter(array_map('trim', $activities), fn($act) => !empty($act)));
    }
}