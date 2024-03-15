<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoordToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("operator_start_lat")->nullable();
            $table->string("operator_start_lng")->nullable();
            $table->string("operator_arrival_lat")->nullable();
            $table->string("operator_arrival_lng")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(["operator_start_lat", "operator_start_lng", "operator_arrival_lat", "operator_arrival_lng"]);
        });
    }
}
