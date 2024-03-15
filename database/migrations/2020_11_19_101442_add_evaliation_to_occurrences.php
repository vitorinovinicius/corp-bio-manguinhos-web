<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEvaliationToOccurrences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occurrences', function (Blueprint $table) {
            $table->integer('evaluation')->default(0)->comment("1 - Avaliado");
            $table->integer('send_mail')->default(0)->comment("0 - Não enviado, 1 - Enviado, 2 - Erro de envio");
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
            $table->dropColumn(['evaluation', 'send_mail']);
        });
    }
}
