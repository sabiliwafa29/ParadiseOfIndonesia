# Sentry Integration Guide

This guide documents the real-time error tracking and monitoring setup using Sentry in Paradise of Indonesia.

## Overview

Sentry is integrated into the application to capture and track:
- **Exceptions and errors** from the application and jobs
- **Payment integration errors** from Midtrans transactions
- **Image processing failures** from the image optimization pipeline
- **Structured logs** and warnings

## Setup

### Configuration

Sentry is configured via environment variables in `.env`:

```env
SENTRY_LARAVEL_DSN=https://your-key@o123.ingest.us.sentry.io/456
```

Get your DSN from your [Sentry project](https://sentry.io):
1. Log in to Sentry
2. Select your project (or create one)
3. Go to **Settings → Client Keys (DSN)**
4. Copy the DSN value and add it to `.env`

### Installation & Packages

Sentry is installed via Composer and automatically discovered by Laravel:

```bash
composer require sentry/sentry-laravel
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"
```

The SDK provides:
- **sentry/sentry** (v3.22.1): Core Sentry SDK
- **sentry/sentry-laravel** (v3.8.2): Laravel integration and service provider

## Configuration Files

### `config/sentry.php`
Laravel-specific Sentry configuration:

```php
return [
    'dsn' => env('SENTRY_LARAVEL_DSN'),
    'traces_sample_rate' => 0.1,  // 10% of requests for performance monitoring
    'attach_stacktrace' => true,   // Attach stack traces to messages
    'environment' => env('APP_ENV', 'production'),
    'release' => env('APP_VERSION'),
    'breadcrumbs' => [
        'logs' => true,
        'sql_queries' => true,
    ],
];
```

### `config/logging.php`
Monolog channel configuration for structured logging:

```php
'sentry' => [
    'driver' => 'sentry',
    'level' => env('LOG_LEVEL', 'error'),
],
```

When a Sentry DSN is configured, the logging stack automatically includes the Sentry channel.

## Integration Points

### 1. Exception Handler (`app/Exceptions/Handler.php`)

All reportable exceptions are automatically sent to Sentry:

```php
public function register()
{
    $this->reportable(function (Throwable $e) {
        if (class_exists('\Sentry\SentryLaravel\Integration') && 
            env('SENTRY_LARAVEL_DSN')) {
            \Sentry\captureException($e);
        }
    });
}
```

**What gets captured:**
- Unhandled exceptions (404, 500, validation errors)
- Custom exception types
- Database errors
- Authentication failures

### 2. Image Processing Job (`app/Jobs/ProcessImageDerivatives.php`)

The image optimization job includes Sentry context and breadcrumbs:

```php
public function handle()
{
    // Set Sentry context
    if (class_exists('\Sentry\SentryLaravel\Integration')) {
        \Sentry\captureMessage('Image processing started', 'info');
        \Sentry\withScope(function (\Sentry\State\Scope $scope) {
            $scope->setContext('image_job', [
                'model' => get_class($this->model),
                'model_id' => $this->model->id,
                'field' => $this->field,
            ]);
        });
    }

    try {
        // Process image derivatives...
    } catch (Exception $e) {
        if (class_exists('\Sentry\SentryLaravel\Integration')) {
            \Sentry\captureException($e);
        }
        throw $e;
    }
}
```

**Context tracked:**
- Model type and ID being processed
- Field name and file path
- Derivative sizes and formats
- Processing time and memory usage

### 3. Midtrans Service (`app/Services/MidtransService.php`)

Payment integration errors are tracked with transaction context:

```php
public function createTransaction($amount, $orderId, $customer)
{
    // Set Sentry context
    if (class_exists('\Sentry\SentryLaravel\Integration')) {
        \Sentry\withScope(function (\Sentry\State\Scope $scope) {
            $scope->setContext('midtrans_transaction', [
                'order_id' => $orderId,
                'amount' => $amount,
                'customer_email' => $customer['email'],
            ]);
        });
    }

    try {
        // Create transaction...
    } catch (Exception $e) {
        if (class_exists('\Sentry\SentryLaravel\Integration')) {
            \Sentry\captureException($e);
        }
        throw $e;
    }
}
```

**Context tracked:**
- Order ID and amount
- Customer email and name
- Payment method
- Transaction status

### 4. Structured Logging

Log messages are automatically captured via the Sentry Monolog channel:

```php
\Log::error('Payment processing failed', [
    'order_id' => $orderId,
    'error' => $exception->getMessage(),
]);
```

These logs appear in Sentry as events with their associated context.

## Usage

### Manual Event Capture

Capture a custom message or exception:

```php
// Capture a message
\Sentry\captureMessage('Custom event message', 'info');

// Capture an exception
try {
    // risky code
} catch (Exception $e) {
    \Sentry\captureException($e);
}
```

### Add Context to Events

Add custom context to help debug issues:

```php
\Sentry\withScope(function (\Sentry\State\Scope $scope) {
    $scope->setContext('user_data', [
        'user_id' => auth()->id(),
        'email' => auth()->user()->email,
        'booking_id' => $booking->id,
    ]);
    
    \Sentry\captureMessage('Booking confirmed');
});
```

### Add Breadcrumbs

Breadcrumbs are a trail of events leading up to an error:

```php
\Sentry\addBreadcrumb(new \Sentry\Breadcrumb(
    \Sentry\Breadcrumb::LEVEL_INFO,
    \Sentry\Breadcrumb::TYPE_DEFAULT,
    'payment.gateway',
    'Transaction initiated',
    ['amount' => 100000]
));
```

## Monitoring & Alerts

### Dashboard

Access your Sentry dashboard at [sentry.io](https://sentry.io):

1. **Issues**: View all reported errors, grouped by type
2. **Performance**: Monitor request latency and throughput
3. **Releases**: Track errors by application version
4. **Alerts**: Configure notifications for critical issues

### Creating Alerts

Set up Sentry alerts for:
- **Image processing failures**: Alert when `ProcessImageDerivatives` job fails
- **Payment errors**: Alert on Midtrans transaction failures
- **Exception spikes**: Alert when error rate exceeds threshold

Example alert condition:
- **Event type:** Error
- **Condition:** Issue count > 5 in 5 minutes
- **Actions:** Send email notification

### Best Practices

1. **Development vs. Production**
   - Set `traces_sample_rate` to 1.0 (100%) in development for detailed tracing
   - Use 0.1 (10%) in production to avoid quota overload

2. **Sensitive Data**
   - Configure `before_send` callback to strip sensitive fields:
     ```php
     'before_send' => function (\Sentry\Event $event) {
         foreach ($event->getRequest()->getHeaders() as $key => $value) {
             if (stripos($key, 'authorization') !== false) {
                 unset($event->getRequest()->getHeaders()[$key]);
             }
         }
         return $event;
     },
     ```

3. **Performance Monitoring**
   - Use transactions to track complex operations:
     ```php
     $transaction = \Sentry\startTransaction(['name' => 'image_processing']);
     // ... do work ...
     $transaction->finish();
     ```

4. **Release Tracking**
   - Set `APP_VERSION` in `.env` to track errors by release:
     ```env
     APP_VERSION=1.0.0
     ```

## Testing

### Send a Test Event

Run a quick test to verify the integration:

```bash
php -r "require 'vendor/autoload.php'; \Sentry\init(['dsn' => env('SENTRY_LARAVEL_DSN')]); \Sentry\captureMessage('Test event from Paradise');"
```

### Programmatic Testing

In a test or tinker session:

```php
\Sentry\captureMessage('Test message', 'info');

try {
    throw new Exception('Test exception');
} catch (Exception $e) {
    \Sentry\captureException($e);
}
```

Check your Sentry dashboard—the events should appear within seconds.

## Troubleshooting

### Events Not Appearing

1. **Verify DSN**: Ensure `SENTRY_LARAVEL_DSN` is correct in `.env`
2. **Clear config cache**: Run `php artisan config:cache`
3. **Check network**: Verify outbound HTTPS to `o123.ingest.us.sentry.io` is allowed
4. **Enable logging**: Add `'before_send' => function ($event) { \Log::debug('Sentry event', $event); return $event; }` to debug

### Too Many Events / Quota Issues

1. **Reduce sample rate**: Lower `traces_sample_rate` in `config/sentry.php`
2. **Filter events**: Implement `before_send` to ignore certain errors:
   ```php
   'before_send' => function ($event, $hint) {
       if ($event->getLevel() === 'debug') {
           return null;  // Drop debug events
       }
       return $event;
   },
   ```

### Sensitive Data Leaking

1. **Strip PII**: Set `send_default_pii` to false in `config/sentry.php`
2. **Custom before_send**: Remove user data, passwords, tokens:
   ```php
   'before_send' => function ($event, $hint) {
       unset($event->getRequest()->getData()['password']);
       return $event;
   },
   ```

## References

- [Sentry Laravel Documentation](https://docs.sentry.io/platforms/php/guides/laravel/)
- [Sentry SDK API Reference](https://docs.sentry.io/platforms/php/)
- [Sentry Dashboard Guide](https://docs.sentry.io/product/issues/)

---

**Next Steps:**
1. Access your Sentry dashboard and verify test events are being received
2. Set up alert rules for critical errors (payment failures, image processing errors)
3. Monitor the Issues page regularly for error trends and patterns
