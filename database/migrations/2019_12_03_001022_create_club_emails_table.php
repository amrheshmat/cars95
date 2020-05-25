<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClubEmailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('club_emails')){
			Schema::create('club_emails', function(Blueprint $table)
			{
				$table->increments('id')->comment('disable');
				$table->integer('club_id')->unsigned()->index('phones_contact_id_index');
				$table->string('email', 50)->unique('phones_phone_unique');
				$table->string('club_type', 50);
				$table->integer('created_by')->comment('disable');
				$table->integer('updated_by')->comment('disable');
				$table->integer('deleted_by')->comment('disable');
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
		Schema::drop('club_emails');
	}

}
