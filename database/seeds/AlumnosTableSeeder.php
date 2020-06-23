<?php

use Illuminate\Database\Seeder;
use App\Alumno;

class AlumnosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* $estu1 = Alumno::create([
            'nombre' => 'Juan Francisco',
            'apellido' => 'Perez Teran',
            'cedula' => '1715846651',
            'fecha_nacimiento' => '2009-06-23',
            'ciudad_id' => 1,
            'genero' => 'M',
            'direccion' => 'aaaaaaaaaaaaaa',
            'telefono' => '0995885112',
            'responsable' => 'Olga Lazo',
            'estado' => 1,
        ]);

        $estu2 = Alumno::create([
            'nombre' => 'Ximena Cristina',
            'apellido' => 'Gomez Oviedo',
            'cedula' => '1746548910',
            'fecha_nacimiento' => '2010-03-16',
            'ciudad_id' => 2,
            'genero' => 'F',
            'direccion' => 'bbbbbbbbbbbbbbbbb',
            'telefono' => '0995648932',
            'responsable' => 'Juan Perez',
            'estado' => 1,
        ]);

        $estu3 = Alumno::create([
            'nombre' => 'Manuel José',
            'apellido' => 'Zambrano Cornejo',
            'cedula' => '1789451322',
            'fecha_nacimiento' => '2011-07-15',
            'ciudad_id' => 3,
            'genero' => 'M',
            'direccion' => 'cccccccccccccccccc',
            'telefono' => '0991474313',
            'responsable' => 'Maricela Oviedo',
            'estado' => 1,
        ]); */
        $estu1 = Alumno::create([
            'user_id' => 4,
            'anio_id' => 1,
            'fecha_nacimiento' => '2009-06-23',
            'ciudad_id' => 1,
            'genero' => 'M',
            'direccion' => 'aaaaaaaaaaaaaa',
            'telefono' => '2414586',
            'responsable' => 'Olga Lazo',
            'celular' => '0981569847',
            'tipo' => 1,
            'grado_aprobado' => 'epf',
            'estado' => 1,
        ]);

        /* $estu2 = Alumno::create([
            'user_id' => 7,
            'fecha_nacimiento' => '2010-03-16',
            'ciudad_id' => 2,
            'genero' => 'F',
            'direccion' => 'bbbbbbbbbbbbbbbbb',
            'telefono' => '0995648932',
            'responsable' => 'Juan Perez',
            'estado' => 1,
        ]);

        $estu3 = Alumno::create([
            'user_id' => 8,
            'fecha_nacimiento' => '2011-07-15',
            'ciudad_id' => 3,
            'genero' => 'M',
            'direccion' => 'cccccccccccccccccc',
            'telefono' => '0991474313',
            'responsable' => 'Maricela Oviedo',
            'estado' => 1,
        ]); */

    }
}
