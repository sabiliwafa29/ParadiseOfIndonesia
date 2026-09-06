<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@pnbtravel.com'],
            [
                'name' => 'Admin PNB Travel',
                'password' => \Illuminate\Support\Facades\Hash::make('Pnbtravel#2026$'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
