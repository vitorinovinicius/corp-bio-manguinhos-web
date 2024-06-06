<?php

use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'uuid'           => Uuid::generate(),
                'name'           => 'Superuser',
                'email'          => 'superuser@fiotec.com.br',
                'password'       => bcrypt('123456'),
                'remember_token' => str_random(10),
                'created_at'     => Carbon::now()
            ]
        ]);

        DB::table('role_user')->insert(['user_id'=>1,'role_id'=>1]);

        DB::table('users')->insert([
            [
                'uuid'           => Uuid::generate(),
                'name'           => 'Admin Bio-Manguinhos',
                'email'          => 'admin@fiotec.com',
                'password'       => bcrypt('123456'),
                'remember_token' => str_random(10),
                'created_at'     => Carbon::now()
            ]
        ]);

        DB::table('role_user')->insert(['user_id'=>2,'role_id'=>2]);


        DB::table('oauth_clients')->insert([
            'user_id'=>1,
            'name'=>'API Bio-Maguinhos',
            'secret'=>'v21wwzw8BqlYrjkceq3rN4ojUtzw6dO85QXX5agv',
            'redirect'=>'http://localhost',
            'personal_access_client'=>0,
            'password_client'=>1,
            'revoked'=>0,
            'created_at' => Carbon::now()
        ]);
    }
}
