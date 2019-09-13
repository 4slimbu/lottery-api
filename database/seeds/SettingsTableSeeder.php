<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->truncate();

        DB::table('settings')->insert([
            [
                'key' => 'app_name',
                'label' => 'App Name',
                'value' => 'Kryptto.io',
                'comment' => 'Text',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'app_pagination',
                'label' => 'Pagination Limit',
                'value' => 15,
                'comment' => 'Number e.g: 15',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'app_currency',
                'label' => 'Currency',
                'value' => 'BTC',
                'comment' => 'Currency code e.g: USD, BTC',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'app_timezone',
                'label' => 'Timezone',
                'value' => 'UTC',
                'comment' => 'Timezone e.g: UTC, Asia/Kathmandu',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'app_facebook_url',
                'label' => 'Facebook Url',
                'value' => 'https://facebook/bitlot',
                'comment' => 'Url e.g: https://example.com',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'app_twitter_url',
                'label' => 'Twitter Url',
                'value' => 'https://twitter/bitlot',
                'comment' => 'Url e.g: https://example.com',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'app_email',
                'label' => 'App Main Email',
                'value' => 'sudip@gmail.com',
                'comment' => 'Email',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'lottery_slot_entry_fee',
                'label' => 'Slot Entry Fee',
                'value' => 100,
                'comment' => 'Number e.g: 100',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'lottery_slot_run_duration',
                'label' => 'Slot Run Duration (in mins)',
                'value' => 1,
                'comment' => 'Number e.g: 1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'lottery_slot_service_charge',
                'label' => 'Service Charge Per Slot (in %)',
                'value' => '10',
                'comment' => 'Number e.g: 10',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'lottery_slot_auto_generate',
                'label' => 'Auto Generate Lottery Slot',
                'value' => '1',
                'comment' => 'Boolean e.g: 1, 0',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'lottery_slot_auto_generate_fake_users',
                'label' => 'Auto Generate Fake Users for Lottery Slot',
                'value' => '1',
                'comment' => 'Boolean e.g: 1, 0',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'lottery_slot_max_fake_users',
                'label' => 'Max Fake Users Per Lottery Slot',
                'value' => '250',
                'comment' => 'Number e.g: 200',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'wallet_withdraw_limit',
                'label' => 'Withdraw Limit',
                'value' => '100',
                'comment' => 'Number e.g: 100',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'wallet_is_topup_withdrawable',
                'label' => 'Service Charge Per Slot (in %)',
                'value' => '0',
                'comment' => 'Boolean e.g: 1, 0',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}