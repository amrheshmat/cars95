<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWalletsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('wallets')){

			Schema::create('wallets', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('user_id')->unsigned();
				$table->string('user_type');
				$table->integer('points')->default(0);
				$table->timestamps();
				$table->unique(['user_id','user_type']);
				$table->index(['user_id','user_type']);
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
		Schema::drop('wallets');
	}

}
