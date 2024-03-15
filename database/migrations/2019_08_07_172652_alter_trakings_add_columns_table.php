<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTrakingsAddColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trakings', function (Blueprint $table) {
            $table->string("device_version_number")->nullable();
            $table->string("base_os")->nullable();
            $table->string("codename")->nullable();
            $table->string("version_sdk_int")->nullable();
            $table->string("version_release")->nullable();
            $table->string("product")->nullable();
            $table->string("last_size")->nullable();
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
            $table->dropColumn("device_version_number");
            $table->dropColumn("base_os");
            $table->dropColumn("codename");
            $table->dropColumn("version_sdk_int");
            $table->dropColumn("version_release");
            $table->dropColumn("product");
            $table->dropColumn("last_size");
        });
    }
}
