<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('users')){
			Schema::create('users', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('first_name');
				$table->string('last_name')->nullable();
				$table->string('name');
				$table->string('email')->nullable()->unique();
				$table->string('username')->unique();
				$table->string('password');
				$table->integer('extension')->nullable();
                $table->string('provider_type_id')->nullable();
                $table->integer('parent_id')->default(0);
                $table->enum('usertype', array('superadmin','user','callcenter','axa','supercallcenter','neqabty'))->default('neqabty');
				$table->enum('activated', array('1','0'))->default('1');
				$table->string('picture')->default('/upload/User/profile.jpg');
				$table->integer('lock')->nullable();
				$table->string('remember_token', 100)->nullable();
				$table->timestamps();
				$table->softDeletes();
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
		Schema::drop('users');
	}

}
