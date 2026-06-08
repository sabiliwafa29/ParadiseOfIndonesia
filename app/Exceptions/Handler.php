<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // If Sentry is installed and configured, forward exceptions there for
            // centralized monitoring. We guard with class_exists to avoid fatal
            // errors when the package hasn't been installed (e.g., local dev
            // before running composer install).
            if (class_exists(\Sentry\SentrySdk::class) && env('SENTRY_LARAVEL_DSN')) {
                try {
                    \Sentry\captureException($e);
                } catch (\Throwable $captureEx) {
                    // Don't let Sentry reporting break the application — log and continue
                    report($captureEx);
                }
            }
        });
    }
}
