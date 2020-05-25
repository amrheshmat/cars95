<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMerchantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('merchants')){
			Schema::create('merchants', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('username');
                $table->string('email');
                $table->string('password');
                $table->integer('parent_id');
				$table->integer('provider_id');
				$table->string('remember_token', 100)->nullable();
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
		Schema::drop('merchants');
	}

}
