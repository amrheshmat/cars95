<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrganizationMembersTableAddTypeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('organization_members', 'type')){

            Schema::table('organization_members', function (Blueprint $table) {
                //we have 4 cases kyc-(super-visitor)-visitor 
                //  1 - visitor : login with mobile only
                //  2 - client  : login with mobiel and رقم العضويه 
                //  3 - verfied : login with mobiel and verification_code
                //  4 - kyc     : login with mobiel and verification_code
                $table->string('type')->default('visitor');
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
        Schema::table('organization_members', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
