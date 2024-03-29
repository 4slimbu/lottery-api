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
            $table->string('transaction_code')->unique();
			$table->integer('wallet_id')->unsigned()->index('wallet_id');
			$table->enum('type', ['top-up', 'order', 'win', 'refer', 'withdraw', 'refund', 'failed'])->comment('top-up, order, win, refer, withdraw', 'refund');
			$table->decimal('amount', 13, 2);
			$table->decimal('service_charge', 13, 2)->default(0);
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
