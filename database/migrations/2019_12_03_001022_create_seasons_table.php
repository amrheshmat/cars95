<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSeasonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('seasons')){
			Schema::create('seasons', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('session_desc_ar', 190);
				$table->string('session_desc_en', 190);
				$table->timestamp('season_startDate')->default(DB::raw('CURRENT_TIMESTAMP'));
				$table->dateTime('season_endDate')->default('0000-00-00 00:00:00');
				$table->integer('created_by');
				$table->integer('updated_by');
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
		Schema::drop('seasons');
	}

}
