<?php
// database/seeders/ArtworkSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Artwork; // <-- Import

class ArtworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan kita punya User dan Kategori dulu
        if (\App\Models\User::where('role', 'member')->count() == 0 || \App\Models\Category::count() == 0) {
            $this->command->warn('Harap jalankan CategorySeeder dan MemberUserSeeder terlebih dahulu. Melewatkan ArtworkSeeder.');
            return;
        }

        // Buat 40 karya seni acak
        $this->command->info('Membuat 40 artwork palsu (ini mungkin perlu waktu untuk mengunduh gambar)...');
        Artwork::factory(40)->create();
    }
}