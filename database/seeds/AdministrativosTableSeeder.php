<?php

use Illuminate\Database\Seeder;
use App\Administrativo;
use App\User;

class AdministrativosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin1 = Administrativo::create([
            'user_id' => 1,
            'fecha_nacimiento' => '1991-06-04',
            'ciudad_id' => 1,
            'genero' => 'M',
            'direccion' => 'Calle Tixán y de los Madroños',
            'telefono' => '0992839553',
            'cargo' => 'Rector',
            'imagen' => 'user_default.jpg',
            'estado' => 1,
        ]);

        $admin2 = Administrativo::create([
            'user_id' => 2,
            'fecha_nacimiento' => '1989-03-23',
            'ciudad_id' => 1,
            'genero' => 'F',
            'direccion' => 'Av. 6 de Diciembre y El Inca',
            'telefono' => '0984136548',
            'cargo' => 'Secretaria',
            'imagen' => 'user_default.jpg',
            'estado' => 1,
        ]);
    }
}
