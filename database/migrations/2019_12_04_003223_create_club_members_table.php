<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClubMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('club_members')){

			Schema::create('club_members', function(Blueprint $table)
			{
				$table->increments('club_user_id');
				$table->string('club_user_fname', 190)->nullable();
				$table->string('club_user_lname', 190)->nullable();
				$table->string('clubuser_email', 190)->nullable();
				$table->string('club_user_password', 500)->nullable();
				$table->string('club_user_number', 190)->nullable();
				$table->integer('main_club_id')->nullable();
				$table->integer('sub_club_id')->nullable();
				$table->text('club_user_eduQualification')->nullable();
				$table->text('club_user_nationalID')->nullable();
				$table->dateTime('club_user_idPublishDate')->nullable();
				$table->integer('religion_id')->nullable()->index('club_members_religion_id_foreign');
				$table->dateTime('club_user_birthDate')->nullable();
				$table->integer('governorate_id')->nullable()->index('club_members_governorate_id_foreign');
				$table->integer('club_user_nationalityID')->nullable();
				$table->string('club_user_jobTitle', 190)->nullable();
				$table->string('club_user_mobile', 190);
				$table->integer('gender_id')->nullable()->index('club_members_gender_id_foreign');
				$table->string('clubUser_address', 190)->nullable();
				$table->integer('user_status_id')->nullable()->index('club_members_user_status_id_foreign');
				$table->text('user_token', 65535);
				$table->text('verification_code', 65535)->nullable();
				$table->text('mobile_token', 65535)->nullable();
				$table->integer('created_by')->nullable();
				$table->integer('updated_by')->nullable();
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
		Schema::drop('club_members');
	}

}
