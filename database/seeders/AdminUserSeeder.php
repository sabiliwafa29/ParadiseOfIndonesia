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
        \App\Models\User::create([
            'name' => 'Admin Paradise',
            'email' => 'admin@paradiseofindonesia.com',
            'password' => \Illuminate\Support\Facades\Hash::make('paradise123'),
            'role' => 'admin',
        ]);
    }
}
