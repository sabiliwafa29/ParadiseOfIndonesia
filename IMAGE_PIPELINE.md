# Image Optimization & CDN Pipeline

This document describes the image upload, optimization, and CDN delivery pipeline for Paradise of Indonesia.

## Overview

The image pipeline processes uploads through the following stages:

1. **Upload**: Admin uploads an image via a form (Gallery, Tour, Destination, Tour Package, Travel Service).
2. **Storage**: Image is stored to the configured disk (`public` by default, `s3` in production).
3. **Optimization Job**: `ProcessImageDerivatives` job is dispatched (sync in development, queued in production).
4. **Derivatives**: Job creates three versions:
   - **Original**: Re-encoded at 85% quality for compression.
   - **Medium (`_md`)**: Resized to 1200px width (aspect ratio preserved).
   - **Thumbnail (`_thumb`)**: Fitted to 400x300px.
5. **Persistence**: Derivative paths stored in model's `image_derivatives` JSON column.
6. **Delivery**: Views use `Storage::url()` with srcset pointing to derivatives; CDN serves if configured.

## Configuration

### Environment Variables

Add these to `.env` (and `.env.example`):

```bash
# Storage Disk (local, s3)
FILESYSTEM_DISK=local
# For production: FILESYSTEM_DISK=s3

# AWS S3 Configuration
AWS_ACCESS_KEY_ID=your-key-id
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
# Optional: Override S3 URL (useful for VirtualHost/custom domain)
AWS_URL=

# CDN Configuration (optional)
# If you use CloudFront, Cloudflare, or another CDN in front of S3/storage
CDN_URL=https://cdn.example.com
# Without CDN_URL, images resolve to: APP_URL/storage (local) or S3 URL (s3 disk)

# Queue Configuration
QUEUE_CONNECTION=sync
# For production with queue workers: QUEUE_CONNECTION=redis
```

### Filesystems Config

File: `config/filesystems.php`

The `public` disk is configured to respect `CDN_URL`:

```php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('CDN_URL', env('APP_URL').'/storage'),
    'visibility' => 'public',
    'throw' => false,
],
```

The `s3` disk is automatically available:

```php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    'throw' => false,
],
```

## Database Migration

Run the migration to add `image_derivatives` JSON column to image-bearing models:

```bash
php artisan migrate
```

This adds `image_derivatives` to:
- `galleries`
- `tours`
- `destinations`
- `tour_packages`
- `travel_services`

Each column stores:

```json
{
  "md": "path/to/image_md.jpg",
  "thumb": "path/to/image_thumb.jpg"
}
```

## Image Processing Job

### Job Class

File: `app/Jobs/ProcessImageDerivatives.php`

**Behavior:**
- Accepts: `$path` (string), `$disk` (string, default 'public'), `$model` (optional Eloquent Model).
- If `Intervention\Image` is not installed, job silently skips (best-effort).
- On error: exception is reported but job does not fail.
- Derivatives are persisted to `$model->image_derivatives` if model provided.

**Note:** Ensure Intervention Image is installed:

```bash
composer require intervention/image
```

### Dispatching from Controllers

All admin upload controllers (Gallery, Tour, Destination, TourPackage, TravelService) dispatch the job:

```php
if ($request->hasFile('image')) {
    $validated['image'] = $request->file('image')->store('tours', 'public');
}

$tour = Tour::create($validated);

if ($request->hasFile('image') && $validated['image']) {
    if (config('queue.default') === 'sync') {
        ProcessImageDerivatives::dispatchSync($validated['image'], 'public', $tour);
    } else {
        ProcessImageDerivatives::dispatch($validated['image'], 'public', $tour);
    }
}
```

## Queue Configuration

### Development (Synchronous)

In `.env`:

```bash
QUEUE_CONNECTION=sync
```

Jobs run immediately when dispatched. Image processing blocks the request.

### Production (Asynchronous)

#### Option 1: Redis Queue

In `.env`:

