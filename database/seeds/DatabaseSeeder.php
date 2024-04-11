<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionTableSeeder::class);
        $this->call(GeneralSettingTableSeeder::class);
        $this->call(RegiaoTableSeeder::class);
        $this->call(UsersTableSeeder::class);

        //Empreteiras
        $this->call(BioManguinhosSeeder::class);

        $this->call(CancelamentoStatusTableSeeder::class);
        $this->call(MovesTypeSeeder::class);
        $this->call(ChecklistItensSeeder::class);
    }
}
