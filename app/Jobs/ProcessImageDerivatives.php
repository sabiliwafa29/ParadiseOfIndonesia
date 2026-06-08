<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessImageDerivatives implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $path;
    public string $disk;
    public ?Model $model;

    /**
     * Create a new job instance.
     */
    public function __construct(string $path, string $disk = 'public', ?Model $model = null)
    {
        $this->path = $path;
        $this->disk = $disk;
        $this->model = $model;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // If Intervention Image is not installed, skip processing
        if (!class_exists(\Intervention\Image\ImageManagerStatic::class)) {
            return;
        }

        // Add Sentry breadcrumb and context when available to help diagnose failures
        if (class_exists(\Sentry\SentrySdk::class) && env('SENTRY_LARAVEL_DSN')) {
            try {
                \Sentry\configureScope(function (\Sentry\State\Scope $scope): void {
                    $scope->setContext('image_processing', [
                        'path' => $this->path,
                        'disk' => $this->disk,
                        'model_class' => $this->model ? get_class($this->model) : null,
                        'model_id' => $this->model ? ($this->model->id ?? null) : null,
                    ]);

                    $scope->addBreadcrumb(new \Sentry\Breadcrumb([
                        'message' => 'ProcessImageDerivatives job started',
                        'category' => 'image',
                        'level' => \Sentry\Severity::info(),
                    ]));
                });
            } catch (\Throwable $e) {
                // ignore Sentry configuration errors
            }
        }

        try {
            $contents = Storage::disk($this->disk)->get($this->path);
            $image = \Intervention\Image\ImageManagerStatic::make($contents);

            $info = pathinfo($this->path);
            $dir = isset($info['dirname']) && $info['dirname'] !== '.' ? rtrim($info['dirname'], '/') . '/' : '';
            $filename = $info['filename'] ?? 'image';
            $extension = isset($info['extension']) ? $info['extension'] : 'jpg';

            // Optimize original: re-encode with 85% quality
            $optimized = (string) $image->encode($extension, 85);
            Storage::disk($this->disk)->put($this->path, $optimized);

            // Medium size (1200w)
            $mdImage = $image->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $mdPath = $dir . $filename . '_md.' . $extension;
            Storage::disk($this->disk)->put($mdPath, (string) $mdImage->encode($extension, 85));

            // Thumbnail (fit 400x300)
            $thumbImage = $image->fit(400, 300);
            $thumbPath = $dir . $filename . '_thumb.' . $extension;
            Storage::disk($this->disk)->put($thumbPath, (string) $thumbImage->encode($extension, 80));

            // Persist derivative paths to model
            if ($this->model) {
                $this->model->update([
                    'image_derivatives' => [
                        'md' => $mdPath,
                        'thumb' => $thumbPath,
                    ],
                ]);
            }
        } catch (\Throwable $e) {
            report($e);
            if (class_exists(\Sentry\SentrySdk::class) && env('SENTRY_LARAVEL_DSN')) {
                try {
                    \Sentry\captureException($e);
                } catch (\Throwable $sentryEx) {
                    report($sentryEx);
                }
            }
        }
    }
}
