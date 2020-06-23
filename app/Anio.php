<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anio extends Model
{
    /**
     * Nombre de la tabla relacionada a este modelo.
     *
     * @var string
     */
    protected $table = 'anios';

    /**
     * Atributos que son asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
    	'numero',
    	'activo',
    	'editable',
    	'estado',
    ];

    /**
     * Obtiene los grados que posee el año.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grados()
    {
        return $this->hasMany('App\Grado');
    }

    /**
     * Obtiene los alumnos que posee el año.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alumnos()
    {
        return $this->hasMany('App\Alumno');
    }

    /**
     * Obtiene las matriculas que posee el año.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matriculas()
    {
        return $this->hasMany('App\Matricula');
    }
    
}
