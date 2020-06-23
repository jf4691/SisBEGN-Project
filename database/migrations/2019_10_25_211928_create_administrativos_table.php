<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministrativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrativos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            //$table->char('cedula', 10)->unique();
            $table->date('fecha_nacimiento');
            $table->string('direccion', 400)->nullable();
            $table->unsignedBigInteger('ciudad_id');
            $table->enum('genero', ['F', 'M']);
            $table->char('telefono', 12);
            $table->string('cargo', 100)->nullable();
            $table->string('imagen', 100)->default('docente_default.jpg');
            $table->boolean('estado');

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('administrativos');
    }
}
