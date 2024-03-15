<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOccurrenceIdToArchives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('archives', function (Blueprint $table) {
            $table->unsignedInteger('contractor_id')->nullable();

            $table->foreign('contractor_id')
			->references('id')->on('contractors')
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
        Schema::table('archives', function (Blueprint $table) {
            $table->dropForeign(['contractor_id']);
            $table->dropColumn(['contractor_id']);
        });
    }
}
