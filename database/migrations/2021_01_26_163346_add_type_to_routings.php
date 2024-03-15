<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToRoutings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routings', function (Blueprint $table) {
            $table->unsignedInteger("operator_id")->nullable()->change();
            $table->integer("type")->default(1)->comment("1-TOMTOM, 2-GOOGLE");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routings', function (Blueprint $table) {
            $table->unsignedInteger("operator_id")->change();
            $table->dropColumn("type");
        });
    }
}
