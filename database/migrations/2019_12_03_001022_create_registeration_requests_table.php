<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRegisterationRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('registeration_requests')){
			Schema::create('registeration_requests', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('member_id')->unsigned()->nullable()->index();
				$table->string('mobile_number');
				$table->string('identifier_id');
				$table->string('user_number');
				$table->string('identifier_front_image')->nullable();
				$table->string('identifier_back_image')->nullable();
				$table->string('verification_image');
				$table->enum('type', array('upgrade','register'));
				$table->enum('status', array('pending','accepted','rejected'))->default('pending');
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
		Schema::drop('registeration_requests');
	}

}
