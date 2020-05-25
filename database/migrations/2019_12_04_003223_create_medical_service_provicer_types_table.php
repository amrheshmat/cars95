<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMedicalServiceProvicerTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('medical_service_provicer_types')){
			Schema::create('medical_service_provicer_types', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('provider_type_en', 190);
				$table->string('provider_type_ar', 190);
				$table->timestamps();
				$table->integer('service_type');
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
		Schema::drop('medical_service_provicer_types');
	}

}
