<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIprelationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('iprelations')){
			Schema::create('iprelations', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('ip_id')->unsigned()->index();
				$table->integer('iprelation_id')->unsigned()->index();
				$table->string('iprelation_type');
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
		Schema::drop('iprelations');
	}

}
