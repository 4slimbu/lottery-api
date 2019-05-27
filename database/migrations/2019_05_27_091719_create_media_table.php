<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('is_primary')->nullable()->default(0)->comment('Set to true to set asset to be the primary/default asset i.e default posert logo would be 1 here');
			$table->integer('post_id')->unsigned()->nullable()->index('brand_id');
			$table->integer('user_id')->unsigned()->nullable()->index('user_id');
			$table->string('url')->default('')->comment('URL or URL key of asset');
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
		Schema::drop('media');
	}

}
