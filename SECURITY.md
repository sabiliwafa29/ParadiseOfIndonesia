# Security Improvements & Hardening

## Overview

This document covers the security improvements implemented for the PNB Travel API and web application, including:

1. Security headers (HSTS, CSP, X-Frame-Options, etc.)
2. API rate limiting (per endpoint, per user, per IP)
3. Sanctum authentication (token-based API auth)
4. CSRF protection
5. Security best practices

## 1. Security Headers

Security headers are automatically added to all HTTP responses via the `SecurityHeaders` middleware.

### Headers Implemented

| Header | Purpose | Value |
|--------|---------|-------|
| `Strict-Transport-Security` | Force HTTPS | `max-age=31536000; includeSubDomains; preload` |
| `X-Content-Type-Options` | Prevent MIME sniffing | `nosniff` |
| `X-Frame-Options` | Prevent clickjacking | `SAMEORIGIN` |
| `X-XSS-Protection` | Legacy XSS protection | `1; mode=block` |
| `Referrer-Policy` | Control referrer sharing | `strict-origin-when-cross-origin` |
| `Permissions-Policy` | Control browser features | Denies geolocation, USB, etc. |
| `Content-Security-Policy` | Prevent XSS/injection attacks | Dynamic, based on route |

### Content-Security-Policy (CSP)

**For API Endpoints (`/api/*`):**
- Strictest policy: no inline scripts, no external resources
- Only allows explicit API contracts
- Prevents any DOM/XSS injection

**For Web Application:**
- Allows `'self'` and CDN resources
- Inline styles allowed (for admin panel)
- Inline scripts allowed (for admin panel interactions)
- External APIs whitelisted:
  - Midtrans: `https://app.midtrans.com`
  - OSRM: `https://router.project-osrm.org`
- Upgrades insecure requests to HTTPS

### How to Configure CSP

Edit `app/Http/Middleware/SecurityHeaders.php`:

```php
// In getContentSecurityPolicy() method
$connectSrcs[] = 'https://your-api.example.com'; // Add external APIs
```

## 2. API Rate Limiting

Rate limiting is enforced per endpoint to prevent abuse and ensure fair resource usage.

### Rate Limits by Endpoint

| Endpoint | Limit | Window | Key |
|----------|-------|--------|-----|
| `/api/login` | 5 | 1 minute | IP + path |
| `/api/register` | 5 | 1 minute | IP + path |
| `/api/bookings` (read) | 20 | 1 minute | User ID or IP |
| `/api/bookings` (create) | 20/100 | 1 min/1 hour | User ID |
| `/api/locations/*` | 30 | 1 minute | IP |
| `/api/distance/*` | 20 | 1 minute | IP |
| `/api/health/*` | 60 | 1 minute | IP |
| `/api/midtrans/notification` | 100 | 1 minute | IP |

### Rate Limit Response

When a client exceeds rate limits, they receive:

```http
HTTP/1.1 429 Too Many Requests

X-RateLimit-Limit: 5
X-RateLimit-Remaining: 0
X-RateLimit-Reset: 1731707180

Retry-After: 42

{
  "message": "Too many requests. Please retry after 42 seconds."
}
```

### Configuring Rate Limits

Edit `app/Http/Middleware/ApiRateLimiting.php`:

```php
private function getApiRateLimits(Request $request): array
{
    // Add your endpoint here
    if (preg_match('/^api\/your-endpoint/', $path)) {
        return [10 => 60]; // 10 per minute
    }
}
```

Or in routes:

```php
Route::post('/api/example', $controller)->middleware('throttle:10,60');
```

### Client Best Practices

1. **Monitor Rate Limit Headers:**
   ```javascript
   const remaining = response.headers['x-ratelimit-remaining'];
   if (remaining < 5) {
     console.warn('Approaching rate limit');
   }
   ```

