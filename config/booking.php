<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Booking Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk sistem booking, termasuk harga addon services
    | dan pengaturan lainnya.
    |
    */

    'addon_prices' => [
        'guide' => env('BOOKING_GUIDE_PRICE', 50), // Harga per guest
        'transport' => env('BOOKING_TRANSPORT_PRICE', 30), // Harga per guest
    ],

    'order_id' => [
        'prefix' => env('ORDER_ID_PREFIX', 'BOOK'),
        'format' => env('ORDER_ID_FORMAT', 'timestamp'), // 'timestamp' or 'uuid'
    ],
];

