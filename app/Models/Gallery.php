<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'image_derivatives' => 'json',
    ];

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function getTitleAttribute(): ?string
    {
        return $this->attributes['title'] ?? $this->attributes['name'] ?? null;
    }

    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = $value;
        if (empty($this->attributes['name'])) {
            $this->attributes['name'] = $value;
        }
    }

    public function getNameAttribute(): ?string
    {
        return $this->attributes['name'] ?? $this->attributes['title'] ?? null;
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = $value;
        if (empty($this->attributes['title'])) {
            $this->attributes['title'] = $value;
        }
    }

    public function getImageAttribute(): ?string
    {
        return $this->attributes['path'] ?? null;
    }

    public function setImageAttribute($value): void
    {
        $this->attributes['path'] = $value;
    }

    public function getPathAttribute(): ?string
    {
        return $this->attributes['path'] ?? null;
    }

    public function setPathAttribute($value): void
    {
        $this->attributes['path'] = $value;
    }

    public function getImageUrlAttribute(): string
    {
        $imgPath = $this->path;

        if (!empty($imgPath)) {
            if (str_starts_with($imgPath, 'http://') || str_starts_with($imgPath, 'https://')) {
                return $imgPath;
            }

            if (file_exists(public_path($imgPath))) {
                return asset($imgPath);
            }

            if (Storage::disk('public')->exists($imgPath)) {
                return Storage::disk('public')->url($imgPath);
            }

            return asset('storage/' . ltrim($imgPath, '/'));
        }

        return asset('images/Danau-Toba.png');
    }
}
