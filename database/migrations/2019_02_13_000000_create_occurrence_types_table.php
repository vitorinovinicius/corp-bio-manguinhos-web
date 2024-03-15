<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccurrenceTypesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'occurrence_types';

    /**
     * Run the migrations.
     * @table occurrence_types
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('status')->default(1);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(["id"], 'id_UNIQUE');

            $table->unique(["uuid"], 'occurrence_types_uuid_unique');
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
