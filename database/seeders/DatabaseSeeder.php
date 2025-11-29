<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder admin kita di sini
        $this->call([
            AdminUserSeeder::class,
            CategorySeeder::class,   
            MemberUserSeeder::class,
            ArtworksTableSeeder::class,
            // CuratorProfilesTableSeeder::class,
        ]);
    }
}
