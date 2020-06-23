<?php

use Illuminate\Database\Seeder;
use App\Anio;

class PeriodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $periodo = Anio::create([
            'numero' => '2020A',
            'activo' => 1,
            'editable' => 1,
            'estado' => 1,
        ]);
    }
}
