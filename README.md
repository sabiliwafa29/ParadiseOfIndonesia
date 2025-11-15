# Paradise Of Indonesia

A production-ready Laravel 10.x travel booking platform featuring automated image optimization, comprehensive security hardening, real-time monitoring, and CI/CD automation.

## 🚀 Quick Start

### Prerequisites
- **PHP** 8.2+
- **Composer** 2.0+
- **PostgreSQL** 13+ (or SQLite for local dev)
- **Redis** (for sessions, caching, and rate limiting)
- **Node.js** 16+ (for frontend assets)

### Setup

1. **Clone and install dependencies:**
   ```bash
   git clone https://github.com/sabiliwafa29/ParadiseOfIndonesia.git
   cd ParadiseOfIndonesia
   composer install
   npm install
   ```

2. **Configure environment:**
   ```bash
   cp .env.example .env
   # Edit .env with your database, API keys (Midtrans, Google, Sentry), and S3/CDN settings
   php artisan key:generate
   ```

3. **Run migrations and seed data:**
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Build frontend assets:**
   ```bash
   npm run build
   # or for development with watch mode:
   npm run dev
   ```

5. **Start the development server:**
   ```bash
   php artisan serve
   ```

   The app will be available at `http://localhost:8000`.

### Environment Variables (Key Settings)

```env
# Database (PostgreSQL recommended for production)
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=paradise_db
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# Cache & Sessions (Redis)
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=sync  # or "database" / "redis" for queued processing

# File Storage & CDN
FILESYSTEM_DISK=local  # or "s3" for AWS S3
CDN_URL=https://cdn.example.com  # optional CDN URL for asset delivery

# AWS S3 (if using cloud storage)
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket

# Payment Processing (Midtrans)
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_IS_PRODUCTION=false  # true for production

# Error Tracking (Sentry)
SENTRY_LARAVEL_DSN=https://your-sentry-dsn@o123.ingest.us.sentry.io/456

# OAuth (Google)
GOOGLE_CLIENT_ID=your_client_id
GOOGLE_CLIENT_SECRET=your_secret
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

## 📚 Documentation

Comprehensive guides are provided for each subsystem:

### [🖼️ Image Optimization & CDN Pipeline](./IMAGE_PIPELINE.md)
- Automated image resizing and derivative generation
- S3/CDN integration for fast delivery
- Job queuing with Intervention Image
- Testing and troubleshooting

### [🔒 Security Hardening](./SECURITY.md)
- Security headers (HSTS, CSP, X-Frame-Options, etc.)
- Per-endpoint API rate limiting
- Sanctum token-based authentication
- CORS configuration
- Input validation and XSS prevention
- Complete security test suite (11 test cases)

### [🚀 CI/CD & Deployment](./CI_CD_SETUP.md)
- GitHub Actions workflows (tests, deployment, security scanning)
- Automated testing pipeline (PHPUnit, Pest, Pint linting)
- Production deployment via SSH
- Dependency vulnerability scanning
- Multi-environment configuration (dev, staging, production)

### [💾 Session & Deployment](./SESSION_AND_DEPLOYMENT.md)
- Redis-backed session management
- Session security and configuration
- Deployment best practices
- Environment-specific tuning

### [📊 Monitoring & Error Tracking](./SENTRY_INTEGRATION.md) *(Sentry configured and tested)*
- Real-time error and exception tracking
- Breadcrumbs and context for image processing and payment operations
- Integration with image optimization jobs and Midtrans service
- Development vs. production error handling

## ✨ Key Features

### Image Optimization
- **Automatic resizing & derivatives**: Images uploaded through the admin are automatically resized to multiple formats (thumbnail, medium, large) via queued jobs
- **S3/CDN ready**: Storage::url() integration for CDN delivery; all image paths are optimized for cloud storage
- **Responsive images**: Blade component (`responsive-image.blade.php`) with `<srcset>` support for adaptive image loading
- **Migration-backed persistence**: Derivative metadata stored in JSON columns for fast retrieval

### Security
- **Security headers middleware**: Enforces HSTS, CSP, X-Frame-Options, and X-Content-Type-Options
- **API rate limiting**: Per-endpoint limits (e.g., 60 requests/min for bookings, 30 for payment callbacks)
- **Token-based auth**: Sanctum with secure logout mechanism
- **CORS protection**: Configurable cross-origin requests with credential handling

### Payment Integration
- **Midtrans integration**: Full payment gateway support with transaction logging and error handling
- **Sentry monitoring**: Payment errors are captured and tracked in real-time
- **Webhook validation**: Secure callback handling for payment notifications

### Observability
- **Structured logging**: JSON-formatted logs with context for OSRM, Midtrans, and image processing
- **Sentry integration**: Automatic exception capture with breadcrumbs for image jobs and payment flows
- **Health monitoring**: Configurable alerts for critical errors and performance degradation

### Testing
- **Comprehensive test suite**: Feature tests for booking flow, payment integration, security, image uploads, and more
- **PHPUnit + Pest**: Both traditional and elegant test frameworks supported
- **Faker fixtures**: Base64 PNG images for upload testing without requiring external files

## 🛠️ Development

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/BookingFlowTest.php

# Run with code coverage
php artisan test --coverage
```