```bash
QUEUE_CONNECTION=redis
REDIS_HOST=your-redis-host
REDIS_PASSWORD=
REDIS_PORT=6379
```

Run a queue worker on your server:

```bash
php artisan queue:work redis --tries=3 --timeout=3600
```

#### Option 2: Database Queue

Create database queue table:

```bash
php artisan queue:table
php artisan migrate
```

In `.env`:

```bash
QUEUE_CONNECTION=database
```

Run worker:

```bash
php artisan queue:work database --tries=3 --timeout=3600
```

#### Option 3: Supervisor (Recommended for Production)

Install Supervisor:

```bash
apt-get install supervisor
```

Create configuration file `/etc/supervisor/conf.d/paradise-queue.conf`:

```ini
[program:paradise-queue-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/paradise/artisan queue:work redis --sleep=3 --tries=3 --timeout=3600
autostart=true
autorestart=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/log/paradise-queue.log
```

Reload Supervisor:

```bash
supervisorctl reread
supervisorctl update
supervisorctl start paradise-queue-worker:*
```

## S3 & CDN Setup

### AWS S3 Configuration

1. **Create S3 Bucket:**
   - Go to AWS Console → S3
   - Create bucket (e.g., `paradise-images-prod`)
   - Enable versioning (optional)
   - Set public read permissions on objects

2. **Create IAM User:**
   - Go to IAM → Users → Add user
   - Permissions: Attach inline policy:
   ```json
   {
     "Version": "2012-10-17",
     "Statement": [
       {
         "Effect": "Allow",
         "Action": [
           "s3:PutObject",
           "s3:GetObject",
           "s3:DeleteObject",
           "s3:ListBucket"
         ],
         "Resource": [
           "arn:aws:s3:::paradise-images-prod",
           "arn:aws:s3:::paradise-images-prod/*"
         ]
       }
     ]
   }
   ```
   - Generate access key and secret key
   - Add to `.env`:
   ```bash
   AWS_ACCESS_KEY_ID=AKIAIOSFODNN7EXAMPLE
   AWS_SECRET_ACCESS_KEY=wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY
   AWS_DEFAULT_REGION=us-east-1
   AWS_BUCKET=paradise-images-prod
   FILESYSTEM_DISK=s3
   ```

3. **Test Connection:**
   ```bash
   php artisan tinker
   >>> Storage::disk('s3')->put('test.txt', 'Hello S3');
   >>> Storage::disk('s3')->get('test.txt');
   ```

### CloudFront CDN (AWS)

1. **Create CloudFront Distribution:**
   - Go to CloudFront → Create distribution
   - Origin domain: `paradise-images-prod.s3.us-east-1.amazonaws.com`
   - Viewer protocol: Redirect HTTP to HTTPS
   - Caching: Allow all cache headers
   - Create distribution
   - Note domain: `d123.cloudfront.net`

2. **Update `.env`:**
   ```bash
   CDN_URL=https://d123.cloudfront.net
   ```

3. **Images now serve via CDN** when `Storage::url()` is called.

### Cloudflare CDN

1. **Add S3 bucket origin to Cloudflare:**
   - Cloudflare dashboard → DNS → Add CNAME
   - Name: `cdn`
   - Target: `paradise-images-prod.s3.us-east-1.amazonaws.com`
   - Proxy status: Proxied (orange cloud)

2. **Update `.env`:**
   ```bash
   CDN_URL=https://cdn.example.com
   ```

3. **Optional: Configure caching rules in Cloudflare** for longer TTLs on image derivatives.

## Image Responsive Rendering

### Blade Component

File: `resources/views/components/responsive-image.blade.php`

**Usage in views:**

```blade
@include('components.responsive-image', [
    'path' => $tour->image,
    'alt' => 'Tour Image',
    'class' => 'w-full h-48 object-cover',
    'derivatives' => $tour->image_derivatives,
])
```

**Output:**

