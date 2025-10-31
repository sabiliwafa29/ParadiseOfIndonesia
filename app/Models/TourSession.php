<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourSession extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Get the tourPackage that owns the TourSession
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tourPackage(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class);
    }
}
