<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMedicalRequestDocsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('medical_request_docs')){
			Schema::create('medical_request_docs', function(Blueprint $table)
			{
				$table->integer('doc_id', true);
				$table->string('medical_request_id', 45)->nullable();
				$table->text('doc', 65535)->nullable();
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
		Schema::drop('medical_request_docs');
	}

}
