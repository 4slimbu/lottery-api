<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLotterySlotsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lottery_slots', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('slot_ref')->unique();
            $table->timestamp('start_time')->nullable();
			$table->timestamp('end_time')->nullable();
			$table->boolean('has_winner')->default(0);
			$table->integer('total_participants')->unsigned()->default(0);
			$table->decimal('entry_fee', 13, 2);
			$table->decimal('total_amount', 13, 2)->default('0');
			$table->string('result')->nullable();
			$table->boolean('status')->default(0);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lottery_slots');
	}

}
