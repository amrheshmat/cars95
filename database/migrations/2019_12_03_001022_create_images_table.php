<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('images')){
			Schema::create('images', function(Blueprint $table)
			{
				$table->increments('id');
				$table->text('image', 65535);
				$table->integer('model_id');
				$table->string('model_type', 50);
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
		Schema::drop('images');
	}

}