2. **Implement Exponential Backoff:**
   ```javascript
   async function fetchWithRetry(url, maxRetries = 3) {
     for (let i = 0; i < maxRetries; i++) {
       try {
         return await fetch(url);
       } catch (error) {
         if (error.status === 429) {
           const retryAfter = parseInt(error.headers['retry-after']);
           await sleep(retryAfter * 1000 * Math.pow(2, i));
         }
       }
     }
   }
   ```

3. **Cache Results When Possible:**
   ```javascript
   const cache = new Map();
   
   async function fetchLocation(id) {
     if (cache.has(id)) {
       return cache.get(id);
     }
     const data = await fetch(`/api/locations/${id}`);
     cache.set(id, data);
     return data;
   }
   ```

## 3. Sanctum Authentication

Sanctum provides token-based API authentication for stateless API clients.

### Setup

Sanctum is already configured. Verify in `config/sanctum.php`:

```php
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS')),
'expiration' => 525600, // Token lifetime (365 days)
'middleware' => [
    'verify_csrf_token' => \App\Http\Middleware\VerifyCsrfToken::class,
    'encrypt_cookies' => \App\Http\Middleware\EncryptCookies::class,
],
```

### API Token Authentication

**1. Register a User:**
```bash
POST /api/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}

Response (201 Created):
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "3|xyz...abc"
}
```

**2. Login and Get Token:**
```bash
POST /api/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}

Response (200 OK):
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "token": "3|xyz...abc"
}
```

**3. Use Token in Requests:**
```bash
GET /api/bookings
Authorization: Bearer 3|xyz...abc

Response (200 OK):
{
  "data": [...]
}
```

**4. Logout (Revoke Token):**
```bash
POST /api/logout
Authorization: Bearer 3|xyz...abc

Response (200 OK):
{
  "message": "Logged out successfully"
}
```

### Token Management

**Create Personal Access Token (CLI):**
```bash
php artisan tinker
>>> $user = App\Models\User::first();
>>> $token = $user->createToken('Mobile App')->plainTextToken;
>>> echo $token;
```

**Revoke All Tokens:**
```bash
php artisan tinker
>>> $user = App\Models\User::first();
>>> $user->tokens()->delete(); // Revoke all tokens
```

**List User Tokens:**
```bash
php artisan tinker
>>> $user = App\Models\User::first();
>>> $user->tokens()->get();
```

### Token Scopes (Advanced)

Define scopes to limit token permissions:

```php
// In app/Http/Controllers/Api/AuthController.php
$token = $user->createToken('token-name', ['bookings:read', 'bookings:create']);

// In routes (future enhancement)
Route::get('/bookings', $controller)->middleware('auth:sanctum', 'scope:bookings:read');
Route::post('/bookings', $controller)->middleware('auth:sanctum', 'scope:bookings:create');
```

## 4. CSRF Protection

CSRF protection is enabled for web forms but disabled for API routes (which use token auth).

### Web Forms

Ensure all forms include CSRF token:

```blade
<form method="POST" action="/admin/tours">
    @csrf
    <!-- form fields -->
</form>
```

### API Requests

For API clients, use token authentication (Sanctum) instead of cookies:

```javascript
// ❌ Don't rely on cookie-based CSRF for API
// ✅ Use Sanctum tokens instead
const token = localStorage.getItem('api_token');
fetch('/api/bookings', {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({ /* ... */ })
});
```

## 5. HTTPS / SSL Configuration

### Local Development

Use self-signed certificates:

```bash
php artisan serve --host=localhost --port=8000

# Or with SSL (Laravel Valet):
valet secure paradise
```

### Production

1. **Obtain SSL Certificate:**
   - Use Let's Encrypt (free): [certbot.eff.org](https://certbot.eff.org)
   - Or commercial provider (Comodo, DigiCert, etc.)

2. **Configure Server:**
   ```nginx
   # Nginx example
   server {
       listen 443 ssl http2;
       server_name paradiseofindonesia.com;
       
       ssl_certificate /etc/letsencrypt/live/paradiseofindonesia.com/fullchain.pem;
       ssl_certificate_key /etc/letsencrypt/live/paradiseofindonesia.com/privkey.pem;
       
       # Strong SSL config
       ssl_protocols TLSv1.2 TLSv1.3;
       ssl_ciphers HIGH:!aNULL:!MD5;
   }
   
   # Redirect HTTP to HTTPS
   server {
       listen 80;
       server_name paradiseofindonesia.com;
       return 301 https://$server_name$request_uri;
   }
   ```

