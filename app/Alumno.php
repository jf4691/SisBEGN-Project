<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    /**
     * Nombre de la tabla relacionada a este modelo.
     *
     * @var string
     */
    protected $table = 'alumnos';

    /**
     * Atributos que son asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
        'anio_id',
    	'nombre',
    	'apellido',
    	'cedula',
        'fecha_nacimiento',
        'ciudad_id',
    	'genero',
    	'direccion',
    	'telefono',
    	'responsable',
        'estado',
        'tipo'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function anio()
    {
        return $this->belongsTo('App\Anio');
    }

    /**
     * Obtiene la ciudad ralacionado al estudiante.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ciudad()
    {
        return $this->belongsTo('App\Ciudad');
    }

    /**
     * Obtiene las matriculas del estudiante.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matriculas()
    {
        return $this->hasMany('App\Matricula');
    }


    /**
     * Obtiene el nombre y Apellido del estudiante.
     *
     * @return string
     */
    public function getNombreAndApellidoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

}
