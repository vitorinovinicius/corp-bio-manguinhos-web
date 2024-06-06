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
        $this->call([
            RolesAndPermissionTableSeeder::class,
            UsersTableSeeder::class,
            SetorSeeder::class,
            BioManguinhosSeeder::class
        ]);
    }
}
