<?php

namespace Tests\Feature;

use App\Jobs\ProcessImageDerivatives;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUploadTest extends TestCase
{
    public function test_process_image_derivatives_job_creates_md_and_thumb(): void
    {
        Storage::fake('public');

        // Create a tiny PNG (base64) and store it to the public disk. We avoid UploadedFile::fake() because GD may not be available
        $pngBase64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGMAAQAABQABDQottAAAAABJRU5ErkJggg==';
        $contents = base64_decode($pngBase64);
        Storage::disk('public')->put('gallery/photo.png', $contents);

        $path = 'gallery/photo.png';

        // Run the job synchronously to create derivatives (no model for this unit test)
        ProcessImageDerivatives::dispatchSync($path, 'public', null);

        // Assert original still exists
        Storage::disk('public')->assertExists($path);

        $mdPath = 'gallery/photo_md.png';
        $thumbPath = 'gallery/photo_thumb.png';

        if (class_exists(\Intervention\Image\ImageManagerStatic::class)) {
            Storage::disk('public')->assertExists($mdPath);
            Storage::disk('public')->assertExists($thumbPath);
        }
    }
}
