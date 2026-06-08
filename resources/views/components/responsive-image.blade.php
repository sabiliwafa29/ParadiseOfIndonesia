@php
    /**
     * Responsive image partial
     * Parameters:
     * - $path (string) : path stored in disk (e.g., 'gallery/abcd.jpg')
     * - $alt (string)
     * - $class (string)
     * - $sizes (string) optional
     * - $derivatives (array) optional: {md: path, thumb: path} from model->image_derivatives
     * - $lazy (boolean) optional: enable lazy loading (default: true)
     */
    $path = $path ?? '';
    $alt = $alt ?? '';
    $class = $class ?? '';
    $sizes = $sizes ?? '100vw';
    $derivatives = $derivatives ?? null;
    $lazy = $lazy ?? true;
    
    // SVG placeholder as data URI
    $placeholderSvg = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="800" height="600" viewBox="0 0 800 600"%3E%3Crect fill="%23e5e7eb" width="800" height="600"/%3E%3Ctext x="50%25" y="50%25" dominant-baseline="middle" text-anchor="middle" font-family="sans-serif" font-size="24" fill="%239ca3af"%3EImage not found%3C/text%3E%3C/svg%3E';

    if (!$path) {
        echo '<img src="' . e($placeholderSvg) . '" alt="' . e($alt) . '" class="' . e($class) . '" loading="lazy">';
        return;
    }

    $info = pathinfo($path);
    $dir = isset($info['dirname']) && $info['dirname'] !== '.' ? rtrim($info['dirname'], '/') . '/' : '';
    $filename = $info['filename'] ?? '';
    $ext = isset($info['extension']) ? $info['extension'] : '';

    $thumbPath = isset($derivatives['thumb']) ? $derivatives['thumb'] : ($dir . $filename . '_thumb' . ($ext ? '.' . $ext : ''));
    $mdPath = isset($derivatives['md']) ? $derivatives['md'] : ($dir . $filename . '_md' . ($ext ? '.' . $ext : ''));

    $srcset = [];
    try {
        if (class_exists(\Illuminate\Support\Facades\Storage::class)) {
            // Check if file exists in Storage disk (storage/app/public)
            $inStorageDisk = \Illuminate\Support\Facades\Storage::disk('public')->exists($path);
            
            if ($inStorageDisk) {
                // File is in storage disk, use Storage::url()
                $hasThumb = isset($derivatives['thumb']) || \Illuminate\Support\Facades\Storage::disk('public')->exists($thumbPath);
                $hasMd = isset($derivatives['md']) || \Illuminate\Support\Facades\Storage::disk('public')->exists($mdPath);

                if ($hasThumb) {
                    $srcset[] = \Illuminate\Support\Facades\Storage::disk('public')->url($thumbPath) . ' 400w';
                }

                if ($hasMd) {
                    $srcset[] = \Illuminate\Support\Facades\Storage::disk('public')->url($mdPath) . ' 1200w';
                }

                // Always include original as largest fallback
                $srcset[] = \Illuminate\Support\Facades\Storage::disk('public')->url($path) . ' 2000w';
                $src = $hasMd
                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($mdPath)
                    : \Illuminate\Support\Facades\Storage::disk('public')->url($path);
            } else {
                // File is in public directory, use asset()
                $publicPath = 'public/' . $path;
                $publicThumbPath = 'public/' . $thumbPath;
                $publicMdPath = 'public/' . $mdPath;
                
                $hasThumb = isset($derivatives['thumb']) || file_exists(public_path($path)) && file_exists(public_path($thumbPath));
                $hasMd = isset($derivatives['md']) || file_exists(public_path($path)) && file_exists(public_path($mdPath));

                if ($hasThumb) {
                    $srcset[] = asset($thumbPath) . ' 400w';
                }

                if ($hasMd) {
                    $srcset[] = asset($mdPath) . ' 1200w';
                }

                // Always include original as largest fallback
                $srcset[] = asset($path) . ' 2000w';
                $src = $hasMd ? asset($mdPath) : asset($path);
            }
        } else {
            $src = asset('storage/' . $path);
        }
    } catch (\Throwable $e) {
        // On any error, fall back to asset() path
        $src = asset($path);
        $srcset = [];
    }

    $srcsetAttr = count($srcset) ? implode(', ', $srcset) : '';
    $loadingAttr = $lazy ? 'lazy' : 'eager';
@endphp

<img src="{{ $src }}" 
     @if($srcsetAttr) srcset="{{ $srcsetAttr }}" sizes="{{ $sizes }}" @endif 
     alt="{{ $alt }}" 
     class="{{ $class }}"
     loading="{{ $loadingAttr }}"
     decoding="async"
     onerror="this.onerror=null; this.src='{{ $placeholderSvg }}'; this.srcset='';">

