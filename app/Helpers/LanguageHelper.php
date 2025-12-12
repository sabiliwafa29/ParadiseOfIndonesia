<?php

namespace App\Helpers;

use App\Services\LocationService;

class LanguageHelper
{
    public static function getLanguages()
    {
        return [
            'en' => [
                'name' => 'English',
                'flag' => '🇬🇧',
                'native' => 'English',
                'currency' => 'USD',
                'currency_symbol' => '$'
            ],
            'id' => [
                'name' => 'Indonesian',
                'flag' => '🇮🇩',
                'native' => 'Indonesia',
                'currency' => 'IDR',
                'currency_symbol' => 'Rp'
            ],
            'zh' => [
                'name' => 'Chinese',
                'flag' => '🇨🇳',
                'native' => '中文',
                'currency' => 'CNY',
                'currency_symbol' => '¥'
            ],
        ];
    }
    
    public static function getCurrentLanguage()
    {
        $locale = app()->getLocale();
        $languages = self::getLanguages();
        return $languages[$locale] ?? $languages['en'];
    }

    public static function getCurrentCurrency()
    {
        // Prefer geolocation-based currency. If session or locale override required,
        // that can be implemented later. For now, choose by detected user location.
        return LocationService::getUserCurrency() ?? 'USD';
    }

    public static function getCurrencySymbol($locale = null)
    {
        // Map currency code to symbol. Use provided locale only as fallback for legacy.
        $currency = null;
        if ($locale) {
            $languages = self::getLanguages();
            $currency = $languages[$locale]['currency'] ?? null;
        }

        $currency = $currency ?? self::getCurrentCurrency();

        return match($currency) {
            'IDR' => 'Rp',
            'CNY' => '¥',
            'USD' => '$',
            default => '$',
        };
    }

    public static function formatPrice($amount, $locale = null)
    {
        // Determine currency from geolocation
        $currency = self::getCurrentCurrency();
        $symbol = self::getCurrencySymbol($locale);

        // Format based on currency
        switch ($currency) {
            case 'IDR':
                // No decimals for IDR, use dot as thousand separator
                return $symbol . ' ' . number_format($amount, 0, ',', '.');
            case 'CNY':
                return $symbol . number_format($amount, 2, '.', ',');
            case 'USD':
            default:
                return $symbol . number_format($amount, 2, '.', ',');
        }
    }

    /**
     * Format price by explicit currency code (useful for stored booking totals)
     *
     * @param float|int $amount
     * @param string $currencyCode e.g. 'IDR', 'USD', 'CNY'
     * @return string
     */
    public static function formatPriceByCurrency($amount, string $currencyCode)
    {
        $currency = strtoupper($currencyCode ?? 'USD');

        $symbol = match($currency) {
            'IDR' => 'Rp',
            'CNY' => '¥',
            'USD' => '$',
            default => '$',
        };

        switch ($currency) {
            case 'IDR':
                return $symbol . ' ' . number_format($amount, 0, ',', '.');
            case 'CNY':
                return $symbol . number_format($amount, 2, '.', ',');
            case 'USD':
            default:
                return $symbol . number_format($amount, 2, '.', ',');
        }
    }

    /**
     * Get multilingual field value based on current locale with fallback
     * 
     * @param object $model The model instance
     * @param string $field The field name (without locale suffix)
     * @param string|null $locale Override locale (optional)
     * @return string|null
     */
    public static function get($model, $field, $locale = null)
    {
        if (!$model) {
            return null;
        }

        $locale = $locale ?? app()->getLocale();
        $fieldWithLocale = $field . '_' . $locale;

        // Try to get the field with current locale
        if (isset($model->$fieldWithLocale) && !empty($model->$fieldWithLocale)) {
            return $model->$fieldWithLocale;
        }

        // Fallback chain: id -> en -> zh -> original field
        $fallbackLocales = ['id', 'en', 'zh'];
        foreach ($fallbackLocales as $fallbackLocale) {
            if ($fallbackLocale === $locale) continue; // Skip already tried locale
            
            $fallbackField = $field . '_' . $fallbackLocale;
            if (isset($model->$fallbackField) && !empty($model->$fallbackField)) {
                return $model->$fallbackField;
            }
        }

        // Last resort: try field without locale suffix
        return $model->$field ?? null;
    }

    public static function getPrice($model, $locale = null)
    {
        // Use detected user currency to pick correct price field
        $currency = self::getCurrentCurrency();

        switch ($currency) {
            case 'IDR':
                // Prefer special price when available
                if (isset($model->price_special_idr) && $model->price_special_idr !== null && $model->price_special_idr !== '') {
                    return $model->price_special_idr;
                }
                return $model->price_idr ?? $model->price ?? 0;
            case 'CNY':
                if (isset($model->price_special_cny) && $model->price_special_cny !== null && $model->price_special_cny !== '') {
                    return $model->price_special_cny;
                }
                return $model->price_cny ?? $model->price ?? 0;
            case 'USD':
            default:
                if (isset($model->price_special_usd) && $model->price_special_usd !== null && $model->price_special_usd !== '') {
                    return $model->price_special_usd;
                }
                return $model->price_usd ?? $model->price ?? 0;
        }
    }

    /**
     * Get currency code from locale
     */
    private static function getCurrencyFromLocale(string $locale): string
    {
        $languages = self::getLanguages();
        return $languages[$locale]['currency'] ?? 'USD';
    }
}