<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCorePermissionRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('core_permission_role', function(Blueprint $table)
		{
			$table->integer('permission_id')->unsigned();
			$table->integer('role_id')->unsigned()->index('core_permission_role_role_id_foreign');
			$table->primary(['permission_id','role_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('core_permission_role');
	}

}
