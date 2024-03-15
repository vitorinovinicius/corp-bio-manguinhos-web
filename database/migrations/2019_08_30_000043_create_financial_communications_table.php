<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialCommunicationsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'financial_communications';

    /**
     * Run the migrations.
     * @table financial_communications
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('financial_id');
            $table->unsignedInteger('user_id');
            $table->uuid('uuid');
            $table->text('message')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->index(["user_id"], 'fk_communications_users1_idx');

            $table->index(["financial_id"], 'fk_communications_financials1_idx');

            $table->unique(["id"], 'id_UNIQUE');


            $table->foreign('financial_id', 'fk_communications_financials1_idx')
                ->references('id')->on('financials')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('user_id', 'fk_communications_users1_idx')
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
