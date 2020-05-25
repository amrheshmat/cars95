<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystemPagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('system_pages')){
			Schema::create('system_pages', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('systemPage_pageDescriptionAR', 190);
				$table->string('systemPage_pageDescriptionEN', 190);
				$table->string('systemPage_pageURL', 190);
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
		Schema::drop('system_pages');
	}

}
