<?php

namespace App\Helpers;

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
        $locale = app()->getLocale();
        $languages = self::getLanguages();
        return $languages[$locale]['currency'] ?? 'USD';
    }

    public static function getCurrencySymbol($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $languages = self::getLanguages();
        return $languages[$locale]['currency_symbol'] ?? '$';
    }

    public static function formatPrice($amount, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $currency = self::getCurrentCurrency();
        $symbol = self::getCurrencySymbol($locale);

        // Format based on locale
        switch ($locale) {
            case 'id':
                return $symbol . ' ' . number_format($amount, 0, ',', '.');
            case 'zh':
                return $symbol . number_format($amount, 2, '.', ',');
            case 'en':
            default:
                return $symbol . number_format($amount, 2, '.', ',');
        }
    }

    public static function getPrice($model, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $currency = self::getCurrentCurrency();

        // Get price based on currency
        switch ($currency) {
            case 'IDR':
                return $model->price_idr ?? $model->price ?? 0;
            case 'CNY':
                return $model->price_cny ?? $model->price ?? 0;
            case 'USD':
            default:
                return $model->price_usd ?? $model->price ?? 0;
        }
    }
}