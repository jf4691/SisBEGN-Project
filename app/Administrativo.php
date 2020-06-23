<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{
    /**
     * Nombre de la tabla relacionada a este modelo.
     *
     * @var string
     */
    protected $table = 'administrativos';

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
    	'cargo',
    	'imagen',
    	'estado',
    ];

    /**
     * Obtiene el usuario ralacionado al administrativo.
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
     * Obtiene el nombre y apellido del administrativo.
     *
     * @return string
     */
    public function getNombreAndApellidoAttribute()
    {
        return $this->user->nombre . ' ' . $this->user->apellido;
    }
}
