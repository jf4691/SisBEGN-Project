<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Rol;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ADMINISTRADOR
        $admin = User::create([
            'rol_id' => 1,
            'nombre' => 'Fernando',
            'apellido' => 'Pillalaza',
            'email' => 'admin@sisbegn.com',
            'password' => bcrypt('123456'),
            'cedula' => '1720543050',
            'imagen' => 'user_default.jpg',
            'estado' => 1,
            'ifnuevo' => 0,
            'remember_token' => Str::random(10),
        ]);

        //SECRETARIA
        $secre = User::create([
            'rol_id' => 2,
            'nombre' => 'Anita',
            'apellido' => 'Moscoso',
            'email' => 'secretaria@sisbegn.com',
            'password' => bcrypt('123456'),
            'cedula' => '1711111111',
            'imagen' => 'user_default.jpg',
            'estado' => 1,
            'remember_token' => Str::random(10),
        ]);

        //DOCENTES
        $docen1 = User::create([
            'rol_id' => 3,
            'nombre' => 'Byron',
            'apellido' => 'Loarte',
            'email' => 'docente@sisbegn.com',
            'password' => bcrypt('123456'),
            'cedula' => '1722222222',
            'imagen' => 'user_default.jpg',
            'estado' => 1,
            'remember_token' => Str::random(10),
        ]);

        /*$docen2 = User::create([
            'rol_id' => 3,
            'nombre' => 'Ivonne',
            'apellido' => 'Maldonado',
            'email' => 'ivonne.maldonado@sisbegn.com',
            'password' => bcrypt('123456'),
            'cedula' => '1733333333',
            'imagen' => 'user_default.jpg',
            'estado' => 1,
            'remember_token' => Str::random(10),
        ]);

        $docen3 = User::create([
            'rol_id' => 3,
            'nombre' => 'Juan',
            'apellido' => 'Zaldumbide',
            'email' => 'juan.zal@sisbegn.com',
            'password' => bcrypt('123456'),
            'cedula' => '1744444444',
            'imagen' => 'user_default.jpg',
            'estado' => 1,
            'remember_token' => Str::random(10),
        ]); */

        //ESTUDIANTES
        $estud1 = User::create([
            'rol_id' => 4,
            'nombre' => 'Estudiante',
            'apellido' => 'Uno',
            'email' => 'estudiante@sisbegn.com',
            'password' => bcrypt('123456'),
            'cedula' => '1733333333',
            'imagen' => 'user_default.jpg',
            'estado' => 1,
            'remember_token' => Str::random(10),
        ]);

        /*$estud2 = User::create([
            'rol_id' => 4,
            'nombre' => 'Estudiante',
            'apellido' => 'Dos',
            'email' => 'estudiante2@sisbegn.com',
            'password' => bcrypt('secret'),
            'cedula' => '1766666666',
            'imagen' => 'user_default.jpg',
            'estado' => 1,
            'remember_token' => Str::random(10),
        ]);

        $estud3 = User::create([
            'rol_id' => 4,
            'nombre' => 'Estudiante',
            'apellido' => 'Tres',
            'email' => 'estudiante3@sisbegn.com',
            'password' => bcrypt('secret'),
            'cedula' => '1777777777',
            'imagen' => 'user_default.jpg',
            'estado' => 1,
            'remember_token' => Str::random(10),
        ]); */
    }
}
