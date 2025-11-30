<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category; // <-- Import
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Fotografi',
            'UI/UX Design',
            '3D Art',
            'Ilustrasi Digital',
            'Desain Grafis',
            'Motion Graphics',
            'Seni Lukis',
            'Puisi',
        ];

        foreach ($categories as $categoryName) {
            // firstOrCreate() untuk menghindari duplikat jika seeder dijalankan lagi
            Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)], // Cek berdasarkan slug
                ['name' => $categoryName] // Data untuk dibuat
            );
        }
    }
}
