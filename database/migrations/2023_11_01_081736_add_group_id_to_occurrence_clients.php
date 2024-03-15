<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupIdToOccurrenceClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occurrence_clients', function (Blueprint $table) {
            $table->unsignedInteger('group_id');
            $table->index('group_id');
            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('occurrence_clients', function (Blueprint $table) {
            $table->dropColumn('group_id');
        });
    }
}
