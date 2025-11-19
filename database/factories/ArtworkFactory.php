<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User; // <-- Import
use App\Models\Category; // <-- Import
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artwork>
 */
class ArtworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil User acak yang rolenya 'member'
        $member = User::where('role', 'member')->inRandomOrder()->first();
        
        // Ambil Kategori acak
        $category = Category::inRandomOrder()->first();

        // --- Logika Pembuatan Gambar ---
        // Pastikan folder 'artworks' ada
        if (!Storage::exists('public/artworks')) {
            Storage::makeDirectory('public/artworks');
        }

        // Buat gambar palsu dan simpan ke storage, lalu dapatkan nama filenya
        // Faker akan mengunduh gambar acak ke folder storage Anda
        $imageName = $this->faker->image(
            storage_path('app/public/artworks'),
            800, // lebar
            600, // tinggi
            null, // kategori gambar
            false // HANYA kembalikan nama file (e.g., 'abc123.jpg')
        );
        // ------------------------------

        return [
            'title' => fake()->sentence(mt_rand(3, 6)),
            'description' => fake()->paragraphs(mt_rand(2, 4), true), // true = return as string
            'user_id' => $member->id, // Tautkan ke Member acak
            'category_id' => $category->id, // Tautkan ke Kategori acak
            'image' => 'artworks/' . $imageName, // Simpan path relatif
            'tags' => fake()->words(mt_rand(3, 7)), // Factory otomatis cast ke JSON
        ];
    }
}