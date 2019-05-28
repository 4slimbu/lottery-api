<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLotterySlotUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lottery_slot_user', function(Blueprint $table)
		{
            $table->integer('lottery_slot_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('lottery_number');
            $table->integer('lottery_winner_type_id')->unsigned()->nullable();
            $table->string('won_amount');
            $table->string('service_charge');
            $table->primary(['lottery_slot_id','user_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lottery_slot_user');
	}

}
