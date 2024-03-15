<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldTrakingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trakings', function (Blueprint $table) {
            $table->string('battery')->nullable();
            $table->string('ip')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('platform_mobile')->nullable();
            $table->string('model')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trakings', function (Blueprint $table) {
            $table->dropColumn('battery');
            $table->dropColumn('ip');
            $table->dropColumn('mobile_number');
            $table->dropColumn('platform_mobile');
            $table->dropColumn('model');
        });
    }
}
