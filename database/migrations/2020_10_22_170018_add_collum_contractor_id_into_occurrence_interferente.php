<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollumContractorIdIntoOccurrenceInterferente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occurrence_interference', function (Blueprint $table) {
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
        Schema::table('occurrence_interference', function (Blueprint $table) {
            $table->dropForeign('occurrence_interference_contractor_id_foreign');
            $table->dropColumn('contractor_id');
        });
    }
}
