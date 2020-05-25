<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('car_name');
            $table->integer('car_price');
            $table->integer('car_model');
            $table->string('car_desc');
            $table->string('car_img');
            $table->string('car_type');
            $table->integer('status_id')->nullable()->unsigned()->index();

                $table->timestamps();
                $table->foreign('status_id')->references('id')->on('car_statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_informations');
    }
}
