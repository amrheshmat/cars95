<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGovernoratesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('governorates')){
			Schema::create('governorates', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('country_id')->index('governorates_country_id_foreign');
				$table->string('governorate_desc_ar', 190);
				$table->string('governorate_desc_en', 190);
				$table->text('governorate_logo');
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
		Schema::drop('governorates');
	}

}
