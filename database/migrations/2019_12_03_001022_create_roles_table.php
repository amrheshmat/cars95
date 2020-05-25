<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('roles')){
			Schema::create('roles', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name');
				$table->string('slug')->unique();
				$table->string('description')->nullable();
				$table->integer('level')->default(1);
				$table->timestamps();
				$table->softDeletes();
			});
		}
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roles');
	}

}
