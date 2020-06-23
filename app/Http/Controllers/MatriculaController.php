<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use App\Nivel;
use App\Alumno;
use App\Anio;
use App\Grado;
use App\Matricula;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as Collection;

class MatriculaController extends Controller
{
    /**
     * Muestra una lista de alumnos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));

            $anios = Anio::orderBy('id', 'desc')->get();

            $anio="";


            // Lista de grados para select de búsqueda.
            $grados = DB::table('grados')
                ->join('anios', 'grados.anio_id', 'anios.id')
                ->select('grados.*')
                ->where(['anios.estado' => 1])
                ->orderBy('grados.id', 'desc')
                ->get();

            // En caso de estar vacío el select de grados.
            $grado = "";

            if ($request->get('searchGrado') == null && $request->get('searchAnio') == null) {

                // Cuando no se ha seleccionado ningún grado y anio
                $matriculas = DB::table('matriculas')
                    ->join('alumnos', 'matriculas.alumno_id', 'alumnos.id')
                    ->join('users', 'users.id', 'alumnos.user_id')
                    ->join('grados', 'matriculas.grado_id', 'grados.id')
                    ->join('anios', 'grados.anio_id', 'anios.id')
                    ->select('matriculas.*', 'users.nombre', 'users.apellido', 'users.cedula', 
                    'grados.codigo', 'grados.seccion', 'anios.editable', 'anios.activo', 'anios.numero')
                    ->where([
                        ['anios.activo', 1],
                        ['users.cedula', 'like', '%' . $query . '%']
                    ])
                    ->orWhere([
                        ['anios.activo', 1],
                        ['users.apellido', 'like', '%' . $query . '%']
                    ])
                    
                    /* ->orWhere([
                        ['anios.editable', 0],
                        ['users.cedula', 'like', '%' . $query . '%']
                    ]) */
                    ->orderBy('grados.codigo', 'asc')
                    ->orderBy('users.apellido', 'asc')
                    ->orderBy('users.nombre', 'asc')
                    ->paginate(25);
            } else {
                
                
                // Cuando se ha seleccionado un grado.
                $grado = trim((string)$request->get('searchGrado'));
                $anio = trim((string)$request->get('searchAnio'));

                $matriculas = DB::table('matriculas')
                ->join('alumnos', 'matriculas.alumno_id', 'alumnos.id')
                ->join('users', 'users.id', 'alumnos.user_id')
                ->join('grados', 'matriculas.grado_id', 'grados.id')
                ->join('anios', 'grados.anio_id', 'anios.id')
                ->join('niveles', 'grados.nivel_id', 'niveles.id')
                ->select('matriculas.id', 'matriculas.created_at', 'matriculas.desercion', 
                'matriculas.estado_alumno', 'matriculas.condicion','users.nombre', 
                'users.apellido', 'users.cedula', 'grados.codigo', 'anios.editable', 
                'anios.activo', 'anios.numero')
                ->where([
                    ['grados.id', $grado],
                    ['users.cedula', 'like', '%' . $query . '%'],
                ])
                ->orWhere([
                    ['anios.id', $anio],
                    ['users.cedula', 'like', '%' . $query . '%'],
                ])
                ->orderBy('grados.codigo', 'asc')
                ->orderBy('users.apellido', 'asc')
                ->orderBy('users.nombre', 'asc')
                ->paginate(25);

            }
        }

        return view('matriculas.index')
            ->with('grados', $grados)
            ->with('matriculas', $matriculas)
            ->with('searchText', $query)
            ->with('grado', $grado)
            ->with('anios', $anios)
            ->with('anio', $anio);
    }

    /**
     * Muestra el formulario para crear una nueva matrícula.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grados = DB::table('grados')
        ->join('anios', 'grados.anio_id', 'anios.id')
        ->join('niveles', 'grados.nivel_id', 'niveles.id')
        ->select('grados.id','grados.seccion', 'grados.estado', 'grados.codigo', 'anios.numero', 
        'anios.activo', 'niveles.nombre')
        ->where('grados.estado', 1)
        ->where('anios.activo', 1)
        ->orderBy('niveles.nombre', 'asc')
        ->orderBy('grados.seccion', 'asc')
        ->get();
            //->pluck('grados.codigo', 'grados.id');
        
        // $alumnos = Alumno::orderBy('apellido', 'asc')->orderBy('nombre', 'asc')->get();;//->pluck('nombre_and_apellido', 'id');
        
        // Obteniendo el id del año activo
        $anio = DB::table('anios')
        ->select('id')
        ->where('activo', 1)
        ->first();


        /* Obtencion de los alumnos */
        $alumnos = DB::table('alumnos as a')
        ->join('users as u', 'a.user_id', 'u.id')
        ->select('a.id', 'u.nombre', 'u.apellido', 'u.cedula', 'a.estado')
        ->where(['u.rol_id' => 4, 'a.estado' => 1])
        ->orderBy('u.apellido', 'asc')
        ->orderBy('u.nombre', 'asc')
        ->get();

        // Buscar a los alumnos que no estan matriculados en dicho año activo
        $tmpAlumnos = Collection::make();
        foreach ($alumnos as $value) {
            $show = true;
            if (DB::table('matriculas')->where('alumno_id', $value->id)->exists()) {
                $matricula = Matricula::select('grado_id', 'estado_alumno')
                ->where('alumno_id', $value->id)
                ->orderBy('created_at','DESC')
                ->first();


                $grado = DB::table('grados')
                ->select('codigo')
                ->where('id', $matricula->grado_id)
                ->first();
                // Obteniendo codigo del grado
                $codigo = explode('-', $grado->codigo);
                $codigo = strtolower($codigo[0]);
                if ($codigo == 'tercero bgu' && $matricula->estado_alumno == 'promovido') {
                    $show = false;
                }
            }
            if (!DB::table('matriculas')->where('alumno_id', $value->id)->where('anio_id', $anio->id)->exists() && $show) {
                $tmpAlumnos->push($value);
            }
            //if (!DB::table('matriculas')->where('alumno_id', $value->id)->where('anio_id', $anio->id)->exists()) {
            //    $tmpAlumnos->push($value);
            //}
        }

        $anios= DB::table('anios')->where('activo', 1)->get();
                
        return view('matriculas.create')
            ->with('grados', $grados)
            ->with('alumnos', $tmpAlumnos)
            ->with('anios', $anios);
    }

    /**
     * Almacena una matrícula recién creada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validación general.
        $this->validate(request(), [
            'alumno_id' => 'required',
            'grado_id'  => 'required',
            'anio_id'   => 'required',
        ]);
        
        $matricula = new Matricula($request->all());
        $matricula->desercion = null;
        $matricula->condicion = 1;
        // Validando que solo haya una matrícula por año para cada alumno.
        $grados = Grado::where('anio_id', $matricula->grado->anio_id)->get();

        foreach ($grados as $grado) {
            $validacion = Matricula::where('alumno_id', $matricula->alumno_id)
                ->where('grado_id', $grado->id)
                ->first();

            if ($validacion) {
                flash('
                    <h4>Error de Matrícula</h4>
                    <p>No se ha registrado la matrícula de <strong class="text text-danger">' . $matricula->alumno->user->nombre . ' ' . $matricula->alumno->user->apellido . '</strong> porque ya tiene un registro de matrícula en el período <strong class="text text-danger">' . $grado->anio->numero . '.</strong></p>
                ')->warning()->important();

                return back();
            }
        }

        $matricula->save();
        //dd($matricula);
        flash('
            <h4>Registro de Matrícula</h4>
            <p>La matrícula de <strong>' . $matricula->alumno->user->nombre . ' ' . $matricula->alumno->user->apellido . '</strong> en el grado <strong>' . $matricula->grado->codigo . '</strong> se ha registrado correctamente.</p>
        ')->success()->important();

        return redirect()->route('matriculas.index');
    }

    /**
     * Muestra el formulario para editar la matrícula especificada.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $matricula = Matricula::find($id);
        
        $users = Matricula::find($id);

        $grados = DB::table('grados')
        ->join('anios', 'grados.anio_id', 'anios.id')
        ->join('niveles', 'grados.nivel_id', 'niveles.id')
        ->select('grados.id','grados.seccion', 'grados.estado', 'grados.codigo', 'anios.numero', 
        'anios.activo', 'niveles.nombre')
        ->where('grados.estado', 1)
        ->where('anios.activo', 1)
        ->orderBy('niveles.nombre', 'asc')
        ->orderBy('grados.seccion', 'asc')
        ->get();

        //Consulta para mostrar o no mostrar el checkbox RETIRADO en le formulario de matrícula
        $notas = DB::table('notas_alumno')
        ->where('grado_id', $matricula->grado_id)
        ->where('alumno_id', $matricula->alumno_id)
        ->exists(); 


        if (!$matricula) {
            abort(404);
        } elseif ($matricula->grado->anio->editable == 0) {
            abort(403);
        }

        if ($matricula->desercion == null) {
            $desercion = 0;
        } else {
            $desercion = 1;
            $condicion = 0;
        }

        $alumnos = Alumno::orderBy('id', 'asc')->get()->pluck('nombre_and_apellido', 'id');
        // dd($matricula->alumno->user_id);
        return view('matriculas.edit')->with('alumnos', $alumnos)
            ->with('grados', $grados)
            ->with('notas', $notas)
            ->with('matricula', $matricula)
            ->with('desercion', $desercion);
    }

    /**
     * Actualiza la matrícula especificada en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $matricula = Matricula::find($id);
        
        if (!$matricula) {
            abort(404);
        } elseif ($matricula->grado->anio->editable == 0) {
            abort(403);
        }

         $notas = DB::table('notas_alumno')
                ->where('grado_id', $matricula->grado_id)
                ->where('alumno_id', $matricula->alumno_id)
                ->exists(); 
        
        //$borrar = true;
        //dd($notas);
         if ($notas == false) {
            $matricula -> grado_id = $request->get('grado_id');
        
        
            
            
            $matricula->save();

            flash('
                <h4>ACTUALIZACIÓN</h4>
                <p>La matrícula del estudiante <strong>' . $matricula->alumno->user->nombre . ' ' . $matricula->alumno->user->apellido . '</strong> se ha editado correctamente.</p>
            ')->success()->important();
        }else{
            if ($request->desercion == 1) {
                $matricula->desercion = Carbon::parse(Carbon::now())->format('Y-m-d');
                $matricula->condicion = 0;
            } else {
                $matricula->desercion = null;
                $matricula->condicion = 1;
            }
            $matricula->save();
            flash('
                <h4>ACTUALIZACIÓN</h4>
                <p>La matrícula del estudiante <strong>' . $matricula->alumno->user->nombre . ' ' . $matricula->alumno->user->apellido . '</strong> se ha editado correctamente.</p>
            ')->success()->important();
            
        }
        return redirect()->route('matriculas.index');
    }

    /**
     * Elimina a la matrícula especificada.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $matricula = Matricula::find($id);

        if (!$matricula) {
            abort(404);
        } elseif ($matricula->grado->anio->editable == 0) {
            abort(403);
        }

        // Eliminando solo matrículas con notas igual a cero o matriculas de estudiantes retirados
        $notas = DB::table('notas_alumno')
                ->where('grado_id', $matricula->grado_id)
                ->where('alumno_id', $matricula->alumno_id)
                ->get();
        
        $borrar = true;
        //dd($notas);
        if ($notas->count() > 0) {
            $borrar = false;
        }
        
        if ($borrar) {
            
            // Eliminando todas las notas relacionadas.
            if (count($notas) > 0) {
                //dd($notas);
                DB::table('notas_alumno')
                    ->where('grado_id', $matricula->grado_id)
                    ->where('alumno_id', $matricula->alumno_id)
                    ->delete();
            }

            $matricula->delete();

            flash('
                <h4>Eliminación de Matrícula</h4>
                <p>La matrícula de <strong>' . $matricula->alumno->user->nombre . ' ' . $matricula->alumno->user->apellido . '</strong> en el grado <strong>' . $matricula->grado->codigo . '</strong> se ha eliminado correctamente.</p>
            ')->error()->important();
        } else {
            /* $matricula->condicion = 0;
            $matricula->desercion = Carbon::parse(Carbon::now())->format('Y-m-d');
            $matricula->save(); */
            flash('
                <h4>ATENCIÓN!</h4>
                <p>La matrícula de <strong>' . $matricula->alumno->user->nombre . ' ' 
                . $matricula->alumno->user->apellido . '</strong> en el grado <strong>' 
                . $matricula->grado->codigo . '</strong> no se puede eliminar porque registra notas en 
                el período actual o un período anterior.</p>
            ')->warning()->important();
        }


        return redirect()->route('matriculas.index');
    }

    // ajax show grades for estudents id
    /* Funcion de prueba para saber si un alumno aprobo el grado */
    public function getGrado(Request $request)
    {
        $output = array();
        if($request->ajax()){
            $matricula = Matricula::select('grado_id', 'estado_alumno')
                        ->where('alumno_id', $request->alumno_id)
                        ->orderBy('created_at','DESC')
                        ->first();
            //if ($matricula) {
            $tmp = DB::table('alumnos')
            ->select('grado_aprobado')
            ->where('id', $request->alumno_id)
            ->first();
            if ($tmp->grado_aprobado == null && $matricula) {
                $output['ifestado'] = false;
                // Obteniendo el grado del alumno
                $grado = DB::table('grados')
                        ->select('nivel_id', 'codigo')
                        ->where('id', $matricula->grado_id)
                        ->first();
                /* $nivel = DB::table('niveles')
                        ->select('nombre')
                        ->where('id', $grado->nivel_id)
                        ->first(); */
                $output['grado'] = $grado->codigo; //$nivel->nombre.' '.$grado->codigo
                $output['estado_alumno'] = ($matricula->estado_alumno == 'promovido') ? 'aprobado' : 'reprobado' ;
            } else {
                $grado_aprobado = DB::table('alumnos')
                                ->select('grado_aprobado')
                                ->where('id', $request->alumno_id)
                                ->first();
                switch ($grado_aprobado->grado_aprobado) {
                    case 'epf':
                        $output['grado_aprob'] = 'Educación Primaria Finalizada';
                        break;
                    case '8':
                        $output['grado_aprob'] = 'Octavo';
                        break;
                    case '9':
                        $output['grado_aprob'] = 'Noveno';
                        break;
                    case '10':
                        $output['grado_aprob'] = 'Décimo';
                        break;
                    case '11':
                        $output['grado_aprob'] = 'Primero BGU';
                        break;
                    case '12':
                        $output['grado_aprob'] = 'Segundo BGU';
                        break;
                    default:
                        $output['grado_aprob'] = null;
                        break;
                }
                
                $output['ifestado'] = ($request->alumno_id) ? true : false;
            }
            
            
        }
        
        // return Response($output);
        return response()->json($output);
    }
}
