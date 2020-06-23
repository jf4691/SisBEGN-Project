<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $user = User::find($this->route('user'));

        $rules = array(
            'rol_id'   => 'required',
            'nombre'   => 'required|max:25',
            'apellido' => 'required|max:25',
            'email'    => 'required|max:60|email|unique:users,email,' . $this->route('user'),
            'password' => 'max:15',
            'cedula'   => 'required|min:10|max:10|unique:users,cedula,' . $this->route('user'),
            'imagen'   => 'image|mimes:jpeg,png,bmp|max:2048',
        );

        if ($user == null) {
            $rules['password'] .= '|required|min:6|max:15';
        }

        return $rules;
    }
}
