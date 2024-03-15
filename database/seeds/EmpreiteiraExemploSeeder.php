<?php

use Illuminate\Database\Seeder;

class EmpreiteiraExemploSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contractor = DB::table('contractors')->insertGetId(
            [
                'name'           => 'EMPREITEIRA A',
                'uuid'           => \Webpatser\Uuid\Uuid::generate(),
                'icon'           => '/css/images/technical1.png',
                'logo_cabecalho' => url('/img/contractor/1/logo.jpeg'),
                'address'        => 'Endereço fictício',
                'cnpj'           => '00.000.000/0000-00',
                'phone1'         => '(00) 0000-0000',
                'phone2'         => '',
                'email'          => '',
                'site'           => 'www.centralsystem.com.br',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()

            ]
        );

        //ID = 5
        $user = DB::table('users')->insertGetId(
            [
                'uuid' => \Webpatser\Uuid\Uuid::generate(),
                'name' => 'Administrador EMPREITEIRA A',
                'email' => 'admin@empreiteiraa.com.br',
                'password' => bcrypt('admin123'),
                'contractor_id' => $contractor,
                'remember_token' => str_random(10),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        );

        DB::table('role_user')->insert(['user_id' => $user, 'role_id' => 2]);


        //ID = 6
        $user = DB::table('users')->insertGetId(
            [
                'uuid' => \Webpatser\Uuid\Uuid::generate(),
                'name' => 'Operador supervisor EMPREITEIRA A',
                'email' => 'supervisor@empreiteiraa.com.br',
                'cpf' => '11111111111',
                'ecc' => 'EMPREITEIRA A',
                'contractor_id' => $contractor,
                'password' => bcrypt('123456'),
                'remember_token' => str_random(10),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]
        );
        DB::table('role_user')->insert([
            [
                'user_id' => $user,
                'role_id' => 4
            ], [
                'user_id' => $user,
                'role_id' => 3
            ]
        ]);

        $team = DB::table('teams')->insertGetId(
            [
                'uuid' => \Webpatser\Uuid\Uuid::generate(),
                'name' => 'Equipe EMPREITEIRA A',
                'contractor_id' => $contractor,
                'created_at' => \Carbon\Carbon::now()
            ]
        );

        DB::table('user_team')->insert([
            [
                'user_id' => $user,
                'team_id' => $team,
                'is_supervisor' => 1,
            ], [
                'user_id' => $user,
                'team_id' => $team,
                'is_supervisor' => 0,
            ]
        ]);
        DB::table('region_contractors')->insert([
            [
                'contractor_id' => $contractor,
                'region_id' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ], [
                'contractor_id' => $contractor,
                'region_id' => 2,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],
        ]);

        DB::table('region_users')->insert([
            [
                'region_id' => 1,
                'user_id' => $user,
                'created_at' => \Carbon\Carbon::now()
            ], [
                'region_id' => 2,
                'user_id' => $user,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
