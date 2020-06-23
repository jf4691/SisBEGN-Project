<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('nivel_id');
            $table->unsignedBigInteger('anio_id');
            $table->unsignedBigInteger('docente_id');
            $table->string('codigo', 45)->unique();
            $table->char('seccion', 1)->nullable();
            $table->enum('registros', ['ninguno', 'parcial_1', 'parcial_2', 'supletorio']);
            $table->boolean('estado');

            $table->foreign('nivel_id')->references('id')->on('niveles');
            $table->foreign('anio_id')->references('id')->on('anios');
            $table->foreign('docente_id')->references('id')->on('docentes');

            $table->index(['nivel_id', 'anio_id', 'seccion']);

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
        Schema::dropIfExists('grados');
    }
}
