# 🚀 Paradise of Indonesia – Deployment Guide

**Quick Reference for Production Deployment**

---

## Pre-Deployment Checklist (5 minutes)

```bash
# 1. Verify all code is committed
git status  # Should show "working tree clean"

# 2. Build frontend assets
npm run build

# 3. Verify PHP dependencies
composer check-platform-reqs  # All should show "success"

# 4. Verify critical files have no syntax errors
php -l app/Exceptions/Handler.php
php -l config/sentry.php
php -l app/Jobs/ProcessImageDerivatives.php
php -l routes/api.php
```

---

## Environment Variables Template

Save this as `.env.production` on your server:

```env
APP_NAME="Paradise Of Indonesia"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://paradiseofindonesia.com
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

# Database (PostgreSQL 13+)
DB_CONNECTION=pgsql
DB_HOST=your-postgres-host
DB_PORT=5432
DB_DATABASE=paradise_db
DB_USERNAME=db_user
DB_PASSWORD=very_secure_password

# Cache & Sessions (Redis)
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
REDIS_HOST=your-redis-host
REDIS_PORT=6379
REDIS_PASSWORD=redis_password
REDIS_CLUSTER=false

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=warning

# File Storage
FILESYSTEM_DISK=s3
CDN_URL=https://cdn.yourdomain.com

# AWS S3
AWS_ACCESS_KEY_ID=your_aws_key
AWS_SECRET_ACCESS_KEY=your_aws_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket
AWS_URL=https://your-bucket.s3.amazonaws.com
AWS_USE_PATH_STYLE_ENDPOINT=false

# Payment Gateway (Midtrans)
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_MERCHANT_ID=your_merchant_id
MIDTRANS_IS_PRODUCTION=true

# Error Tracking (Sentry)
SENTRY_LARAVEL_DSN=https://your-key@o123.ingest.us.sentry.io/456

# OAuth (Google)
GOOGLE_CLIENT_ID=your_client_id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your_secret
GOOGLE_REDIRECT_URI=https://paradiseofindonesia.com/auth/google/callback

# Session Security
SESSION_DOMAIN=.paradiseofindonesia.com
SESSION_SECURE_COOKIES=true
SESSION_SAME_SITE=strict
SANCTUM_STATEFUL_DOMAINS=paradiseofindonesia.com

# Mail (Optional)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@paradiseofindonesia.com
```

---

## Deployment Steps (via SSH)

### Step 1: Pull Latest Code
```bash
cd /var/www/paradiseofindonesia
git pull origin main  # or your branch
```

### Step 2: Install Dependencies
```bash
composer install --no-dev --optimize-autoloader --no-progress
npm install --production
npm run build
```

### Step 3: Environment Setup
```bash
# Copy production .env file
cp .env.production .env

# Generate application key (if first deployment)
php artisan key:generate

# Run migrations
php artisan migrate --force

# Run seeders (if first deployment)
php artisan db:seed --force
```

### Step 4: Cache Optimization
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 5: Set Permissions
```bash
chmod -R 755 storage bootstrap/cache public
chown -R www-data:www-data storage bootstrap/cache
```

### Step 6: Start Services
```bash
# Restart PHP-FPM
sudo systemctl restart php8.4-fpm

# Restart web server
sudo systemctl restart nginx  # or apache2

# Start queue worker (in screen/tmux or use supervisor)
php artisan queue:work --daemon
# OR with supervisor (recommended for production)
sudo systemctl restart supervisor
```

### Step 7: Verify Deployment
```bash
# Check app loads
curl https://paradiseofindonesia.com

# Check logs for errors
tail -f storage/logs/laravel.log

# Verify migrations ran
php artisan migrate:status

# Verify Redis connection
php artisan tinker
> Cache::set('test', 'value'); Cache::get('test')  # Should return 'value'

# Test Sentry connection
> \Sentry\captureMessage('Deploy test event');
```

---

