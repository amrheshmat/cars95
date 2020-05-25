<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMedicalRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('medical_requests')){

			Schema::create('medical_requests', function(Blueprint $table)
			{
				$table->integer('request_id', true);
				$table->string('name', 180)->nullable();
				$table->string('email', 190)->nullable();
				$table->string('phone', 45)->nullable();
				$table->integer('profession_id')->nullable();
				$table->integer('degree_id')->nullable();
				$table->integer('status')->nullable()->default(0);
				$table->string('approval_number', 45)->nullable();
				$table->text('approval_image', 65535)->nullable();
				$table->text('comment', 65535)->nullable();
				$table->timestamps();
				$table->dateTime('last_view')->nullable();
				$table->integer('view_by')->default(0);
				$table->integer('main_syndicate_id')->unsigned()->index('medical_requests_main_syndicate_id_foreign');
				$table->integer('syndicate_user_number')->unsigned();
				$table->integer('area_id')->unsigned();
				$table->boolean('mobile_view')->default(0);
				$table->string('provider_type_id')->nullable();
                $table->string('username')->nullable();
				$table->integer('provider_id')->unsigned()->index('medical_requests_provider_id_foreign');
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
		Schema::drop('medical_requests');
	}

}
