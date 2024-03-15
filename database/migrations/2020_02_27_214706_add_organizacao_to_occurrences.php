<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrganizacaoToOccurrences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('occurrences', function (Blueprint $table) {
            $table->string('organizacao')->nullable()->comment('CEG, CEG Rio');
            $table->integer('organizacao_id')->nullable()->comment('1 - CEG, 2 - CEG Rio');
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
            $table->dropColumn('organizacao');
            $table->dropColumn('organizacao_id');
        });
    }
}
