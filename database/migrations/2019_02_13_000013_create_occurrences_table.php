<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccurrencesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'occurrences';

    /**
     * Run the migrations.
     * @table occurrences
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
            $table->unsignedInteger('occurrence_client_id');
            $table->unsignedInteger('occurrence_type_id');
            $table->unsignedInteger('contractor_id');
            $table->unsignedInteger('region_id')->nullable();
            $table->unsignedInteger('operator_id')->nullable();
            $table->unsignedInteger('cancelamento_status_id')->nullable();
            $table->date('schedule_date')->nullable();
            $table->time('schedule_time')->nullable();
            $table->text('motivo_nao_realizacao')->nullable();
            $table->string('numero_os')->nullable();
            $table->string('numero_cliente')->nullable();
            $table->integer('priority')->nullable()->comment('1 - Baixa / 2 - Normal / 3 - Alta / 4 - Urgente / 5 - Especial / 6 - Judicial');
            $table->integer('order_client')->nullable();           
            $table->boolean('approved')->default(0);
            $table->dateTime('approved_date')->nullable();
            $table->string('assinatura')->nullable();
            $table->text('obs_os')->nullable();
            $table->string('url')->nullable();
            $table->dateTime('check_in')->nullable();
            $table->string('check_in_lat')->nullable();
            $table->string('check_in_long')->nullable();
            $table->dateTime('check_out')->nullable();
            $table->string('check_out_lat')->nullable();
            $table->string('check_out_long')->nullable();
            $table->dateTime('download_at')->nullable();
            $table->dateTime('date_finish')->nullable();
            $table->integer('status')->default('1')->comment('1 - Pendente / 2 - Realizada / 3 - Não realizada / 4 - Cancelada');

            $table->timestamps();
            $table->softDeletes();

            $table->index(["operator_id"], 'operator_id_idx');

            $table->index(["occurrence_type_id"], 'occurrence_type_id_idx');

            $table->index(["region_id"], 'fk_occurrences_regions1_idx');

            $table->index(["contractor_id"], 'fk_occurrences_contractors1_idx');

            $table->index(["cancelamento_status_id"], 'fk_occurrences_cancelamento_statuses1_idx');

            $table->index(["occurrence_client_id"], 'occurrence_client_id_idx');

            $table->foreign('operator_id')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('occurrence_type_id')
                ->references('id')->on('occurrence_types')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('occurrence_client_id')
                ->references('id')->on('occurrence_clients')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('contractor_id')
                ->references('id')->on('contractors')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('region_id')
                ->references('id')->on('regions')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('cancelamento_status_id')
                ->references('id')->on('cancelamento_statuses')
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
