<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormFieldsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'form_fields';

    /**
     * Run the migrations.
     * @table form_fields
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('contractor_id')->nullable();

            $table->unsignedInteger('form_section_id');
            $table->string('code')->nullable();
            $table->text('acceptance_criteria')->nullable();
            $table->text('item_inspection')->nullable();

            $table->boolean('status')->default(1);

            $table->tinyInteger('type_field')->comments('
                1 = Checkbox, 
                2 = Texto, 
                3 = Radio, 
                4 = Numero, 
                5 = Imagem
            ');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('list')->nullable();
            $table->string('value')->nullable();
            $table->boolean('required')->default(0);
            $table->boolean('required_photo')->default(0);
            $table->tinyInteger('is_photo')->default(0);
            $table->tinyInteger('min_photo')->default(0);
            $table->softDeletes();


            $table->timestamps();

            $table->foreign('form_section_id')
                ->references('id')->on('form_sections')
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
