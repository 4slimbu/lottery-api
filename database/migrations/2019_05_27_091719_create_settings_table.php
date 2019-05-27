<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->enum('scope', ['everywhere', 'frontend', 'backend', 'user', 'wallet', 'lottery', 'page'])->index();
			$table->string('key')->index();
			$table->string('value');
			$table->enum('field', ['text', 'textarea', 'select', 'radio']);
			$table->string('field_value', 191)->default('')->comment('for select, radio');
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
		Schema::drop('settings');
	}

}
