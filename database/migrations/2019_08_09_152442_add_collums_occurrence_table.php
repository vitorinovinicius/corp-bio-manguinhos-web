<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollumsOccurrenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occurrences', function (Blueprint $table) {
            $table->unsignedInteger('log_import_id')->nullable();
            $table->integer('code_verification')->nullable();
            $table->date('schedules_original')->nullable();

            $table->index(["log_import_id"], 'fk_occurrences_log_imports1_idx');

            $table->foreign('log_import_id', 'fk_occurrences_log_imports1_idx')
                ->references('id')->on('log_imports')
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
            $table->dropColumn('log_import_id');
            $table->dropColumn('schedules_original');
            $table->dropColumn('code_verification');
        });
    }
}
