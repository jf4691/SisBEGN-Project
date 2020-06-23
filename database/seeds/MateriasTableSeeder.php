<?php

use Illuminate\Database\Seeder;
use App\Materia;

class MateriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mat1 = Materia::create([
            'codigo' => 'MAT1',
            'nombre' => 'Matemáticas',
            'estado' => 1,
        ]);

        $mat2 = Materia::create([
            'codigo' => 'MAT2',
            'nombre' => 'Lenguaje',
            'estado' => 1,
        ]);

        $mat3 = Materia::create([
            'codigo' => 'MAT3',
            'nombre' => 'Física',
            'estado' => 1,
        ]);

        $mat4 = Materia::create([
            'codigo' => 'MAT4',
            'nombre' => 'Química',
            'estado' => 1,
        ]);
    }
}
