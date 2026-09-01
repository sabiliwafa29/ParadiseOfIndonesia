<?php

namespace App\Helpers;

use App\Services\LocationService;

class LanguageHelper
{
    public const LOCALE_EN = 'en';
    public const LOCALE_ID = 'id';
    public const LOCALE_ZH = 'zh';

    protected const CURRENCIES = [
        'ID' => 'IDR',
        'CN' => 'CNY',
        'HK' => 'CNY',
    ];

    protected const CURRENCY_SYMBOLS = [
        'IDR' => 'Rp',
        'CNY' => '¥',
        'USD' => '$',
    ];

    protected const DECIMAL_CONFIGS = [
        'IDR' => ['decimals' => 0, 'thousands_sep' => '.', 'decimal_sep' => ','],
        'CNY' => ['decimals' => 2, 'thousands_sep' => ',', 'decimal_sep' => '.'],
        'USD' => ['decimals' => 2, 'thousands_sep' => ',', 'decimal_sep' => '.'],
    ];

    public static function getLanguages(): array
    {
        return [
            self::LOCALE_EN => [
                'name' => 'English',
                'flag' => '🇬🇧',
                'native' => 'English',
                'currency' => 'USD',
                'currency_symbol' => '$',
            ],
            self::LOCALE_ID => [
                'name' => 'Indonesian',
                'flag' => '🇮🇩',
                'native' => 'Indonesia',
                'currency' => 'IDR',
                'currency_symbol' => 'Rp',
            ],
            self::LOCALE_ZH => [
                'name' => 'Chinese',
                'flag' => '🇨🇳',
                'native' => '中文',
                'currency' => 'CNY',
                'currency_symbol' => '¥',
            ],
        ];
    }

    public static function getCurrentLanguage(): array
    {
        $locale = app()->getLocale();
        $languages = self::getLanguages();

        return $languages[$locale] ?? $languages[self::LOCALE_EN];
    }

    public static function getCurrentCurrency(): string
    {
        return LocationService::getUserCurrency() ?? 'USD';
    }

    public static function getCurrencySymbol(?string $locale = null): string
    {
        $currency = $locale ? self::resolveCurrencyFromLocale($locale) : self::getCurrentCurrency();

        return self::CURRENCY_SYMBOLS[$currency] ?? '$';
    }

    protected static function resolveCurrencyFromLocale(string $locale): string
    {
        $languages = self::getLanguages();

        return $languages[$locale]['currency'] ?? 'USD';
    }

    public static function formatPrice(float|int $amount, ?string $locale = null): string
    {
        $currency = self::getCurrentCurrency();
        $symbol = self::getCurrencySymbol($locale);
        $config = self::DECIMAL_CONFIGS[$currency] ?? self::DECIMAL_CONFIGS['USD'];

        return $symbol . ' ' . number_format($amount, $config['decimals'], $config['decimal_sep'], $config['thousands_sep']);
    }

    public static function formatPriceByCurrency(float|int $amount, string $currencyCode): string
    {
        $currency = strtoupper($currencyCode ?? 'USD');
        $symbol = self::CURRENCY_SYMBOLS[$currency] ?? '$';
        $config = self::DECIMAL_CONFIGS[$currency] ?? self::DECIMAL_CONFIGS['USD'];

        return $symbol . ' ' . number_format($amount, $config['decimals'], $config['decimal_sep'], $config['thousands_sep']);
    }

    public static function get($model, string $field, ?string $locale = null): ?string
    {
        if (!$model) {
            return null;
        }

        $locale = $locale ?? app()->getLocale();
        $fieldWithLocale = $field . '_' . $locale;

        if (isset($model->$fieldWithLocale) && !empty($model->$fieldWithLocale)) {
            return $model->$fieldWithLocale;
        }

        $fallbackLocales = [self::LOCALE_ID, self::LOCALE_EN, self::LOCALE_ZH];
        foreach ($fallbackLocales as $fallbackLocale) {
            if ($fallbackLocale === $locale) {
                continue;
            }

            $fallbackField = $field . '_' . $fallbackLocale;
            if (isset($model->$fallbackField) && !empty($model->$fallbackField)) {
                return $model->$fallbackField;
            }
        }

        return $model->$field ?? null;
    }

    public static function getPrice(object $model, ?string $locale = null): float
    {
        $currency = self::getCurrentCurrency();

        return match($currency) {
            'IDR' => $model->price_idr ?? $model->price ?? 0,
            'CNY' => $model->price_cny ?? $model->price ?? 0,
            'USD' => $model->price_usd ?? $model->price ?? 0,
            default => $model->price_usd ?? $model->price ?? 0,
        };
    }

    public static function getPriceByCurrency(object $model, string $currency): float
    {
        return match(strtoupper($currency)) {
            'IDR' => $model->price_idr ?? $model->price ?? 0,
            'CNY' => $model->price_cny ?? $model->price ?? 0,
            'USD' => $model->price_usd ?? $model->price ?? 0,
            default => $model->price_usd ?? $model->price ?? 0,
        };
    }
}