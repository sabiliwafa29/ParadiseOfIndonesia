<?php

namespace App\Observers;

use App\Models\Tour;
use App\Models\TourPackage;

class TourObserver
{
    /**
     * Handle the Tour "created" event.
     */
    public function created(Tour $tour): void
    {
        // Saat tour baru dibuat, cari package dengan kategori yang sama
        // Misalnya: jika tour di East Java, tambahkan ke package East Java

        $packages = TourPackage::where('name_en', 'ILIKE', '%' . $tour->destination->name_en . '%')
            ->orWhere('name_id', 'ILIKE', '%' . $tour->destination->name_id . '%')
            ->orWhere('name_zh', 'ILIKE', '%' . $tour->destination->name_zh . '%')
            ->get();

        foreach ($packages as $package) {
            // Cek apakah tour sudah ada di package
            if (!$package->tours()->where('tour_id', $tour->id)->exists()) {
                $package->tours()->attach($tour->id);
            }
        }
    }

    /**
     * Handle the Tour "updated" event.
     */
    public function updated(Tour $tour): void
    {
        //
    }

    /**
     * Handle the Tour "deleted" event.
     */
    public function deleted(Tour $tour): void
    {
        // Saat tour dihapus, hapus juga dari semua package
        $tour->tourPackages()->detach();
    }
}