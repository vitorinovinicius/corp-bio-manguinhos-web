<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class TeamTableSeeder extends Seeder {

    public function run()
    {
        DB::table('teams')->insert([
            [
                'uuid'           => \Webpatser\Uuid\Uuid::generate(),
                'name'           => 'Equipe Padrão Bio-Manguinhos',
                'contractor_id'  => null,
                'created_at'     => \Carbon\Carbon::now()
            ]
        ]);

//        DB::table('user_team')->insert([
//            [
//                'user_id'  => 2,
//                'team_id'  => 1,
//                'is_supervisor'  => 1,
//            ]
//        ]);

    }

}