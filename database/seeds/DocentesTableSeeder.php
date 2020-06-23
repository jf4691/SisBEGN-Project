<?php

use Illuminate\Database\Seeder;
use App\Docente;
use App\User;

class DocentesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doc1 = Docente::create([
            'user_id' => 3,
            'fecha_nacimiento' => '1989-03-23',
            'ciudad_id' => 1,
            'genero' => 'M',
            'direccion' => 'La Ecuatoriana',
            'telefono' => '0995885112',
            'especialidad' => 'Ingeniería en Sistemas',
            'imagen' => 'user_default.jpg',
            'estado' => 1,
        ]);

        /* $doc2 = Docente::create([
            'user_id' => 4,
            'fecha_nacimiento' => '1988-06-16',
            'ciudad_id' => 2,
            'genero' => 'F',
            'direccion' => 'gdgdfgdfgdsd',
            'telefono' => '0995648932',
            'especialidad' => 'Electrónica',
            'estado' => 1,
        ]);

        $doc3 = Docente::create([
            'user_id' => 5,
            'fecha_nacimiento' => '1987-07-15',
            'ciudad_id' => 3,
            'genero' => 'M',
            'direccion' => 'fbfgnghbr',
            'telefono' => '0991474313',
            'especialidad' => 'Mecánica',
            'estado' => 1,
        ]); */
    }
}
