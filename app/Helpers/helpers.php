<?php

use App\Helpers\LanguageHelper;

if (!function_exists('format_price')) {
    /**
     * Format price based on current locale
     */
    function format_price($amount, $locale = null)
    {
        return LanguageHelper::formatPrice($amount, $locale);
    }
}

if (!function_exists('get_price')) {
    /**
     * Get price from model based on current currency
     */
    function get_price($model, $locale = null)
    {
        return LanguageHelper::getPrice($model, $locale);
    }
}

if (!function_exists('currency_symbol')) {
    /**
     * Get currency symbol for current locale
     */
    function currency_symbol($locale = null)
    {
        return LanguageHelper::getCurrencySymbol($locale);
    }
}

if (!function_exists('current_currency')) {
    /**
     * Get current currency code
     */
    function current_currency()
    {
        return LanguageHelper::getCurrentCurrency();
    }
}
