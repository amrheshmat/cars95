<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewsTable extends Migration
{
    public function up()
    {
		if(!Schema::hasTable('news')){
            Schema::create('news', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->text('img');
                $table->text('desc');
                $table->string('source')->nullable();

                $table->integer('news_type_id')->nullable()->unsigned()->index();
                $table->integer('main_club_id')->nullable()->unsigned()->index();
                $table->integer('sub_club_id')->nullable()->unsigned()->index();

                $table->timestamps();
                $table->foreign('news_type_id')->references('id')->on('news_types');
                //$table->foreign('main_syndicate_id')->references('syndicate_id')->on('syndicates');
                //$table->foreign('sub_syndicate_id')->references('sub_syndicate_id')->on('sub_syndicates');
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
        Schema::dropIfExists('news');
    }
}
