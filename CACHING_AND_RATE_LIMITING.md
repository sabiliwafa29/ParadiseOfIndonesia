# Redis Caching & Rate Limiting Implementation Guide

## Overview

This document provides comprehensive setup and usage information for Redis caching and API rate limiting in the Paradise of Indonesia application.

## Current Status

✅ **Already Implemented:**
- Redis configuration in `config/cache.php` and `.env`
- OSRM response caching (24-hour TTL)
- OSRM API rate limiting middleware (10 requests/minute per IP)
- Rate limit headers in API responses

## 1. Redis Setup

### Local Development

**Prerequisites:**
- Redis server installed and running on `localhost:6379`

**Installation (Windows with WSL2):**
```bash
wsl
sudo apt-get update
sudo apt-get install redis-server
redis-server
```

**Installation (macOS with Homebrew):**
```bash
brew install redis
brew services start redis
```

**Installation (Linux):**
```bash
sudo apt-get update
sudo apt-get install redis-server
sudo systemctl start redis-server
```

**Verification:**
```bash
redis-cli ping
# Should respond with: PONG
```

### Production (Vercel/Railway)

**Option 1: Redis Cloud (Recommended)**
```
1. Create account at redis.com
2. Create a free Redis database
3. Get connection credentials
4. Update .env:
   REDIS_HOST=<your-redis-cloud-host>
   REDIS_PASSWORD=<your-redis-cloud-password>
   REDIS_PORT=6379
```

**Option 2: Railway.app**
```
1. Add Redis plugin to Railway project
2. Copy connection details
3. Update .env with provided credentials
```

## 2. Cache Configuration

### Current Cache Driver Setup

**File: `.env`**
```properties
CACHE_DRIVER=file              # Change to 'redis' for production
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=null            # Set if using password
```

### Switch to Redis

**For local development:**
```bash
# Start Redis
redis-server

# Update .env
CACHE_DRIVER=redis
```

**For production:**
```bash
# Update .env
CACHE_DRIVER=redis
REDIS_HOST=your-redis-host
REDIS_PASSWORD=your-redis-password
REDIS_PORT=6379
```

## 3. OSRM Response Caching

### How It Works

The `OsrmService` automatically caches route calculations:

```php
public function calculateRoute(
    float $startLat, 
    float $startLng, 
    float $endLat, 
    float $endLng
): ?array
{
    // Cache key: osrm_route_-6.2000_106.8166_-6.3000_106.9000
    $cacheKey = sprintf(
        'osrm_route_%.4f_%.4f_%.4f_%.4f',
        $startLat, $startLng, $endLat, $endLng
    );
    
    // Cache hit?
    $cachedResult = Cache::get($cacheKey);
    if ($cachedResult) {
        Log::info('OSRM cache hit', ['key' => $cacheKey]);
        return $cachedResult;
    }
    
    // Call OSRM API...
    // Cache result for 24 hours
    Cache::put($cacheKey, $result, now()->addHours(24));
}
```

### Cache Statistics

- **Key Pattern:** `paradise_cache_osrm_route_LAT_LNG_LAT_LNG`
- **Default TTL:** 24 hours
- **Coordinate Precision:** 4 decimal places (≈11 meters)
- **Expected Hit Rate:** 70-80% for popular routes

### Monitor Cache Performance

**Check cache hits/misses via logs:**
```bash
tail -f storage/logs/laravel.log | grep "OSRM"
```

**View cached keys:**
```bash
redis-cli
> KEYS paradise_cache_osrm_route*
> GET paradise_cache_osrm_route_-6.2000_106.8166_-6.3000_106.9000
> TTL paradise_cache_osrm_route_-6.2000_106.8166_-6.3000_106.9000
```

## 4. API Rate Limiting

### OSRM Distance Endpoint

**Route:** `GET /api/distance/calculate`

**Rate Limit Rules:**
- **Limit:** 10 requests per minute
- **Per:** IP address
- **Status on Limit Exceeded:** 429 Too Many Requests

**Response Headers:**
```http
X-RateLimit-Limit: 10
X-RateLimit-Remaining: 5
X-RateLimit-Reset: 1700000000
Retry-After: 45
```

### Example Usage

```javascript
// Client-side handling
const calculateDistance = async (start, end) => {
  try {
    const response = await fetch(
      `/api/distance/calculate?start=${start}&end=${end}`
    );
    
    if (response.status === 429) {
      const retryAfter = response.headers.get('Retry-After');
      throw new Error(`Rate limited. Retry after ${retryAfter}s`);
    }
    
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Distance calculation failed:', error);
  }
};
```

### Rate Limit Middleware

