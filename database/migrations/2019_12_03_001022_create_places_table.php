<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlacesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('places')){
			Schema::create('places', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 190);
				$table->integer('governorate_id');
				$table->integer('trip_place_type_id');
				$table->text('details', 65535);
				$table->text('rules', 65535);
				$table->text('map', 65535);
				$table->integer('max_persons')->nullable();
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
		Schema::drop('places');
	}

}
