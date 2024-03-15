<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCollumStatusToInterferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interferences', function (Blueprint $table) {
            $table->integer('status')->default(1)->comment('1 - Ativo / 0 - Inativo')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('interferences', function (Blueprint $table) {
            $table->integer('status')->default(0)->comment('0 - Ativo / 1 - Inativo')->change();
        });
    }
}
