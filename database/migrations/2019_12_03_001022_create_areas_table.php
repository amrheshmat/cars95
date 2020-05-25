<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAreasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('areas')){
			Schema::create('areas', function(Blueprint $table)
			{
				$table->integer('area_id')->nullable();
				$table->integer('area_code')->nullable();
				$table->text('area_name', 65535)->nullable();
				$table->integer('country_id');
				$table->integer('gov_id');
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
		Schema::drop('areas');
	}

}
