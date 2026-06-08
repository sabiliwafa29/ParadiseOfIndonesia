<?php

return [
    // Sentry DSN for Laravel SDK
    'dsn' => env('SENTRY_LARAVEL_DSN', null),

    // Send default PII (user email, etc.) — enable only if needed
    'send_default_pii' => env('SENTRY_SEND_DEFAULT_PII', false),

    // Performance tracing sample rate (0.0 - 1.0)
    'traces_sample_rate' => (float) env('SENTRY_TRACES_SAMPLE_RATE', 0.0),

    // Release and environment are optional but help with grouping
    'release' => env('SENTRY_RELEASE'),
    'environment' => env('SENTRY_ENVIRONMENT', env('APP_ENV')),

    // Attach stack traces for logging
    'attach_stacktrace' => env('SENTRY_ATTACH_STACKTRACE', true),

    // Breadcrumbs configuration
    'breadcrumbs' => [
        'logs' => true,
        'sql_queries' => false,
        'queries_bindings' => false,
    ],
];
