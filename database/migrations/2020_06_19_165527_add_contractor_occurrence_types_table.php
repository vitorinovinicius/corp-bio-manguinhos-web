<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContractorOccurrenceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occurrence_types', function (Blueprint $table) {
            $table->unsignedInteger('contractor_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('occurrence_types', function (Blueprint $table) {
            $table->dropColumn('contractor_id');
        });
    }
}
