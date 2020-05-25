<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('permissions')){
			Schema::create('permissions', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name');
				$table->string('slug')->unique();
				$table->string('description')->nullable();
				$table->string('model')->nullable();
				$table->timestamps();
				$table->enum('sidebar', array('Y','N'))->default('N');
				$table->string('icon', 50)->nullable();
				$table->string('title', 50)->nullable();
				$table->integer('group_id')->nullable();
				$table->string('group_name', 50)->nullable();
				$table->string('group_icon', 50)->nullable();
				$table->integer('order_items')->nullable();
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
		Schema::drop('permissions');
	}

}
