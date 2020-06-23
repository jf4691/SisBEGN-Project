<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('alumno_id');
            $table->unsignedBigInteger('grado_id');
            $table->unsignedBigInteger('anio_id');
            $table->date('desercion')->nullable();
            $table->enum('estado_alumno', ['en_curso', 'promovido', 'reprobado']);
            $table->boolean('condicion');

            $table->foreign('alumno_id')->references('id')->on('alumnos');
            $table->foreign('grado_id')->references('id')->on('grados');
            $table->foreign('anio_id')->references('id')->on('anios');

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
        Schema::dropIfExists('matriculas');
    }
}
