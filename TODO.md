# OSRM Integration for Travel Service Distance Calculation

## Current Status
- [x] Plan approved by user
- [x] Create OsrmService
- [x] Add OSRM configuration
- [x] Update TravelServiceController
- [x] Create API endpoint for distance calculation
- [ ] Update frontend booking view
- [x] Add fallback mechanism
- [ ] Test implementation

## Detailed Steps

### 1. Create OsrmService (`app/Services/OsrmService.php`)
- [x] Implement HTTP client for OSRM API calls
- [x] Parse routing responses (distance, duration)
- [x] Add fallback to Haversine calculation
- [x] Error handling and logging

### 2. Add OSRM Configuration (`config/services.php`)
- [x] OSRM API base URL
- [x] Timeout settings
- [x] Profile settings (driving)

### 3. Update TravelServiceController (`app/Http/Controllers/TravelServiceController.php`)
- [x] Replace calculateDistance() method
- [x] Inject OsrmService
- [x] Add error handling

### 4. Create API Endpoint (`routes/api.php`)
- [x] New route for distance calculation
- [x] Controller method for frontend requests (DistanceController)

### 5. Update Frontend (`resources/views/travel-services/booking.blade.php`)
- [x] Replace Leaflet routing with API calls
- [x] Update JavaScript for real-time distance
- [x] Handle loading states and errors
- [x] Keep Leaflet for map visualization only

### 6. Followup Tasks
- [x] Install/update Guzzle HTTP client (already in composer.json)
- [x] Test with Indonesian coordinates (Bali coordinates: 14.56 km, OSRM working)
- [ ] Implement caching (Redis)
- [ ] Add rate limiting for OSRM API calls
- [ ] Create unit tests for OsrmService
- [ ] Add monitoring/logging for API response times

## Production Readiness Implementation

### 7. Caching Implementation
- [ ] Install/configure Redis
- [ ] Add cache layer to OsrmService
- [ ] Implement cache key strategy (coordinates-based)
- [ ] Set appropriate TTL (24 hours for distance data)

### 8. Rate Limiting
- [ ] Add rate limiting middleware
- [ ] Configure limits per user/IP
- [ ] Add rate limit headers to responses
- [ ] Handle rate limit exceeded responses

### 9. Testing Suite
- [ ] Create unit tests for OsrmService
- [ ] Test OSRM API integration
- [ ] Test Haversine fallback
- [ ] Test error handling scenarios

### 10. Monitoring & Logging
- [ ] Add response time logging
- [ ] Implement performance metrics
- [ ] Add health check endpoint
- [ ] Error tracking and alerting
