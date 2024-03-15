<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'forms';

    /**
     * Run the migrations.
     * @table forms
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('contractor_id')->nullable();

            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('foto')->nullable();
            $table->integer('type')->nullable()->comment('1 - dinamico / 2 - estatico / 3 - misto');
            $table->tinyInteger('status')->nullable()->default('1');
            $table->tinyInteger('version')->nullable()->default('1');
            $table->dateTime('version_date')->nullable();

            $table->integer('is_all')->nullable()->default(0);
            $table->timestamps();

            $table->softDeletes();
            $table->unique(["id"], 'id_UNIQUE');
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
