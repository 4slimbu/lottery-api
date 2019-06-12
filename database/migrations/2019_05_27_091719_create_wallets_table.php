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
            $table->integer('user_id')->unsigned();
            $table->decimal('withdrawable_amount', 13, 2)->comment('Can be withdrawn');
			$table->decimal('pending_withdraw_amount', 13, 2)->comment('Amount that has been requested to withdrawn');
            $table->decimal('usable_amount', 13, 2)->comment('Usable amount: excludes withdraw pending amount');
            $table->decimal('total_amount', 13, 2)->comment('Usable + Pending Withdraw');
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
