<?php

use Illuminate\Database\Seeder;

class OperatorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->insertGetId(
            [
                'uuid'           => \Webpatser\Uuid\Uuid::generate(),
                'name'           => 'Operator',
                'email'          => 'op@op.com',
                'contractor_id'  => 1,
                'password'       => bcrypt('123'),
                'remember_token' => str_random(10),
                'created_at'     => \Carbon\Carbon::now(),
                'updated_at'     => \Carbon\Carbon::now()
            ]
        );

        DB::table('role_user')->insert(['user_id'=>$user,'role_id'=>4]);

        $team = DB::table('teams')->insertGetId(
            [
                'uuid' => \Webpatser\Uuid\Uuid::generate(),
                'name' => 'Equipe teste',
                'contractor_id' => 1,
                'created_at' => \Carbon\Carbon::now()
            ]
        );

        DB::table('user_team')->insert([
            [
                'user_id'  => $user,
                'team_id'  => $team,
                'is_supervisor'  => 0,
            ]
        ]);

        DB::table('region_users')->insert([
            [
                'region_id'     => 1,
                'user_id'       => $user,
                'created_at'    => \Carbon\Carbon::now()
            ],[
                'region_id'     => 2,
                'user_id'       => $user,
                'created_at'    => \Carbon\Carbon::now()
            ]
        ]);

    }
}
