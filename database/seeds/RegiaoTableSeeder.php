<?php

use Illuminate\Database\Seeder;

class RegiaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert([
            [
                'name'           => 'Rio de Janeiro',
            ]
        ]);

//        DB::table('regions')->insert([
//            [
//                'name'           => 'Fluminense',
//            ]
//        ]);
//
//        DB::table('regions')->insert([
//            [
//                'name'           => 'Controle de Energia',
//            ]
//        ]);

    }
}
