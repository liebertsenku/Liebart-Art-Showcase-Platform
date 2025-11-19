<?php
// database/seeders/MemberUserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <-- Import
use Illuminate\Support\Facades\Hash; // <-- Import

class MemberUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat satu Member spesifik untuk testing
        // Email: member@artshowcase.com
        // Pass: password
        User::firstOrCreate(
            ['email' => 'member@artshowcase.com'],
            [
                'name' => 'Member Tes',
                'password' => Hash::make('password'),
                'role' => 'member',
                'status' => 'active',
                'bio' => 'Ini adalah akun Member untuk keperluan testing. Suka mengunggah karya seni digital.'
            ]
        );

        // 2. Buat 10 Member acak menggunakan Factory
        // Factory akan otomatis mengisi role='member' dan status='active'
        User::factory(10)->create();
    }
}