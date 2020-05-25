<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMedicalProvidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('medical_providers')){
			Schema::create('medical_providers', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 190);
				$table->string('address', 190)->nullable();
				$table->string('emails', 190)->nullable();
				$table->string('phones', 190)->nullable();
				$table->integer('profession_id')->nullable()->index('medical_providers_profession_id_foreign');
				$table->integer('degree_id')->nullable()->index('medical_providers_degree_id_foreign');
				$table->integer('area_id')->index('medical_providers_area_id_foreign');
				$table->integer('governorate_id')->index('medical_providers_governorate_id_foreign');
				$table->integer('provider_type_id')->index('medical_providers_provider_type_id_foreign');
				$table->integer('provider_id')->nullable()->unique();
				$table->integer('syndicate_id')->index('medical_providers_syndicate_id_foreign');
				$table->timestamps();
				$table->integer('education_level_id')->nullable();
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
		Schema::drop('medical_providers');
	}

}
