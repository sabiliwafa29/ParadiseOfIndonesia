<?php

use App\Helpers\LanguageHelper;

if (!function_exists('format_price')) {
    function format_price(float|int $amount, ?string $locale = null): string
    {
        return LanguageHelper::formatPrice($amount, $locale);
    }
}

if (!function_exists('get_price')) {
    function get_price(object $model, ?string $locale = null): float
    {
        return LanguageHelper::getPrice($model, $locale);
    }
}

if (!function_exists('currency_symbol')) {
    function currency_symbol(?string $locale = null): string
    {
        return LanguageHelper::getCurrencySymbol($locale);
    }
}

if (!function_exists('current_currency')) {
    function current_currency(): string
    {
        return LanguageHelper::getCurrentCurrency();
    }
}

if (!function_exists('format_price_by_currency')) {
    function format_price_by_currency(float|int $amount, string $currency): string
    {
        return LanguageHelper::formatPriceByCurrency($amount, $currency);
    }
}