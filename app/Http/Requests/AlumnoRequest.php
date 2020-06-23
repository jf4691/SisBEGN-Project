<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlumnoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'anio_id'          => 'required',
            'nombre'           => 'required|max:60|regex:/^[\pL\s\-]+$/u', //regex solo letras y espacios
            'apellido'         => 'required|max:60|regex:/^[\pL\s\-]+$/u',
            'cedula'           => 'required|min:10|max:10|unique:alumnos,cedula,' . $this->route('alumno'),
            'fecha_nacimiento' => 'required',
            'genero'           => 'required',
            'ciudad_id'        => 'required',
            'direccion'        => 'max:100',
            'telefono'         => 'required|numeric|max:9',
            'responsable'      => 'required|max:50',
            'celular'          => 'nullable|numeric|max:12',
        ];
    }
}
