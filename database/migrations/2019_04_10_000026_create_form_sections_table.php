<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormSectionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'form_sections';

    /**
     * Run the migrations.
     * @table form_sections
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('contractor_id')->nullable();
            $table->unsignedInteger('form_id')->nullable();
            $table->unsignedInteger('form_group_id')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('form_group_id')
                ->references('id')->on('form_groups')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('form_id')
                ->references('id')->on('forms')
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
