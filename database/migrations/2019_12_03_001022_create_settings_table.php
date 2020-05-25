<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('settings')){
			Schema::create('settings', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('key', 190);
				$table->string('display_name', 190);
				$table->text('value', 65535)->nullable();
				$table->text('details', 65535)->nullable();
				$table->string('type', 190);
				$table->integer('order')->default(1);
				$table->integer('min_supported_version')->default(1);
				$table->integer('created_by')->default(1);
				$table->integer('updated_by')->default(1);
				$table->string('group', 190);
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
		Schema::drop('settings');
	}

}
