<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionContractorsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'region_contractors';

    /**
     * Run the migrations.
     * @table region_contractors
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('region_id');
            $table->unsignedInteger('contractor_id');

            $table->timestamps();

            $table->index(["region_id"], 'fk_region_contractors_regions1_idx');

            $table->index(["contractor_id"], 'fk_region_contractors_contractors1_idx');

            $table->unique(["id"], 'id_UNIQUE');


            $table->foreign('region_id', 'fk_region_contractors_regions1_idx')
                ->references('id')->on('regions')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('contractor_id', 'fk_region_contractors_contractors1_idx')
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
