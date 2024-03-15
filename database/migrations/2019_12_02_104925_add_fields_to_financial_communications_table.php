<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToFinancialCommunicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('financial_communications', function (Blueprint $table) {
            $table->string('anexo')->nullable();
            $table->string('anexo_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('financial_communications', function (Blueprint $table) {
            $table->dropColumn('anexo');
            $table->dropColumn('anexo_name');
        });
    }
}
