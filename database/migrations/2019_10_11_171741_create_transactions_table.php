<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('transactions')){
            Schema::create('transactions', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id');
                $table->enum('status',['pending','paid','rejected'])->default('pending');
                $table->double('amount', 8, 2);
                $table->uuid('ref_number')->unique();
                $table->string('organization_member_id')->nullable();
                $table->string('membership_id')->nullable();
                $table->string('club_id')->nullable();
                $table->string('sub_club_id')->nullable();
                $table->string('service_id')->nullable();
                $table->timestamps();
            
                //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('transactions');
    }
}
