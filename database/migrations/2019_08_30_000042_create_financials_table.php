<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'financials';

    /**
     * Run the migrations.
     * @table financials
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('occurrence_id');
            $table->unsignedInteger('user_id');
            $table->uuid('uuid');
            $table->integer('status')->nullable()->default('0')->comment('0 - Pendente
                1 - Aprovado
                2 - Reprovado
                3 - Solicitado ajuste
                4 - Ajuste feito pela ECC');
            $table->text('message')->nullable();
            $table->dateTime('data_approved')->nullable();
            $table->timestamps();
            $table->softDeletes();



            $table->index(["occurrence_id"], 'fk_financials_occurrences1_idx');

            $table->index(["user_id"], 'fk_financials_users1_idx');

            $table->unique(["id"], 'id_UNIQUE');

            $table->foreign('occurrence_id', 'fk_financials_occurrences1_idx')
                ->references('id')->on('occurrences')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('user_id', 'fk_financials_users1_idx')
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
        Schema::dropIfExists($this->tableName);
    }
}
