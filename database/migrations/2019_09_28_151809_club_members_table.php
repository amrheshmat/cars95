<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClubMembersTable extends Migration
{
    
    public function up()
    {
		if(!Schema::hasTable('organization_members')){
            Schema::create('organization_members', function (Blueprint $table) {
                $table->increments('id');
                $table->string('fname')->nullable();
                $table->string('lname')->nullable();
                $table->string('email')->nullable();
                $table->string('password');
                $table->string('user_number')->nullable();
                $table->text('eduQualification')->nullable();
                $table->string('nationalID')->nullable();
                $table->string('idPublishDate')->nullable();
                $table->string('birthDate')->nullable();
                $table->string('jobTitle')->nullable();
                $table->string('mobile')->nullable();
                $table->text('address')->nullable();
                $table->text('user_token');
                $table->text('verification_code')->nullable();
                $table->text('mobile_token')->nullable();

                $table->integer('gender_id')->nullable()->unsigned()->index();
                $table->integer('governorate_id')->nullable()->unsigned()->index();
                $table->integer('religion_id')->nullable()->unsigned()->index();
                $table->integer('main_club_id')->nullable()->unsigned()->index();
                $table->integer('sub_club_id')->nullable()->unsigned()->index();

                $table->timestamps();

                //$table->foreign('gender_id')->references('gender_id')->on('genders');
                //$table->foreign('governorate_id')->references('governorate_id')->on('governorates');
                //$table->foreign('religion_id')->references('religion_id')->on('religions');
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
        Schema::dropIfExists('organization_members');
    }
}
