<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCollumTypeLogImport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_imports', function (Blueprint $table) {
            $table->integer("type_import")->default(1)->comment("1 = IMPORTAÇÃO PADRÃO / 2 = IMPORTAÇÃO CRUZAMENTO FINANCEIRO");
            $table->unsignedInteger('contractor_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_imports', function (Blueprint $table) {
            $table->dropColumn("type_import");
            $table->unsignedInteger('contractor_id')->change();
        });
    }
}
