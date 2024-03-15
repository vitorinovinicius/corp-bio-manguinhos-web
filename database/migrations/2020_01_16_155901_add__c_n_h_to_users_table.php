<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCNHToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cnh')->nullable();
            $table->char('cnh_type')->nullable()->comment('A, B, C');
            $table->date('cnh_expires')->nullable()->comment('Data vencimento da cnh');
            $table->unsignedInteger('vehicle_id')->nullable();

            $table->index(["vehicle_id"], 'fk_user_vehicle1_idx');

            $table->foreign('vehicle_id', 'fk_user_vehicle1_idx')
                ->references('id')->on('vehicles')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
            $table->dropColumn(['cnh', 'cnh_type', 'cnh_expires']);
        });
    }
}
