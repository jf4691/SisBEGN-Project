<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Alumno;
use App\Provincia;
use App\Ciudad;
use App\User;
use App\Anio;
use App\Matricula;
use App\Http\Requests\AlumnoRequest;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use DB;

class AlumnoController extends Controller
{
    /**
     * Muestra una lista de estudiantes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request) {
            $query = trim((string)$request->get('searchText'));

            $anios = Anio::orderBy('id', 'desc')->get();

            $anio="";

            if ($request->get('searchAnio') == null) {

                //Cuando no se ha seleccionado ningun Anio
                $alumnos = DB::table('alumnos as a')
                ->join('users as u', 'a.user_id', '=', 'u.id')
                ->join('anios', 'a.anio_id', '=', 'anios.id')
                ->select('u.*', 'a.*', 'anios.numero', 'anios.activo')
                ->where([
                    ['anios.activo', 1],
                    ['a.estado', 1],
                    ['u.cedula', 'like', '%' . $query . '%'],
                ])
                ->orWhere([
                    ['anios.activo', 1],
                    ['a.estado', 1],
                    ['u.apellido', 'like', '%' . $query . '%'],
                ])
                ->orWhere([
                    ['anios.activo', 1],
                    ['a.estado', 1],
                    ['u.nombre', 'like', '%' . $query . '%'],
                ])
                
                ->orderBy('u.apellido', 'asc')
                ->orderBy('u.nombre', 'asc')
                ->paginate(25);

            }else{

                // Cuando se ha seleccionado un Anio.
                $anio = trim((string)$request->get('searchAnio'));
                
                $alumnos = DB::table('alumnos as a')
                ->join('users as u', 'a.user_id', '=', 'u.id')
                ->join('anios', 'a.anio_id', '=', 'anios.id')
                ->select('u.cedula', 'u.nombre', 'apellido', 'a.id', 'a.genero', 'a.estado',
                'anios.numero', 'anios.activo','a.tipo')
                ->where('anios.id', $anio)
                ->where('a.estado', 1)
                ->orderBy('u.apellido', 'asc')
                ->orderBy('u.nombre', 'asc')
                ->paginate(25);

            }
        }

        foreach ($alumnos as $row) {
            if (DB::table('matriculas')->where('alumno_id', $row->id)->exists()) {
                $tmpMatricula = Matricula::select('condicion')
                    ->where('alumno_id', $row->id)
                    ->orderBy('created_at','DESC')
                    ->first();
                
                $row->darBaja = ($tmpMatricula->condicion) ? 'not' : 'yes';
            } else {
                $row->darBaja = 'delete';
            }
            // $row->matricula = (DB::table('matriculas')->where('alumno_id', $row->id)->where('condicion', 1)->exists()) ? 'yes' : '';
        }

        return view('alumnos.index')
            ->with('anios', $anios)
            ->with('alumnos', $alumnos)
            ->with('anio', $anio)
            ->with('searchText', $query);
    }

    //Funcion para estudiantes Inactivos
    public function inactiveStudents(Request $request)
    {
        if ($request) {
            $query = trim((string)$request->get('searchText'));

            $alumnos = DB::table('alumnos as a')
            ->join('users as u', 'a.user_id', '=', 'u.id')
            ->join('anios', 'a.anio_id', '=', 'anios.id')
            ->select('u.*', 'a.*', 'anios.numero')
            ->where([
                ['a.estado', 0],
                ['u.cedula', 'like', '%' . $query . '%'],
            ])
            ->orWhere([
                ['a.estado', 0],
                ['u.apellido', 'like', '%' . $query . '%'],
            ])
            ->orWhere([
                ['a.estado', 0],
                ['u.nombre', 'like', '%' . $query . '%'],
            ])
            ->orderBy('u.apellido', 'asc')
            ->orderBy('u.nombre', 'asc')
            ->paginate(25);
        }

        return view('alumnos.inactiveStudents')
            ->with('alumnos', $alumnos)
            ->with('searchText', $query);
    }

    /**
     * Muestra el formulario para crear un nuevo estudiante.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provincias = Provincia::orderBy('nombre', 'asc')->pluck('nombre', 'id');
        $ciudades = Ciudad::orderBy('nombre', 'asc')->get();
        $anios = Anio::where('activo', 1)->get();
    
        return view('alumnos.create')
            ->with('provincias', $provincias)
            ->with('ciudades', $ciudades)
            ->with('anios', $anios);
    }

    /**
     * Almacena un estudiante recién creado en la base de datos.
     *
     * @param  \App\Http\Requests\AlumnoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        // dd($request);
        $request->validate([
            'nombre' => 'bail|required|string|max:20',
            'apellido' => 'bail|required|string|max:20',
            'email' => 'bail|required|string|email|max:60|unique:users',
            'password' => 'bail|required|string|min:6|max:15',
            'cedula' => 'bail|required|string|min:10|max:10|unique:users',
        ]);
        // Validación de la fecha.
        $fecha = $this->crearFecha($request->fecha_nacimiento);

        if ($fecha == null) {
            flash('
                <h4>Error en Ingreso de Datos</h4>
                <p>El formato de la fecha es incorrecto.</p>
            ')->error()->important();

            return back();
        }

        // Almacenamiento de la imagen.
        if ($request->file('imagen')) {
            $file = $request->file('imagen');

            $nombre = 'user_' . time() . '.' . $file->getClientOriginalExtension();

            $path = public_path() . '/img/users/';

            $file->move($path, $nombre);
        } else {
            $nombre = "user_default.jpg";
        }

        $user = new User();
        $user->rol_id = 4;
        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->cedula = $request->cedula;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->imagen = $nombre;
        $user->estado = 1;

        $user->save();


        $alumno = new Alumno;

        $alumno->user_id = $user->id;
        $alumno->anio_id = $request->anio_id;
        $alumno->fecha_nacimiento = $fecha;
        $alumno->ciudad_id = $request->ciudad_id;
        $alumno->genero = $request->genero;
        $alumno->direccion = $request->direccion;
        $alumno->telefono = $request->telefono;
        $alumno->responsable = $request->responsable;
        $alumno->celular = $request->celular;
        $alumno->estado = 1;
        $alumno->grado_aprobado = $request->if_grado;
        $alumno->tipo = 1;
        $alumno->save();

        flash('
            <h4>Registro de Estudiante</h4>
            <p>El estudiante <strong>' . $user->nombre . ' ' . $user->apellido . '</strong> se ha registrado correctamente.</p>
        ')->success()->important();

        return redirect()->route('alumnos.index');
    }

    /**
     * Muestra el usuario especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alumno = Alumno::find($id);

        $provincias = Provincia::orderBy('nombre', 'asc')->pluck('nombre', 'id');
        $ciudades = Ciudad::orderBy('nombre', 'asc')->get();
        $anios = Anio::where('activo', 1)->get();

        $user = User::select('nombre', 'apellido', 'email', 'cedula')
                ->where('id', $alumno->user_id)
                ->first();

        return view('alumnos.show')
                ->with('alumno', $alumno)
                ->with('user', $user)
                ->with('provincias', $provincias)
                ->with('ciudades', $ciudades);
    }

    /**
     * Muestra el formulario para editar el estudiante especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alumno = Alumno::find($id);

        $provincias = Provincia::orderBy('nombre', 'asc')->pluck('nombre', 'id');
        $ciudades = Ciudad::orderBy('nombre', 'asc')->get();
        $anios = Anio::where('activo', 1)->get();

        /* Obtener datos del usuario */
        $user = User:://where('estado', 1)
                //->orWhere('estado', 0)
                where('rol_id', 4)
                ->where('id', $alumno->user_id)
                ->first();

