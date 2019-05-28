<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWalletTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wallet_transactions', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('transaction_id')->unique();
			$table->integer('user_id')->unsigned()->index('user_id');
			$table->enum('type', ['top-up', 'order', 'win', 'refer', 'withdraw']);
			$table->string('amount');
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
		Schema::drop('wallet_transactions');
	}

}