### Linting & Code Standards
```bash
# Run Pint (PHP linter)
./vendor/bin/pint

# Format specific files
./vendor/bin/pint app/Models/Booking.php
```

### Database Management
```bash
# Create a migration
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback last batch
php artisan migrate:rollback

# Fresh migration (warning: deletes data)
php artisan migrate:fresh --seed
```

### Queuing
```bash
# Start queue worker (for background jobs)
php artisan queue:work

# Process a single job
php artisan queue:work --once

# Restart workers gracefully
php artisan queue:restart
```

### Artisan Tinker (Interactive Shell)
```bash
php artisan tinker
> App\Models\Booking::count()
> \Sentry\captureMessage('Test event')
```

## 🔧 Configuration

### Cache & Sessions
- **Redis**: Configured for both caching and session storage for high performance and scalability
- **Local development**: Falls back to file-based cache/sessions if Redis unavailable

### Image Processing
- Edit `config/filesystems.php` to configure S3 bucket, CDN URL, and local paths
- Job queue options in `.env`: `QUEUE_CONNECTION=sync` (dev) or `database`/`redis` (production)

### Rate Limiting
- Configure per-endpoint limits in `routes/api.php` via `throttle` middleware
- Adjust window duration (minutes) and request count in middleware configuration

### Logging
- Configure channels in `config/logging.php`; Sentry channel automatically included if DSN is set
- Adjust log level in `.env`: `LOG_LEVEL=debug` (dev) or `warning` (production)

## 📦 Dependencies

**Core Framework:**
- Laravel 10.x with Sanctum (API authentication)
- Eloquent ORM

**Image Processing:**
- Intervention Image 2.7.x for resizing and format conversion

**File Storage:**
- League Flysystem 3.x for abstracted S3/local storage

**Payment Gateway:**
- Midtrans SDK for transaction processing

**Monitoring & Logging:**
- Sentry Laravel 3.8.x for error tracking
- Monolog for structured logging

**Frontend:**
- Tailwind CSS 3.x
- Alpine.js for interactivity

**Testing:**
- PHPUnit with Pest extensions
- Faker for fixture generation

**Development:**
- Pint for code linting and formatting
- Vite for asset bundling

## 🐛 Troubleshooting

### Common Issues

**502 Bad Gateway on Deploy**
- Check `.env` for correct database credentials and Redis connection
- Run `php artisan config:cache` and `php artisan route:cache` on server
- Ensure `storage` and `bootstrap/cache` directories are writable

**Image Upload Fails**
- Verify `FILESYSTEM_DISK` and S3 credentials in `.env`
- Check file permissions on `storage/app/public` for local disk
- Enable `QUEUE_CONNECTION=sync` to debug jobs synchronously

**Rate Limiting Too Strict**
- Adjust `throttle:60,1` values in `routes/api.php`
- Clear cache: `php artisan cache:clear`

**Sentry Events Not Appearing**
- Verify `SENTRY_LARAVEL_DSN` in `.env` is correct
- Check Sentry project settings for allowed domains
- Run `php artisan cache:clear` to reload config

**Redis Connection Issues**
- Ensure Redis is running: `redis-cli ping` should return `PONG`
- Check `REDIS_HOST` and `REDIS_PORT` in `.env`
- For local development, `redis-server` should be running on port 6379

## 📈 Performance Tips

1. **Enable query caching**: Use `Cache::remember()` for frequently accessed data (tours, destinations)
2. **Optimize images**: Ensure derivative sizes in `ProcessImageDerivatives` job are appropriate for your use case
3. **Use Redis connection pooling**: Set `REDIS_POOL=10` for better concurrency
4. **Enable HTTP caching headers**: Set cache lifetime for static assets (images, CSS, JS)
5. **Monitor Sentry dashboard** for performance bottlenecks and error trends

## 📝 License

This project is proprietary and confidential. Unauthorized access, copying, or distribution is prohibited.

---

**Questions or issues?** Check the detailed guides linked above or review the GitHub workflows for deployment examples.

.