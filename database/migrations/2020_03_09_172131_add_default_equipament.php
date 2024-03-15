<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultEquipament extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('detector_de_gas')->default('NÃO POSSUI')->change();
            $table->string('manometro')->default('NÃO POSSUI')->change();

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
//            $table->dropUnique('users_detector_de_gas_unique');
//            $table->dropUnique('users_manometro_unique');
            $table->string('manometro')->default(null)->nullable()->change();
            $table->string('manometro')->default(null)->nullable()->change();
        });
    }
}