## Using GitHub Actions for Deployment (Recommended)

### 1. Create Secrets in GitHub Repository

Go to: **Settings → Secrets and variables → Actions**

Add these secrets:
- `DEPLOY_HOST` – SSH hostname (e.g., 1.2.3.4)
- `DEPLOY_USER` – SSH username (e.g., deploy)
- `DEPLOY_KEY` – Private SSH key (generate with `ssh-keygen`)
- `DEPLOY_PATH` – Path to app (e.g., /var/www/paradiseofindonesia)

### 2. GitHub Actions Will Automatically:

When you push to `main` branch:
1. Run all tests
2. Check code linting
3. Scan for vulnerabilities
4. If all pass, deploy to production via SSH

### 3. To Trigger Deployment Manually

```bash
git push origin main  # Automatic deployment
# OR go to Actions tab in GitHub and manually trigger workflow
```

---

## Post-Deployment Health Checks

### Checklist (run after deployment)

```bash
# 1. Application loads
curl -I https://paradiseofindonesia.com
# Should return: HTTP/2 200 OK

# 2. Database is connected
php artisan tinker
> DB::connection()->getPdo()  # Should not error

# 3. Cache/Sessions work
> Cache::set('test', 'value')
> Cache::get('test')  # Should return 'value'

# 4. Images can be uploaded and optimized
# (Upload image via admin, check storage/app/public/derivatives/)

# 5. Security headers present
curl -I https://paradiseofindonesia.com
# Check for: Strict-Transport-Security, Content-Security-Policy, X-Frame-Options

# 6. Sentry is capturing errors
# Go to Sentry dashboard, should see recent events

# 7. Payment gateway responds
php artisan tinker
> \App\Services\MidtransService::testConnection()

# 8. API rate limiting works
# Make 70 requests in 60 seconds to any endpoint
# Should get 429 (Too Many Requests) after 60 requests
```

---

## Monitoring Post-Deployment

### Daily Checks
1. **Sentry Dashboard:** Check for new errors or spikes
2. **Application Logs:** `tail -f storage/logs/laravel.log`
3. **Database Performance:** Check slow query log
4. **Queue Status:** `php artisan queue:monitor`

### Weekly Checks
1. **Backup Status:** Verify database backups are running
2. **Disk Space:** `df -h` – Ensure storage not full
3. **Security Updates:** `composer audit` – Check for vulnerabilities
4. **Uptime:** Monitor availability via uptime monitoring service

### Monthly Checks
1. **Performance Analysis:** Review Sentry performance traces
2. **Cost Analysis:** Review AWS S3/CDN costs
3. **Update Dependencies:** Run `composer update` on staging first

---

## Rollback Procedure (if needed)

### Immediate Rollback (within minutes)
```bash
# Go back to previous commit
git revert HEAD
git push origin main

# GitHub Actions will auto-deploy previous version
# OR manually:
git checkout previous_commit_hash
git push -f origin main
```

### Database Rollback (if migrations failed)
```bash
# Rollback to previous migration
php artisan migrate:rollback

# Re-run from specific migration
php artisan migrate:reset  # WARNING: Destructive
```

### Full Rollback (comprehensive)
```bash
# Stop all workers
php artisan queue:restart

# Revert code
git reset --hard previous_commit_hash

# Rollback database
php artisan migrate:rollback

# Clear caches
php artisan cache:clear
php artisan view:clear

# Restart services
sudo systemctl restart php8.4-fpm nginx
```

---

## Troubleshooting Common Deployment Issues

### 502 Bad Gateway
```bash
# Check PHP-FPM
sudo systemctl status php8.4-fpm
sudo systemctl restart php8.4-fpm

# Check app logs
tail -f storage/logs/laravel.log

# Check file permissions
ls -la storage/  # Should be www-data:www-data with 755
```

### Image Uploads Fail
```bash
# Check S3 credentials in .env
php artisan tinker
> \Storage::disk('s3')->put('test.txt', 'test')

# Check local permissions
chmod -R 755 storage/app
chown -R www-data:www-data storage/app
```

