<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClubsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('clubs')){
			Schema::create('clubs', function(Blueprint $table)
			{
				$table->increments('id');
				$table->text('club_desc_ar')->nullable();
				$table->text('club_desc_en');
				$table->integer('governorate_id')->index('club_governorate_id_foreign');
				$table->integer('club_parent_id');
				$table->integer('club_level');
				$table->text('club_address');
				$table->text('club_phoneNumber');
				$table->text('club_email');
				$table->text('club_logo');
				$table->integer('created_by')->nullable();
				$table->integer('updated_by')->nullable();
				$table->timestamps();
				$table->text('club_fax', 65535)->nullable();
				$table->text('club_mobile', 65535)->nullable();
				$table->text('captain', 65535)->nullable();
				$table->text('cashier', 65535)->nullable();
				$table->text('assistant_secretary_general', 65535)->nullable();
				$table->text('assistant_cashier', 65535)->nullable();
				$table->text('members', 65535)->nullable();
				$table->text('club_agent', 65535)->nullable();
				$table->text('secretary_general', 65535)->nullable();
				$table->text('bio')->nullable();
				$table->integer('club_id')->unsigned();
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
		Schema::drop('clubs');
	}

}
