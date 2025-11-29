<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArtworksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('artworks')->delete();
        
        \DB::table('artworks')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Mobile Legend',
                'description' => 'game hama',
                'user_id' => 2,
                'category_id' => 3,
                'image' => 'artworks/jLhUbb98qAdcQ2cn49G5cAxOILSAFUPIBV8XZga8.jpg',
                'tags' => '["ml"," game"," hama"]',
                'created_at' => '2025-11-28 15:40:25',
                'updated_at' => '2025-11-28 15:40:25',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Genshin impact',
                'description' => 'genshin impek',
                'user_id' => 2,
                'category_id' => 1,
                'image' => 'artworks/cgpoAXj4D8ck4Ld6Iy5gX4ObEgQysQ8CHDj0iEvs.jpg',
                'tags' => '["gen"," sin"," game"]',
                'created_at' => '2025-11-28 15:41:11',
                'updated_at' => '2025-11-28 15:41:11',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Honir Of Kings',
                'description' => 'game cuma laku di cina',
                'user_id' => 3,
                'category_id' => 6,
                'image' => 'artworks/2P6hK72D4qqEgzoipL6hc6OazwLwgrzwhHnaW02Q.jpg',
                'tags' => '["game"," hok"," cina"]',
                'created_at' => '2025-11-28 15:43:41',
                'updated_at' => '2025-11-28 15:43:41',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Roblox',
                'description' => 'rooobbbloooookkkk jangan engkau pergi',
                'user_id' => 4,
                'category_id' => 2,
                'image' => 'artworks/mUuV0VTgeK2KPPUgRXavk5OAenr3kgaTOUw93tFc.jpg',
                'tags' => '["roblox"," game"]',
                'created_at' => '2025-11-28 15:44:29',
                'updated_at' => '2025-11-28 15:44:29',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}