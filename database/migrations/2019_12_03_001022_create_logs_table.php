<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('logs')){
			Schema::create('logs', function(Blueprint $table)
			{
				$table->increments('id');
				$table->text('user_id', 65535)->nullable();
				$table->text('route', 65535)->nullable();
				$table->text('model', 65535)->nullable();
				$table->text('methods', 65535)->nullable();
				$table->timestamps();
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
		Schema::drop('logs');
	}

}
