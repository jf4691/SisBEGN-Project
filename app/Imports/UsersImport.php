<?php

namespace App\Imports;

use App\User;
use App\Alumno;
use DB;
// 
use Laracasts\Flash\Flash;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class UsersImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $errors = []; // array to accumulate errors
    public function collection(Collection $rows)
    {
        $rows = $rows->toArray();
        foreach ($rows as $row) {
            $validator = Validator::make($row, $this->rules(), $this->validationMessages($row));
            // dd($validator->fails());
            if ($validator->fails()) {
                foreach ($validator->errors()->messages() as $messages) {
                    foreach ($messages as $error) {
                        // accumulating errors:
                        $this->errors[] = $error;
                    }
                }
            } else {
                $user = new User;
                $user->rol_id = 4;
                $user->nombre = $row['nombre'];
                $user->apellido = $row['apellido'];
                $user->email = $row['email'];
                $user->password = \Hash::make('123456');
                $user->cedula = $row['cedula'];
                $user->estado = 1;
                $user->save();

                $anio = DB::table('anios')
                    ->select('id')
                    ->where('activo', 1)
                    ->first();

                $alumno = new Alumno;
                $alumno->user_id = $user->id;
                $alumno->anio_id = $anio->id;
                $alumno->fecha_nacimiento = $row['fecha_nacimiento'];
                $alumno->ciudad_id = (int)$row['ciudad'];
                $alumno->genero = $row['genero'];
                $alumno->direccion = ($row['direccion'] != null) ? $row['direccion'] : null;
                $alumno->telefono = ($row['telefono'] != null) ? $row['telefono'] : null;
                $alumno->responsable = $row['responsable'];
                $alumno->estado = 1;
                $alumno->grado_aprobado = ($row['grado_aprobado'] != null) ? $row['grado_aprobado'] : null;
                $alumno->celular = $row['celular'];
                $alumno->tipo = 1;
                $alumno->save();
            }
        }
        // dd(count($this->errors));
        $msgErrors = '';
        foreach ($this->errors as $error) {
            $msgErrors .= '<li>'.$error.'</li>';
        }
        if (count($this->errors) > 0) {
            flash('
                <h4>Error:</h4>
                <ul>'.$msgErrors.'</ul>
            ')->error()->important();
        } else {
            flash('
                <h4>CARGA EXITOSA</h4>
                <p>El archivo se ha importado exitosamente.</p>
            ')->success()->important();
        }
    }
    public function rules(): array
    {
        return [
            'nombre' => 'bail|required|string|max:255',
            'apellido' => 'bail|required|string|max:255',
            'email' => 'bail|required|string|email|max:255|unique:users',
            'cedula' => 'bail|required|max:10|unique:users',
            'fecha_nacimiento' => 'required',
            'genero' => 'required',
            'ciudad' => 'required',
            'responsable' => 'required',
            'celular' => 'required'
        ];
    }
    // Retornta todos los errores en las validaciones
    public function getErrors()
    {
        return $this->errors;
    }
    // Retorna los mensajes de error personalizado
    public function validationMessages($row)
    {
        return [
            'email.unique' => trans('El :attribute '.$row['email'].' ya se encuentra registrado'),
            'cedula.unique' => trans('La :attribute '.$row['cedula'].' ya se encuentra registrado '),
        ];
    }
}
