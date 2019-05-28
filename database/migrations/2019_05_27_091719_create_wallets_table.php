<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWalletsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wallets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('user_id');
			$table->string('top_up_amount')->comment('Cannot be withdrawn but can be used to play');
			$table->string('pending_withdraw_amount')->comment('Amount that has been requested to withdrawn');
			$table->string('current_amount')->comment('Usable amount: excludes withdraw pending amount');
			$table->string('total_amount')->comment('current_amount + pending_withdraw_amount');
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
		Schema::drop('wallets');
	}

}
