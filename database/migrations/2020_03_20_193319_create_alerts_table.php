<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAlertsTable.
 */
class CreateAlertsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alerts', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->unsignedInteger('occurrence_id')->nullable()->comment('ID da OS que gerou atraso');
            $table->text('detail')->comment("Detalhamento do alerta");
            $table->text('treated_detail')->nullable()->comment("Detalhamento da resolucao do alerta");
            $table->dateTime('treated_date')->nullable()->comment("Data e hora da resolucao da ocorrencia");
            $table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('alerts');
	}
}
