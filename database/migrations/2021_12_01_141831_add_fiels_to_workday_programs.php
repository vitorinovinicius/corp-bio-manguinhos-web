<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFielsToWorkdayPrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workday_programs', function (Blueprint $table) {
            $table->time('working_day_start')->nullable();
            $table->time('lunch_start')->nullable();
            $table->time('lunch_end')->nullable();
            $table->time('working_day_end')->nullable();
            
            $table->time('hour')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workday_programs', function (Blueprint $table) {
            $table->dropColumn([
                'working_day_start',
                'lunch_start',
                'lunch_end',
                'working_day_end',
            ]);

            $table->integer('hour')->change();

        });
    }
}
