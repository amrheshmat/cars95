<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfessionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('professions')){
			Schema::create('professions', function(Blueprint $table)
			{
				$table->integer('profession_id')->nullable();
				$table->integer('code')->nullable();
				$table->text('profession', 65535)->nullable();
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
		Schema::drop('professions');
	}

}
