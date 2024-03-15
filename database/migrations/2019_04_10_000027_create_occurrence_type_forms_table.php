<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccurrenceTypeFormsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'occurrence_type_forms';

    /**
     * Run the migrations.
     * @table occurrence_type_forms
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('occurrence_type_id');

            $table->unsignedInteger('form_id');
            $table->boolean('is_required')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('form_id')
                ->references('id')->on('forms')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('occurrence_type_id')
                ->references('id')->on('occurrence_types')
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
