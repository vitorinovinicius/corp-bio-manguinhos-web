<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateContractorDistrictsTable.
 */
class CreateContractorDistrictsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contractor_districts', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('contractor_id');
            $table->unsignedInteger('district_id');
            $table->timestamps();
            $table->softDeletes();

        $table->index(["contractor_id"], 'fk_contractor_districts_contractors1_idx');
        $table->index(["district_id"], 'fk_contractor_districts_districts1_idx');

        $table->foreign('contractor_id', 'fk_contractor_districts_contractors1_idx')
            ->references('id')->on('contractors')
            ->onDelete('restrict')
            ->onUpdate('cascade');


        $table->foreign('district_id', 'fk_contractor_districts_districts1_idx')
            ->references('id')->on('districts')
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
		Schema::dropIfExists('contractor_districts');
	}
}
