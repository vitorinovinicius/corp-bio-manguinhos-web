<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlanToOccurrences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occurrences', function (Blueprint $table) {
            $table->unsignedInteger('plan_occurrence_id')->nullable();

            $table->index(["plan_occurrence_id"], 'fk_occurrences_plan_occurrences1_idx');
            $table->foreign('plan_occurrence_id','fk_occurrences_plan_occurrences1_idx')
                ->references('id')->on('plan_occurrences')
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
        Schema::table('occurrences', function (Blueprint $table) {
            $table->dropForeign('fk_occurrences_plan_occurrences1_idx');
            $table->dropIndex('fk_occurrences_plan_occurrences1_idx');
            $table->dropColumn('plan_occurrence_id');
        });
    }
}
