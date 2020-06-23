<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    /**
     * Nombre de la tabla relacionada a este modelo.
     *
     * @var string
     */
    protected $table = 'ciudades';

    /**
     * Atributos que son asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
    	'provincia_id',
    	'nombre',
    ];

    /**
     * Obtiene el provincia al que pertenece a la ciudad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provincia()
    {
        return $this->belongsTo('App\Provincia');
    }

    /**
     * Obtiene los alumnos que viven en la ciudad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alumnos()
    {
        return $this->hasMany('App\Alumno');
    }

    public function docentes()
    {
        return $this->hasMany('App\Docente');
    }
}
