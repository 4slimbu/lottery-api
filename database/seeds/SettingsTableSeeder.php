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
                'value' => 'Lottery',
                'field' => 'text',
                'field_value' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'app_pagination',
                'label' => 'Pagination Limit',
                'value' => 15,
                'field' => 'text',
                'field_value' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'app_currency',
                'label' => 'Currency',
                'value' => 'USD',
                'field' => 'text',
                'field_value' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'app_timezone',
                'label' => 'Timezone',
                'value' => 'UTC',
                'field' => 'text',
                'field_value' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'lottery_slot_entry_fee',
                'label' => 'Slot Entry Fee',
                'value' => 10,
                'field' => 'text',
                'field_value' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'lottery_slot_run_duration',
                'label' => 'Slot Run Duration (in mins)',
                'value' => 5,
                'field' => 'text',
                'field_value' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'lottery_slot_service_charge',
                'label' => 'Service Charge Per Slot (in %)',
                'value' => '10',
                'field' => 'text',
                'field_value' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'lottery_slot_auto_generate',
                'label' => 'Auto Generate Lottery Slot',
                'value' => '1',
                'field' => 'radio',
                'field_value' => '0,1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'wallet_withdraw_limit',
                'label' => 'Withdraw Limit',
                'value' => '100',
                'field' => 'text',
                'field_value' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'key' => 'wallet_is_topup_withdrawable',
                'label' => 'Service Charge Per Slot (in %)',
                'value' => '0',
                'field' => 'radio',
                'field_value' => '0,1',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}