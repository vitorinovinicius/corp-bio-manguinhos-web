<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'moves';

    /**
     * Run the migrations.
     * @table moves
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
            $table->unsignedInteger('move_type_id');
            $table->unsignedInteger('operator_id');
            $table->unsignedInteger('occurrence_id')->nullable();
            $table->string('km_atual')->nullable();
            $table->binary('hodometro_foto')->nullable();
            $table->string('check_in_lat')->nullable();
            $table->string('check_in_long')->nullable();
            $table->string('check_out_lat')->nullable();
            $table->string('check_out_long')->nullable();
            $table->dateTime('check_in')->nullable();
            $table->dateTime('check_out')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(["occurrence_id"], 'occurrence_id_idx');

            $table->index(["move_type_id"], 'move_type_id_idx');

            $table->index(["operator_id"], 'operator_id_idx1');


            $table->foreign('move_type_id', 'move_type_id_idx')
                ->references('id')->on('move_types')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('operator_id', 'operator_id_idx1')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('occurrence_id', 'occurrence_id_idx')
                ->references('id')->on('occurrences')
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
