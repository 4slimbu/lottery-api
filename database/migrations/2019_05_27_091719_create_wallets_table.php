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
            $table->integer('user_id')->unsigned();
            $table->decimal('won', 13, 2)->comment('Can be withdrawn (BTC)');
			$table->decimal('pending_withdraw', 13, 2)->comment('Amount that has been requested to withdrawn');
            $table->decimal('deposit', 13, 2)->comment('Deposit amount (App Coin)');
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