        return view('alumnos.edit')
            ->with('alumno', $alumno)
            ->with('user', $user)
            ->with('anios', $anios)
            ->with('provincias', $provincias)
            ->with('ciudades', $ciudades);
    }

    /**
     * Actualiza el usuario especificado en la base de datos.
     *
     * @param  \App\Http\Requests\AlumnoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $alumno = Alumno::find($id);
        $request->validate([
            'nombre' => 'bail|required|string|max:20',
            'apellido' => 'bail|required|string|max:20',
            'email' => 'bail|required|string|email|max:60|unique:users,email,'.$alumno->user_id,
            'cedula' => 'bail|required|string|min:10|max:10|unique:users,cedula,'.$alumno->user_id,
        ]);
        /* Obteniendo al usuario */
        $user = User::find($alumno->user_id);

        // Validación de la fecha.
        $fecha = $this->crearFecha($request->fecha_nacimiento);

        if ($fecha == null) {
            flash('
                <h4>Error en Ingreso de Datos</h4>
                <p>El formato de la fecha es incorrecto.</p>
            ')->error()->important();

            return back();
        }

        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->cedula = $request->cedula;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->estado = ($request->estado) ? $request->estado : 0 ;
        $user->save();
        $alumno->anio_id = $request->anio_id;
        $alumno->fecha_nacimiento = $fecha;
        $alumno->ciudad_id = $request->ciudad_id;
        $alumno->genero = $request->genero;
        $alumno->direccion = $request->direccion;
        $alumno->telefono = $request->telefono;
        $alumno->responsable = $request->responsable;
        $alumno->celular = $request->celular;
        $alumno->estado = ($request->estado) ? $request->estado : 0 ;
        $alumno->grado_aprobado = $request->if_grado;
        $alumno->tipo = 1;
        $alumno->save();

        flash('
            <h4>Edición de Estudiante</h4>
            <p>El estudiante <strong>' . $alumno->user->nombre . ' ' . $alumno->user->apellido . '</strong> se ha actualizado correctamente.</p>
        ')->success()->important();

        return redirect()->route('alumnos.index');
    }

    /**
     * Da de baja al usuario especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $alumno = Alumno::find($id);
        /* Obteniendo al usuario */
        $user = User::find($alumno->user_id);
        if (!$alumno || $alumno->estado == 0) {
            abort(404);
        }

        if($request->matriculado == 'yes') {

            $user->estado = 0;
            $user->save();
            $alumno->estado = 0;
            $alumno->save();
            flash('
                <h4>Baja de Estudiante</h4>
                <p>El estudiante <strong>' . $alumno->user->nombre . ' ' . $alumno->user->apellido . '</strong> se ha dado de baja correctamente.</p>
            ')->error()->important();

        } else {
            $nombre = $alumno->user->nombre .' '. $alumno->user->apellido;
            $alumno->delete();
            $user->delete();
            flash('
                <h4>Estudiante eliminado</h4>
                <p>El estudiante <strong>' . $alumno->user->nombre . ' ' . $alumno->user->apellido . '</strong> se eliminó correctamente.</p>
            ')->error()->important();
        }
        return redirect()->route('alumnos.index');
    }

    /**
     * Da a la fecha el formato correcto para almacenarla en la base de datos y
     * verifica que sea una fecha valida.
     *
     * @param  string  $valor
     * @return string
     */
    public function crearFecha($valor)
    {
        $f = explode('/', $valor); // 0:día, 1:mes, 2:año

        $date = $f[2] . '-' . $f[1] . '-' . $f[0];

        try {
            $fecha = Carbon::parse($date)->format('Y-m-d');
            return $fecha;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Muestra el récord de notas del alumno.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function record($id)
    {
        return view('alumnos.record');
    }
}
