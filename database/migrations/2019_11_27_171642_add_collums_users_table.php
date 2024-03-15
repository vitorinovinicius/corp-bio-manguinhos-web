<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollumsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('manometro_certificado')->nullable();
            $table->date('manometro_validade')->nullable();
            $table->string('analisador_certificado')->nullable();
            $table->date('analisador_validade')->nullable();
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
            $table->dropColumn('manometro_certificado');
            $table->dropColumn('manometro_validade');
            $table->dropColumn('analisador_certificado');
            $table->dropColumn('analisador_validade');
    });
    }
}
