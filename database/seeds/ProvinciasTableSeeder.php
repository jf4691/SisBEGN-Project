<?php

use Illuminate\Database\Seeder;
use App\Provincia;

class ProvinciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prov1 = Provincia::create([
            'nombre' => 'Pichincha',
        ]);

        $prov2 = Provincia::create([
            'nombre' => 'Guayas',
        ]);

        $prov3 = Provincia::create([
            'nombre' => 'Cotopaxi',
        ]);

        $prov4 = Provincia::create([
            'nombre' => 'Imbabura',
        ]);
    }
}
