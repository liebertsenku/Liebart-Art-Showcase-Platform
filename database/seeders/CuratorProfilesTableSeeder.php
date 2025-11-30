<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CuratorProfilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('curator_profiles')->delete();
        
        \DB::table('curator_profiles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 13,
                'organization_name' => 'shoope',
                'organization_website' => NULL,
                'portfolio_link' => 'http://liebertsenku.github.io',
                'reason_for_applying' => 'karena mau banget',
                'status' => 'approved',
                'created_at' => '2025-11-29 02:56:34',
                'updated_at' => '2025-11-29 02:56:34',
            ),
        ));
        
        
    }
}