<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubClubsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('sub_clubs')){

			Schema::create('sub_clubs', function(Blueprint $table)
			{
				$table->increments('id');
				$table->text('sub_club_name_ar')->nullable();
				$table->text('sub_club_name_en');
				$table->integer('sub_governorate_id')->index('club_governorate_id_foreign');
				$table->integer('club_id')->index('club_id');
				$table->integer('sub_clubparent_id');
				$table->integer('sub_club_level');
				$table->text('sub_club_address');
				$table->text('sub_club_logo');
				$table->integer('created_by')->nullable();
				$table->integer('updated_by')->nullable();
				$table->timestamps();
				$table->text('sub_club_fax', 65535)->nullable();
				$table->text('sub_captain', 65535)->nullable();
				$table->text('sub_cashier', 65535)->nullable();
				$table->text('sub_assistant_secretary_general', 65535)->nullable();
				$table->text('sub_assistant_cashier', 65535)->nullable();
				$table->text('sub_members', 65535)->nullable();
				$table->text('sub_club_agent', 65535)->nullable();
				$table->text('sub_secretary_general', 65535)->nullable();
				$table->text('sub_bio')->nullable();
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
		Schema::drop('sub_clubs');
	}

}
