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
                'meta_title' => 'LotteryCamp',
                'meta_description' => 'LotteryCamp is a lottery game hosting service',
                'og_title' => 'LotteryCamp',
                'og_description' => 'LotteryCamp is a lottery game hosting service',
                'og_image' => '//lotterycamp.com/images/screenshot.jpg',
                'twitter_title' => 'LotteryCamp',
                'twitter_description' => 'LotteryCamp is a lottery game hosting service',
                'twitter_image' => '//lotterycamp.com/images/screenshot.jpg',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
