<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotasAlumnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas_alumno', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedBigInteger('grado_id');
            $table->unsignedBigInteger('materia_id');
            $table->unsignedBigInteger('alumno_id');

            $table->double('parcial_1', 4, 2);
            $table->double('parcial_2', 4, 2)->nullable();
            $table->double('supletorio', 4, 2)->nullable();
            $table->double('nota', 8, 2)->nullable();
            $table->enum('estado', ['Aprobado', 'Suspenso', 'Reprobado', '---']);

            $table->foreign('grado_id')->references('id')->on('grados')->onDelete('cascade');
            $table->foreign('materia_id')->references('id')->on('materias')->onDelete('cascade');
            $table->foreign('alumno_id')->references('id')->on('alumnos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notas_alumno');
    }
}
