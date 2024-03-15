<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccurrenceInterferenceTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'occurrence_interference';

    /**
     * Run the migrations.
     * @table occurrence_interference
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('occurrence_id');
            $table->unsignedInteger('interference_id');

            $table->timestamps();
            $table->softDeletes();

            $table->index(["occurrence_id"], 'occurrence_id_idx');

            $table->index(["interference_id"], 'interference_id_idx');


            $table->foreign('occurrence_id', 'occurrence_interference_occurrence_id_idx')
                ->references('id')->on('occurrences')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('interference_id', 'occurrence_interference_interference_id_idx')
                ->references('id')->on('interferences')
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
       Schema::dropIfExists($this->set_schema_table);
     }
}
