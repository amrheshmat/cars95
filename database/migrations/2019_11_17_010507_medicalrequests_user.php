<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MedicalrequestsUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('medical_requests', 'updated_by')){
            Schema::table('medical_requests', function (Blueprint $table) {
                $table->integer('updated_by')->unsigned()->default(1);            
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
        Schema::table('medical_requests', function (Blueprint $table) {
            //
        });
    }
}
