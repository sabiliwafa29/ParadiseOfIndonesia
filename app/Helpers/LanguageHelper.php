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
                'native' => 'English'
            ],
            'id' => [
                'name' => 'Indonesian',
                'flag' => '🇮🇩',
                'native' => 'Indonesia'
            ],
            'zh' => [
                'name' => 'Chinese',
                'flag' => '🇨🇳',
                'native' => '中文'
            ],
        ];
    }
    
    public static function getCurrentLanguage()
    {
        $locale = app()->getLocale();
        $languages = self::getLanguages();
        return $languages[$locale] ?? $languages['en'];
    }
}