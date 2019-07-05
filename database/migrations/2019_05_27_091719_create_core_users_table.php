<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoreUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('core_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->string('email', 191)->unique('UNQ_core_users_email');
			$table->string('username', 64)->nullable()->unique('UNQ_core_users_username');
			$table->enum('gender', array('male','female'))->nullable();
			$table->string('contact_number')->nullable();
			$table->string('password', 128)->default('');
			$table->boolean('verified')->default(0);
			$table->string('email_token', 64)->nullable();
			$table->string('remember_token', 100)->nullable();
            $table->string('profile_pic')->nullable();
            $table->bigInteger('fb_id')->nullable();
            $table->string('device_id')->nullable();
            $table->integer('referral_id')->unsigned()->nullable();
            $table->integer('referred_by_id')->unsigned()->nullable();
            $table->dateTime('last_login_date')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_bot')->default(0);
            $table->integer('free_games')->default(0);
            $table->softDeletes();
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
		Schema::drop('core_users');
	}

}
