<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class TeamTableSeeder extends Seeder {

    public function run()
    {
        DB::table('setores')->insert([
            [
                'uuid'           => \Webpatser\Uuid\Uuid::generate(),
                'name'           => 'Equipe Padrão Bio-Manguinhos',
                'empresa_id'  => null,
                'created_at'     => \Carbon\Carbon::now()
            ]
        ]);

    }

}