3. **Verify Certificate:**
   ```bash
   curl -I https://paradiseofindonesia.com
   # Should show: HTTP/1.1 200 OK
   ```

## 6. Environment Variables

Add these to `.env` for security configuration:

```env
# CORS settings
CORS_ALLOWED_ORIGINS=https://app.paradiseofindonesia.com,https://mobile.paradiseofindonesia.com

# Session settings
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=strict

# API settings
SANCTUM_EXPIRATION=525600

# Rate limiting (optional custom config)
RATE_LIMIT_ENABLED=true
RATE_LIMIT_PER_MINUTE=60
```

## 7. Security Checklist

Before deploying to production:

- [ ] Enable HTTPS/SSL certificates
- [ ] Set `APP_DEBUG=false` in production
- [ ] Configure environment-specific `.env` file
- [ ] Set strong `APP_KEY` (already generated by `artisan key:generate`)
- [ ] Enable rate limiting on all public endpoints
- [ ] Review and customize CSP headers
- [ ] Set `SESSION_SECURE_COOKIE=true`
- [ ] Enable `SESSION_HTTP_ONLY=true`
- [ ] Configure allowed CORS origins
- [ ] Implement input validation on all endpoints
- [ ] Use parameterized queries (Eloquent already does this)
- [ ] Keep dependencies updated: `composer outdated` and `npm outdated`
- [ ] Run security audit: `composer audit` and `npm audit`
- [ ] Set up monitoring/logging for security events
- [ ] Implement API key rotation policy
- [ ] Enable 2FA for admin accounts (future enhancement)

## 8. Testing Security

### Test Rate Limiting

```bash
# Simulate multiple requests
for i in {1..10}; do
  curl -X GET "https://localhost/api/health"
done

# Should receive 429 Too Many Requests after limit exceeded
```

### Test Security Headers

```bash
curl -I https://localhost

# Should see:
# Strict-Transport-Security
# X-Content-Type-Options
# X-Frame-Options
# Content-Security-Policy
```

### Test Sanctum Authentication

```bash
# Get token
TOKEN=$(curl -s -X POST http://localhost/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}' \
  | jq -r '.token')

# Use token
curl -X GET http://localhost/api/bookings \
  -H "Authorization: Bearer $TOKEN"
```

## 9. Monitoring & Logging

### Log Rate Limit Violations

In `.env`:
```env
LOG_LEVEL=info
```

Check logs:
```bash
tail -f storage/logs/laravel.log | grep "throttle"
```

### Alert on Security Events

For production, integrate with Sentry (see MONITORING.md):
```php
// app/Http/Middleware/SecurityHeaders.php
if (request()->header('X-Suspicious') === 'true') {
    Sentry::captureMessage('Suspicious request', 'warning');
}
```

## 10. Resources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [Laravel Security Documentation](https://laravel.com/docs/10.x/security)
- [Sanctum Documentation](https://laravel.com/docs/10.x/sanctum)
- [Content-Security-Policy Reference](https://content-security-policy.com/)
- [Mozilla Security Guidelines](https://infosec.mozilla.org/guidelines/web_security)

## Support

For security issues:
1. **Do not** open public issues for security vulnerabilities
2. Email security concerns to: `security@paradiseofindonesia.com` (or your contact)
3. See [SECURITY.md](../SECURITY.md) for vulnerability disclosure policy

## Related Documentation

- [CI_CD_SETUP.md](./CI_CD_SETUP.md) - Automated security scanning
- [SESSION_AND_DEPLOYMENT.md](./SESSION_AND_DEPLOYMENT.md) - Session security
- [IMAGE_PIPELINE.md](./IMAGE_PIPELINE.md) - Image security & validation
