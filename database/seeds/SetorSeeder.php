<?php

use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

class SetorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setores')->insert([
            [
                'uuid'          => Uuid::generate(),
                'name'          => 'Recursos humanos',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],

            [
                'uuid'          => Uuid::generate(),
                'name'          => 'Contabilidade',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],

            [
                'uuid'          => Uuid::generate(),
                'name'          => 'Tecnologia da informação',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name'          => 'Conhecimento',
                'uuid'          => Uuid::generate(),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()

            ]
        ]);
    }
}
