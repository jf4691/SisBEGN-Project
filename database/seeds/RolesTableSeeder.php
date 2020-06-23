<?php

use Illuminate\Database\Seeder;
use App\Rol;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol1 = Rol::create([
            'codigo' => 'admin',
            'nombre' => 'Administrador',
            'estado' => 1,
        ]);

        $rol2 = Rol::create([
            'codigo' => 'secre',
            'nombre' => 'Secretaria',
            'estado' => 1,
        ]);

        $rol3 = Rol::create([
            'codigo' => 'docen',
            'nombre' => 'Docente',
            'estado' => 1,
        ]);

        $rol3 = Rol::create([
            'codigo' => 'estud',
            'nombre' => 'Estudiante',
            'estado' => 1,
        ]);
    }
}
