<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClubPhonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('club_phones')){
			Schema::create('club_phones', function(Blueprint $table)
			{
				$table->increments('id')->comment('disable');
				$table->integer('club_id')->unsigned()->index('phones_contact_id_index');
				$table->bigInteger('phone')->unique('phones_phone_unique');
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
		Schema::drop('club_phones');
	}

}
