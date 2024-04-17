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
        $this->call(UsersTableSeeder::class);

        //Empresa
        $this->call(BioManguinhosSeeder::class);
    }
}