### Sentry Events Not Appearing
```bash
# Verify DSN
php artisan tinker
> echo getenv('SENTRY_LARAVEL_DSN')

# Clear config cache
php artisan config:cache

# Test connection
> \Sentry\captureMessage('Test')
> echo "Check Sentry dashboard"
```

### Redis Connection Errors
```bash
# Verify Redis is running
redis-cli ping  # Should return PONG

# Check credentials in .env
# REDIS_HOST=127.0.0.1
# REDIS_PORT=6379
# REDIS_PASSWORD=null

# Test from PHP
php artisan tinker
> \Redis::ping()
```

### Database Connection Errors
```bash
# Test PostgreSQL connection
psql -h your-postgres-host -U db_user -d paradise_db

# Verify credentials in .env
# DB_HOST=your-postgres-host
# DB_USERNAME=db_user
# DB_PASSWORD=password

# Test from PHP
php artisan tinker
> DB::connection()->getPdo()
```

---

## Performance Monitoring

### Enable Slow Query Logging (PostgreSQL)
```sql
ALTER DATABASE paradise_db SET log_statement = 'all';
ALTER DATABASE paradise_db SET log_duration = 'on';
ALTER DATABASE paradise_db SET log_min_duration_statement = 1000;  # 1 second
```

### Monitor with New Relic / Datadog (Optional)

1. Install APM agent
2. Configure in `config/new-relic.php` or via `.env`
3. Monitor real-time performance

### Sentry Performance Monitoring

Check Sentry dashboard:
1. **Releases** tab – Track errors by version
2. **Performance** tab – Identify slow transactions
3. **Alerts** tab – Set up notifications

---

## Scaling for Production

### Horizontal Scaling (Multiple Servers)
```bash
# Set up load balancer (Nginx or AWS ALB)
# Deploy app to multiple servers
# Use shared Redis instance
# Use shared database (PostgreSQL)
# Use shared file storage (AWS S3)
```

### Vertical Scaling (More Resources)
```bash
# Increase RAM for queue workers
# Increase CPU for web servers
# Increase PostgreSQL buffer_pool size
# Increase Redis memory_max_policy
```

### Queue Scaling
```bash
# Run multiple queue workers
supervisord -c /etc/supervisor/conf.d/laravel-worker.conf

# Monitor queue depth
php artisan queue:monitor Bookings:10,PaymentProcessing:20
```

---

## Final Checklist Before Production

- [ ] All tests passing locally
- [ ] Code deployed to GitHub
- [ ] Environment variables configured on server
- [ ] Database migrations run successfully
- [ ] Assets built (`npm run build`)
- [ ] Redis running and accessible
- [ ] PostgreSQL running with correct credentials
- [ ] File permissions set correctly (755, www-data owner)
- [ ] HTTPS/SSL certificate installed
- [ ] Firewall rules configured (allow 80, 443; block others)
- [ ] Sentry project created and DSN configured
- [ ] Backup system configured and tested
- [ ] Monitoring system configured (Sentry, logs, uptime)
- [ ] Queue workers running (supervisor or systemd)
- [ ] Database backups scheduled
- [ ] Security headers verified in browser
- [ ] API rate limiting tested
- [ ] Payment gateway tested with sandbox
- [ ] Image uploads tested
- [ ] Healthcheck endpoint working

---

## Support & Documentation

- **README.md** – Project overview
- **PRODUCTION_READINESS.md** – Full deployment checklist
- **IMPLEMENTATION_SUMMARY.md** – Complete project summary
- **SECURITY.md** – Security features
- **SENTRY_INTEGRATION.md** – Error tracking

---

**Deployment Status:** ✅ Ready for production  
**Repository:** https://github.com/sabiliwafa29/ParadiseOfIndonesia  
**Support:** Check documentation files or GitHub issues
