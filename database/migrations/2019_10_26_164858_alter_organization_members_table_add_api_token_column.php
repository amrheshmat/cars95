<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrganizationMembersTableAddApiTokenColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('organization_members', 'api_token')){
            Schema::table('organization_members', function (Blueprint $table) {
                $table->text('api_token')->nullable();
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
            $table->dropColumn('api_token');
        });
    }
}
