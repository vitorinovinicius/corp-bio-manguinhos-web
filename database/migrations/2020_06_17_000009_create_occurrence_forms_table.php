<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccurrenceFormsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'occurrence_forms';

    /**
     * Run the migrations.
     * @table occurrence_forms
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('occurrence_id');
            $table->unsignedInteger('form_id');

            $table->foreign('occurrence_id')
                ->references('id')->on('occurrences')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('form_id')
                ->references('id')->on('forms')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->set_schema_table);
    }
}
