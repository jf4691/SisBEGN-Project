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
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProvinciasTableSeeder::class);
        $this->call(CiudadesTableSeeder::class);
        $this->call(PeriodosTableSeeder::class);
        //$this->call(MateriasTableSeeder::class);
        //$this->call(NivelesTableSeeder::class);
        $this->call(AlumnosTableSeeder::class);
        $this->call(AdministrativosTableSeeder::class);
        $this->call(DocentesTableSeeder::class);
    }
}
