<?php

use Illuminate\Database\Seeder;
use App\Nivel;

class NivelesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $niv1 = Nivel::create([
            'codigo' => 'EB1',
            'nombre' => 'Octavo',
            'orientador_materia' => 0,
            'estado' => 1,
        ]);

        $niv2 = Nivel::create([
            'codigo' => 'EB2',
            'nombre' => 'Noveno',
            'orientador_materia' => 0,
            'estado' => 1,
        ]);

        $niv3 = Nivel::create([
            'codigo' => 'EB3',
            'nombre' => 'Décimo',
            'orientador_materia' => 0,
            'estado' => 1,
        ]);

        $niv4 = Nivel::create([
            'codigo' => 'BA1',
            'nombre' => 'Primero BGU',
            'orientador_materia' => 0,
            'estado' => 1,
        ]);

        /* $niv5 = Nivel::create([
            'codigo' => 'BA2',
            'nombre' => 'Segundo BGU',
            'orientador_materia' => 0,
            'estado' => 1,
        ]); */
    }
}

