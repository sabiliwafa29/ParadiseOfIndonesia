@php
    /**
     * Responsive image partial
     * Parameters:
     * - $path (string) : path stored in disk (e.g., 'gallery/abcd.jpg')
     * - $alt (string)
     * - $class (string)
     * - $sizes (string) optional
     * - $derivatives (array) optional: {md: path, thumb: path} from model->image_derivatives
     */
    $path = $path ?? '';
    $alt = $alt ?? '';
    $class = $class ?? '';
    $sizes = $sizes ?? '100vw';
    $derivatives = $derivatives ?? null;

    if (!$path) {
        echo '<img src="' . e(asset('images/placeholder.png')) . '" alt="' . e($alt) . '" class="' . e($class) . '">';
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
            // If derivative paths are persisted, use them; otherwise check Storage
            $hasThumb = isset($derivatives['thumb']) || \Illuminate\Support\Facades\Storage::exists($thumbPath);
            $hasMd = isset($derivatives['md']) || \Illuminate\Support\Facades\Storage::exists($mdPath);

            if ($hasThumb) {
                $srcset[] = \Illuminate\Support\Facades\Storage::url($thumbPath) . ' 400w';
            }

            if ($hasMd) {
                $srcset[] = \Illuminate\Support\Facades\Storage::url($mdPath) . ' 1200w';
            }

            // Always include original as largest fallback
            $srcset[] = \Illuminate\Support\Facades\Storage::url($path) . ' 2000w';
            $src = $hasMd
                ? \Illuminate\Support\Facades\Storage::url($mdPath)
                : \Illuminate\Support\Facades\Storage::url($path);
        } else {
            $src = asset('storage/' . $path);
        }
    } catch (\Throwable $e) {
        // On any error, fall back to non-srcset single image
        $src = class_exists(\Illuminate\Support\Facades\Storage::class)
            ? \Illuminate\Support\Facades\Storage::url($path)
            : asset('storage/' . $path);
        $srcset = [];
    }

    $srcsetAttr = count($srcset) ? implode(', ', $srcset) : '';
@endphp

<img src="{{ $src }}" @if($srcsetAttr) srcset="{{ $srcsetAttr }}" sizes="{{ $sizes }}" @endif alt="{{ $alt }}" class="{{ $class }}">
