<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddZoneOccurrenceClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occurrence_clients', function (Blueprint $table) {
            $table->unsignedInteger('zone_id')->nullable();

            $table->index(["zone_id"]);
            $table->foreign('zone_id')
            ->references('id')->on('zones')
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
            $table->dropForeign(['zone_id']);
            $table->dropIndex(['zone_id']);
            $table->dropColumn(['zone_id']);
        });
    }
}
