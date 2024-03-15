<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class AddTypeToAlerts extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('alerts', function (Blueprint $table) {
                $table->integer('type')->nullable()->comment("1 - OS em atraso / 2 - OS com interferência / 3 - Equipamento");
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('alerts', function (Blueprint $table) {
                $table->dropColumn("type");
            });
        }
    }
