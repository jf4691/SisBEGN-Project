<?php

use Illuminate\Database\Seeder;
use App\Ciudad;
use App\Provincia;


class CiudadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ciud1 = Ciudad::create([
            'provincia_id' => 1,
            'nombre' => 'Quito',
        ]);

        $ciud2 = Ciudad::create([
            'provincia_id' => 2,
            'nombre' => 'Guayaquil',
        ]);

        $ciud3 = Ciudad::create([
            'provincia_id' => 3,
            'nombre' => 'Latacunga',
        ]);

        $ciud4 = Ciudad::create([
            'provincia_id' => 4,
            'nombre' => 'Ibarra',
        ]);
    }
}
