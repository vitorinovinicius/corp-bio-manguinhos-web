<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldManualExecutionToAccurrences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occurrences', function (Blueprint $table) {
            $table->boolean('manual_execution')->default(0)->comment("1 - Executado manualmente");
            $table->unsignedInteger('execute_by')->nullable();

            $table->foreign('execute_by')
                ->references('id')->on('users')
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
            $table->dropForeign('occurrence_execute_by_foreign');
            $table->dropColumn(['manual_execution','execute_by']);
        });
    }
}
