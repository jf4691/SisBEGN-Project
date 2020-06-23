<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    /**
     * Nombre de la tabla relacionada a este modelo.
     *
     * @var string
     */
    protected $table = 'docentes';

    /**
     * Atributos que son asignados en masa.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id',
        //'cedula',
        'fecha_nacimiento',
    	'genero',
        'direccion',
        'ciudad_id',
    	'telefono',
    	'especialidad',
    	'imagen',
    	'estado',
    ];

    /**
     * Obtiene el usuario ralacionado al docente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function ciudad()
    {
        return $this->belongsTo('App\Ciudad');
    }


    /**
     * Obtiene los grados de los cuales es orientador el docente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grados()
    {
        return $this->hasMany('App\Grado');
    }

    /**
     * Obtiene los grados donde imparte clases de alguna materia el docente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function grados2()
    {
        return $this->belongsToMany('App\Grado', 'grado_materia')
            ->withPivot('materia_id')
            ->withTimestamps();
    }

    /**
     * Obtiene las materias que imparte el docente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function materias()
    {
        return $this->belongsToMany('App\Materia', 'grado_materia')
            ->withPivot('grado_id')
            ->withTimestamps();
    }

    /**
     * Obtiene el nombre y apellido del docente.
     *
     * @return string
     */
    public function getNombreAndApellidoAttribute()
    {
        return $this->user->nombre . ' ' . $this->user->apellido;
    }
}
