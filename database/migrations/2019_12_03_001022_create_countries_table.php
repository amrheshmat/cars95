<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('countries')){
			Schema::create('countries', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('country_desc_ar', 190);
				$table->string('country_desc_en', 190);
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
		Schema::drop('countries');
	}

}
