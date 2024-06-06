<?php

use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;
use Carbon\Carbon;

class BioManguinhosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setores = DB::table('setores')->insertGetId(
            [
                'name'              => 'Conhecimento',
                'uuid'              => Uuid::generate(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()

            ]
        );

        //ID = 5
        $user = DB::table('users')->insertGetId(
            [
                'uuid'              => Uuid::generate(),
                'name'              => 'Gerente',
                'email'             => 'gerente@fiotec.com.br',
                'password'          => bcrypt('admin123'),
                'remember_token'    => str_random(10),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]
        );
        
        DB::table('user_setores')->insert(
            [
                'user_id' => $user,
                'setor_id' => $setores
            ]
        );
        DB::table('role_user')->insert(['user_id' => $user, 'role_id' => 3]);


        //ID = 6
        $user = DB::table('users')->insertGetId(
            [
                'uuid'              => Uuid::generate(),
                'name'              => 'Colaborador Bio-Manguinhos',
                'email'             => 'colaborador@fiotec.com.br',
                'cpf'               => '11111111111',
                'password'          => bcrypt('123456'),
                'remember_token'    => str_random(10),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]
        );

        DB::table('user_setores')->insert(['user_id' => $user, 'setor_id' => 2]);

        DB::table('role_user')->insert(
            [
                'user_id' => $user,
                'role_id' => 4
            ]
        );
    }
}
