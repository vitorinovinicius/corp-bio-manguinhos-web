<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTiketsTable.
 */
class CreateTiketsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tickets', function(Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->text('description');
            $table->unsignedInteger('user_id');
            $table->integer('status')->default(1)->comment('1 - Em aberto, 2 - Candelado, 3 - Fechado (Gerou OS)');
            $table->text('justification')->nullable();
            $table->integer('email_status')->default(1)->comment('1 - Ticket Criado, 2 - Ticket Respondido');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')
                ->references('id')->on('users')
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
		Schema::drop('tikets');
	}
}
