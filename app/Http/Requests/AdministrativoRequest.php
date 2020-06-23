<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdministrativoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'          => 'required',
            'fecha_nacimiento' => 'required',
            'genero'           => 'required',
            'ciudad_id'        => 'required',
            'direccion'        => 'max:100',
            'telefono'         => 'required|max:12',
            //'imagen'
        ];
    }
}
