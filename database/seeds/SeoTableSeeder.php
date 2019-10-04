<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeoTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seo')->truncate();

        DB::table('seo')->insert([
            [
                'page_id' => 1,
                'meta_title' => 'Krypto',
                'meta_description' => 'Krypto is a lottery game hosting service',
                'og_title' => 'Krypto',
                'og_description' => 'Krypto is a lottery game hosting service',
                'og_image' => '//kryptto.io/images/screenshot.jpg',
                'twitter_title' => 'Krypto',
                'twitter_description' => 'Krypto is a lottery game hosting service',
                'twitter_image' => '//kryptto.io/images/screenshot.jpg',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}