**File:** `app/Http/Middleware/OsrmRateLimit.php`

**Key Features:**
- Per-IP rate limiting
- Custom error response (JSON)
- Rate limit headers included
- Logging of rate limit violations

**Monitor rate limit violations:**
```bash
tail -f storage/logs/laravel.log | grep "rate limit exceeded"
```

## 5. Caching Best Practices

### For Location Services

Consider adding caching to `LocationService`:

```php
namespace App\Services;

use Illuminate\Support\Facades\Cache;

class LocationService
{
    public function search($query, $type = 'city')
    {
        $cacheKey = "location_search_{$type}_" . md5($query);
        
        // Try cache first
        return Cache::remember($cacheKey, now()->addHours(24), function () use ($query, $type) {
            // Call Nominatim or other geocoding service
            return $this->searchNominatim($query, $type);
        });
    }
}
```

### For Booking Calculations

Cache booking price calculations:

```php
$priceKey = "booking_price_tour_{$tourId}_guests_{$guests}";

$price = Cache::remember($priceKey, now()->addDays(7), function () use ($tour, $guests) {
    return $tour->price * $guests;
});
```

## 6. Cache Management Commands

**Clear all cache:**
```bash
php artisan cache:clear
```

**Clear specific cache store:**
```bash
php artisan cache:clear --store=redis
```

**View cache configuration:**
```bash
php artisan config:show cache
```

**Test cache functionality:**
```bash
php artisan tinker
> Cache::put('test_key', 'test_value', now()->addMinutes(5))
> Cache::get('test_key')
> Cache::forget('test_key')
```

## 7. Monitoring & Alerts

### Redis Memory Usage

```bash
redis-cli INFO memory
```

**Track over time:**
```bash
# Create monitoring script
watch -n 5 'redis-cli INFO memory | grep used_memory'
```

### Eviction Policy

For production, set eviction policy in Redis config:

```bash
# redis.conf or via redis-cli
maxmemory 256mb
maxmemory-policy allkeys-lru  # Evict least-recently-used keys
```

### Cache Hit Ratio

Monitor in application logs:

```bash
# Query logs for cache statistics
grep "OSRM cache hit" storage/logs/laravel.log | wc -l
grep "OSRM result cached" storage/logs/laravel.log | wc -l
```

## 8. Troubleshooting

### Issue: "Redis connection failed"

**Solution:**
```bash
# Check if Redis is running
redis-cli ping

# If not running:
redis-server

# Check connection in .env
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=null
```

### Issue: High memory usage

**Solutions:**
1. Check `CACHE_DRIVER=file` is not using Redis (memory leak)
2. Set Redis `maxmemory` and eviction policy
3. Clear old cache keys: `FLUSHDB`
4. Monitor with `redis-cli MEMORY STATS`

### Issue: Slow cache responses

**Check latency:**
```bash
redis-cli --latency
```

**Solutions:**
1. Increase Redis `tcp-backlog` setting
2. Check network connectivity
3. Monitor CPU: `redis-cli INFO stats`

## 9. Performance Gains

### Expected Improvements with Redis

| Metric | File Cache | Redis Cache |
|--------|-----------|-------------|
| OSRM Hit Time | 50-100ms | 5-10ms |
| Memory Usage | Disk I/O | In-memory |
| Scalability | Limited | Excellent |
| Reliability | Single node | ✓ Cluster ready |

### Real-World Example

**Without Caching:**
- 100 distance calculations/day
- Average OSRM response: 500ms
- Total time: 50 seconds/day

**With Redis Caching (75% hit rate):**
- Cache hits: 75 × 5ms = 375ms
- Cache misses: 25 × 500ms = 12.5s
- Total time: 12.875 seconds/day
- **Improvement: 75% faster! ⚡**

## 10. Next Steps

1. ✅ **Verify Redis is running** in local development
2. ✅ **Update CACHE_DRIVER** in .env to `redis`
3. ✅ **Monitor cache performance** with logs
4. ⏳ **Consider implementing** caching for LocationService
5. ⏳ **Setup alerts** for Redis memory usage in production
6. ⏳ **Document rate limits** in API documentation

---

**Configuration Files:**
- `config/cache.php` - Cache store configuration
- `config/database.php` - Redis connection configuration
- `app/Http/Middleware/OsrmRateLimit.php` - Rate limiting logic
- `app/Services/OsrmService.php` - OSRM caching logic

**Environment Variables:**
- `CACHE_DRIVER` - Cache backend (file, redis, etc.)
- `REDIS_HOST` - Redis server host
- `REDIS_PORT` - Redis server port
- `REDIS_PASSWORD` - Redis authentication (optional)
