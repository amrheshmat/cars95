<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMobileUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('mobile_users')){
			Schema::create('mobile_users', function(Blueprint $table)
			{
				$table->increments('id');
				$table->text('token', 65535);
				$table->string('mobile_id', 190);
				$table->integer('club_id');
				$table->string('club_user_number', 190);
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
		Schema::drop('mobile_users');
	}

}
