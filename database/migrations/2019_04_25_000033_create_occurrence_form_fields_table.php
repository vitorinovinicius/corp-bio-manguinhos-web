<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccurrenceFormFieldsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'occurrence_form_fields';

    /**
     * Run the migrations.
     * @table occurrence_form_fields
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('occurrence_id');
            $table->unsignedInteger('form_field_id');
            $table->text('observation')->nullable();
            $table->integer('situation')->nullable();

            $table->timestamps();

            $table->index(["occurrence_id"], 'fk_occurrence_form_fields_occurrences1_idx');

            $table->index(["form_field_id"], 'fk_occurrence_form_fields_form_fields1_idx');

            $table->unique(["id"], 'id_UNIQUE');


            $table->foreign('occurrence_id', 'fk_occurrence_form_fields_occurrences1_idx')
                ->references('id')->on('occurrences')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('form_field_id', 'fk_occurrence_form_fields_form_fields1_idx')
                ->references('id')->on('form_fields')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
