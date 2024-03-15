<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'teams';

    /**
     * Run the migrations.
     * @table teams
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('contractor_id')->nullable();
            $table->uuid('uuid');
            $table->string('name');
            $table->text('district')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(["contractor_id"], 'fk_teams_contractors1_idx');

            $table->unique(["uuid"], 'teams_uuid_unique');

            $table->foreign('contractor_id', 'fk_teams_contractors1_idx')
                ->references('id')->on('contractors')
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
