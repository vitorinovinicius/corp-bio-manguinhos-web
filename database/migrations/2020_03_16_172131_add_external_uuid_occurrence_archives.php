<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExternalUuidOccurrenceArchives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occurrence_archives', function (Blueprint $table) {
            $table->string('external_uuid')->nullable();
            $table->string('type_file')->nullable();
            $table->index(['external_uuid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('occurrence_archives', function (Blueprint $table) {
            $table->dropColumn('external_uuid');
            $table->dropColumn('type_file');
        });
    }
}
