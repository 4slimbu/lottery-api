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
            // topup amount cannot be withdrawn
            // pending withdraw amount cannot be used





			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('user_id');
			$table->string('withdrawable_amount')->comment('Can be withdrawn');
			$table->string('pending_withdraw_amount')->comment('Amount that has been requested to withdrawn');
            $table->string('usable_amount')->comment('Usable amount: excludes withdraw pending amount');
            $table->string('total_amount')->comment('Usable + Pending Withdraw');
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
