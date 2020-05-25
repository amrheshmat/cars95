<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTransactionsTableAddColumnsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('transactions', 'organization_member_id')){
            Schema::table('transactions', function (Blueprint $table) {
                $table->string('organization_member_id')->nullable();
                $table->string('membership_id')->nullable();
                $table->string('club_id')->nullable();
                $table->string('sub_club_id')->nullable();
                $table->string('service_id')->nullable();
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
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('organization_member_id');
            $table->dropColumn('membership_id');
            $table->dropColumn('club_id');
            $table->dropColumn('sub_club_id');
            $table->dropColumn('service_id');
        });
    }
}
