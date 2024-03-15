<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormGroupsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'form_groups';

    /**
     * Run the migrations.
     * @table form_groups
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('contractor_id')->nullable();

            $table->unsignedInteger('form_id');
            $table->uuid('uuid');
            $table->string('name');
            $table->tinyInteger('is_equipment')->nullable()->default('0');

            $table->timestamps();

            $table->index(["form_id"], 'fk_form_group_forms1_idx');

            $table->unique(["id"], 'id_UNIQUE');


            $table->foreign('form_id', 'fk_form_group_forms1_idx')
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