```html
<img src="https://cdn.example.com/tours/photo_md.jpg" 
     srcset="https://cdn.example.com/tours/photo_thumb.jpg 400w,
             https://cdn.example.com/tours/photo_md.jpg 1200w,
             https://cdn.example.com/tours/photo.jpg 2000w"
     sizes="100vw"
     alt="Tour Image"
     class="w-full h-48 object-cover">
```

Browsers automatically select the optimal resolution based on viewport size and device pixel ratio.

## Testing

### Unit Test

File: `tests/Feature/ImageUploadTest.php`

Run:

```bash
php artisan test tests/Feature/ImageUploadTest.php
```

This test:
- Fakes storage disk
- Creates a PNG image
- Dispatches `ProcessImageDerivatives` job
- Asserts original, medium, and thumbnail files exist (when Intervention is installed)

### Manual Testing

1. **Local Development:**
   ```bash
   FILESYSTEM_DISK=local php artisan serve
   ```
   - Upload image in admin panel
   - Check `storage/app/public/gallery/` for original, _md, _thumb
   - Verify `image_derivatives` JSON in database

2. **S3 Testing:**
   ```bash
   # Set env
   export AWS_ACCESS_KEY_ID=your-key
   export AWS_SECRET_ACCESS_KEY=your-secret
   export FILESYSTEM_DISK=s3
   
   # Upload and check S3 bucket
   aws s3 ls s3://paradise-images-prod/tours/
   ```

3. **CDN Testing:**
   - After upload, inspect image `src` in HTML
   - Should resolve to CDN URL
   - Test cache with `curl -I https://cdn.example.com/tours/photo_md.jpg`

## Troubleshooting

### Images not optimized (no _md, _thumb)

**Check:**
1. Is Intervention Image installed?
   ```bash
   composer show | grep intervention
   ```
   If missing:
   ```bash
   composer require intervention/image
   ```

2. Is queue running?
   ```bash
   php artisan queue:failed
   ```
   (If jobs failed, requeue with `php artisan queue:retry all`)

3. Check logs:
   ```bash
   tail -f storage/logs/laravel.log
   ```

### Images not serving from CDN

**Check:**
1. Is `CDN_URL` set in `.env`?
2. Is CDN origin correctly pointing to S3 or storage disk?
3. Test `Storage::url()` directly:
   ```bash
   php artisan tinker
   >>> Storage::url('tours/photo.jpg')
   ```

### S3 permission errors

**Check:**
1. IAM policy allows `s3:PutObject` and `s3:GetObject`
2. Bucket policy allows public read (if needed)
3. S3 credentials are correct

## Performance Tips

1. **Enable S3 Transfer Acceleration** (optional, extra cost):
   ```bash
   AWS_USE_PATH_STYLE_ENDPOINT=false
   ```

2. **Set CDN cache headers** in CloudFront/Cloudflare:
   - Cache images for 1 year (versioned by filename)
   - Set cache busting by appending `?v=timestamp` if needed

3. **Use srcset for responsive images**:
   - Thumbnail (400w) for mobile
   - Medium (1200w) for tablet/desktop
   - Original (2000w) for high-res displays

4. **Monitor queue performance**:
   ```bash
   php artisan queue:monitor --max=1000
   ```

## Security Considerations

1. **File upload validation**: Always validate file type and size
   ```php
   'image' => 'image|max:4096|mimetypes:image/jpeg,image/png,image/webp'
   ```

2. **S3 bucket policies**: Restrict access to app's IAM role only

3. **CDN origin shield**: Enable in CloudFront to reduce S3 requests

4. **Image resizing limits**: Prevent abuse by capping image dimensions in the job

## Future Enhancements

- [ ] Implement WebP format support
- [ ] Add image cropping interface
- [ ] Implement smart cropping for thumbnails
- [ ] Add image lazy-loading with blur-up effect
- [ ] Integrate with image optimization services (TinyPNG, ImageOptim)
- [ ] Add batch image processing
- [ ] Implement image versioning and rollback
