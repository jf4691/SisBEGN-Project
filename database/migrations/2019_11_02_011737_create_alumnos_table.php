<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('anio_id');
            // $table->string('nombre', 100);
            // $table->string('apellido', 100);
            // $table->char('cedula', 10)->unique();
            $table->date('fecha_nacimiento');
            $table->unsignedBigInteger('ciudad_id');
            $table->enum('genero', ['F', 'M']);
            $table->string('direccion', 400)->nullable();
            $table->char('telefono', 9)->nullable();
            $table->string('responsable', 200);
            $table->boolean('estado');
            $table->string('grado_aprobado', 15)->nullable();
            $table->char('celular', 12);
            $table->boolean('tipo');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('anio_id')->references('id')->on('anios');
            $table->foreign('ciudad_id')->references('id')->on('ciudades');

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
        Schema::dropIfExists('alumnos');
    }
}
