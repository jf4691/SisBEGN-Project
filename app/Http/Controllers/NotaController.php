<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use App\Anio;
use App\Docente;
use App\Grado;
use App\Materia;
use App\Alumno;
//use App\Administrativo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as Collection;

class NotaController extends Controller
{
    /**
     * Muestra una lista de grados y materias impartidas en el año.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Obteniendo año del cual se tomaran los registros.
        $anio = Anio::where('activo', 1)->first();

        if ($request->anio_search) {
            $anio = Anio::find($request->anio_search);
        }
        if (!$anio) {
            flash('
                <h4>Ningun año escolar registrado</h4>
            ')->error()->important();
            return back();
        }
        // Para select que contiene los años.
        //$anios = Anio::orderBy('id', 'desc')->get();
        $anios = Anio::where('estado', 1)->orderBy('numero', 'asc')->pluck('numero', 'id');

        /*
         * Obteniendo grados donde se es orientador y materias que se imparten.
         * Los usuarios con rol de administrador o secretaria pueden ver todos los registros.
         */

        // Obtenemos lista de las materias y los id de los grados
        $materias = array();
        $grados_ids = array();
        

        if (\Auth::user()->docen()) {

            $docente = Docente::where('user_id', \Auth::user()->id)->first();
            //dd($docente->toArray());
            if ($docente == null) {
                flash('
                    <h4>ACCESO DENEGADO</h4>
                    <p>Aun no se ha registrado su información complementaria como docente. Por favor informar al Administrador.</p>
                ')->error()->important();
                return back();
            }
            /*Consulta para traer los grados los cuales un docente es dirigente
            y mostrar en la seccion "Reporte de notas"*/
            $grados = Grado::where('estado', 1)
                ->where('anio_id', $anio->id)
                ->where('docente_id', $docente->id)
                ->orderBy('codigo', 'asc')
                ->get();
            
            /*  Obteniedo los datos de las materias de los docentes correspondientes
                Controlando el año academico activo */
            if (DB::table('grado_materia')->where('docente_id', $docente->id)->exists()) {
                $m2 = DB::table('materias')
                    ->join('grado_materia', 'materias.id', 'grado_materia.materia_id')
                    ->select('materias.*', 'grado_materia.id as gra_mat', 'grado_materia.grado_id as grado_id')
                    ->where('grado_materia.docente_id', $docente->id)
                    ->orderBy('nombre', 'asc')
                    ->get();
                if (count($m2) > 0) {
                    foreach ($m2 as $item) {
                        $x = Grado::select('codigo')
                                    ->where('id', $item->grado_id)
                                    ->where('anio_id', $anio->id)
                                    ->get()
                                    ->first();
                        if ($x != null) {
                            $item->grado = $x->codigo;
                            array_push($grados_ids, $item->grado_id);
                            array_push($materias, $item);
                        }
                        
                    }
                    $grados_ids = array_unique($grados_ids);
                }
            }
            // dd($materias);
        } elseif(\Auth::user()->estud()) {
            /* Notas del alumno */
            $alumno = Alumno::where('user_id', \Auth::user()->id)->first();
            
            /* Matricula del alumno */
            $matricula = DB::table('matriculas')
                        ->select('grado_id')
                        ->where('alumno_id', $alumno->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
            /* Grado del alumno */
            $grados = Collection::make();
            foreach ($matricula as $item) {
                $gr = Grado:://where('estado', 1)
                    where('id', $item->grado_id)
                    ->where('anio_id', $anio->id)
                    ->orderBy('codigo', 'asc')
                    ->first();
                if ($gr) {
                    $grados->push($gr);
                }
            }
            // dd($grados);
        } else { //else en caso no sea ni usuario docente o estudiante
            /* $administrativo = Administrativo::where('user_id', \Auth::user()->id)->first();
            if ($administrativo == null) {
                flash('
                    <h4>ACCESO DENEGADO</h4>
                    <p>Aun no se ha registrado su información complementaria como administrativo. Por favor informar al Administrador.</p>
                ')->error()->important();
                return back();
            } */

            $grados = Grado:://where('estado', 1)
                where('anio_id', $anio->id)
                ->orderBy('codigo', 'asc')
                ->get();

            if (count($grados) > 0) {

                foreach ($grados as $grado) {

                    $m = DB::table('materias')
                        ->join('grado_materia', 'materias.id', 'grado_materia.materia_id')
                        ->join('grados', 'grado_materia.grado_id', 'grados.id')
                        ->select('materias.*', 'grados.codigo as grado', 'grado_materia.id as gra_mat')
                        ->where('grado_materia.grado_id', $grado->id)
                        ->orderBy('nombre', 'asc')
                        ->get();

                    if (count($m) > 0) {
                        array_push($materias, $m);
                        // $materias->push($m);
                    }
                }
            }
        }

        return view('notas.index')
            ->with('anio', $anio)
            ->with('anios', $anios)
            ->with('grados', $grados)
            ->with('materias', $materias)
            ->with('grados_ids', $grados_ids);
    }

    /**
     * Muestra el cuadro de notas para edición.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $gra_mat = DB::table('grado_materia')
            ->select('grado_id', 'materia_id', 'docente_id')
            ->where('id', $id)
            ->first();

        if (!$gra_mat || $gra_mat->docente_id != \Auth::user()->docentes[0]->id) {
            abort(404);
        }

        // $grado = Grado::find($gra_mat->grado_id);

        $grado = Grado::with(['matriculas' => function($x){
                    $x->where('condicion', 1);
                }])
                ->where('id', $gra_mat->grado_id)
                ->first();

        $materia = Materia::find($gra_mat->materia_id);

        // Obteniendo las matriculas de este grado (alumnos registrados en el grado respectivos)
        $matriculas = $grado->matriculas;
        // lista de usuarios para ordenarlos
        $tmp_alumnos = array();

        foreach ($matriculas as $matricula) {

            $est = DB::table('alumnos')
                    ->select('user_id')
                    ->where('id', $matricula->alumno_id)
                    ->get()
                    ->first();

            $user = User::select('id', 'nombre', 'apellido')
                    ->where('id', $est->user_id)
                    ->first();
            $user->id = $matricula->alumno_id;
            
            $matricula->alumno = $user;

            // push a la lista de estudiantes para ordenarlos
            $tmp_alumnos[$user->id] = $user->apellido;

            $notas = new \stdClass();
            // Verificar si el estudiante ya tiene registrado alguna nota
            if (DB::table('notas_alumno')->where('grado_id', $matricula->grado_id)->where('materia_id', $gra_mat->materia_id)->where('alumno_id', $matricula->alumno_id)->exists()) {
                // Nuevo registro de notas
                $notas = DB::table('notas_alumno')
                            ->where('grado_id', $matricula->grado_id)
                            ->where('materia_id', $gra_mat->materia_id)
                            ->where('alumno_id', $matricula->alumno_id)
                            ->first();
                $notas->promedio = round(($notas->parcial_1 + $notas->parcial_2)/2, 2);

            } else {
                // Valor por defecto de las notas del alumno
                $notas->parcial_1 = 0;
                $notas->parcial_2 = null;
                $notas->promedio = 0;
                $notas->supletorio = null;
                $notas->nota = 0;
                $notas->estado = '---';
            }
            $matricula->notas = $notas;
            // dd($matricula);

        }
        // Ordenar las matriculas segun el apellido
        asort($tmp_alumnos);
        $matriculas_ordenado = $this->matriculaOrden($matriculas, $tmp_alumnos);
        // dd($matriculas_ordenado);
        // Nuevo retorno de datos con la nueva forma de evaluacion por parciales
        return view('notas.edit')
            ->with('grado', $grado)
            ->with('materia', $materia)
            ->with('gra_mat', $id)
            ->with('matriculas', $matriculas_ordenado);
            // ->with('registros', $gra_mat->registros);
    }

    /**
     * Actualiza las notas especificadas en la base de datos.
     *
     * @param  \App\Http\Requests  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // obtencion del numero de alumnos
        // y obtencion de los ids del grado y la materia
        $n = count($request->parcial_1);
        $grado_mat = DB::table('grado_materia')
                    ->select('grado_id', 'materia_id')
                    ->where('id', $request->gra_mat)
                    ->get()
                    ->first();

        $tmpGrados = Grado::select('registros')
            ->where('id', $grado_mat->grado_id)
            ->first();
        // Si esta permitido actualizar las notas
        if ($tmpGrados->registros != 'ninguno') {
            for ($i=0; $i < $n; $i++) { 
            
                /* Obtener los valores actuales de las notas */
                if (DB::table('notas_alumno')->where('grado_id', $grado_mat->grado_id)->where('materia_id', $grado_mat->materia_id)->where('alumno_id', key($request->parcial_1[$i]))->exists()) {
                    $tmpNotas = DB::table('notas_alumno')
                        ->select('parcial_1', 'parcial_2', 'supletorio')
                        ->where('grado_id', $grado_mat->grado_id)
                        ->where('materia_id', $grado_mat->materia_id)
                        ->where('alumno_id', key($request->parcial_1[$i]))
                        ->first();
                    $parcial_1 = $tmpNotas->parcial_1;
                    $parcial_2 = $tmpNotas->parcial_2;
                    $tmpSupletorio = $tmpNotas->supletorio;
                } else {
                    $parcial_1 = 0;
                    $parcial_2 = null;
                    $tmpSupletorio = null;
                }
                /* Calculo del estado y la nota final del alumno */
                $estado = 'Suspenso';
                $nota_final = 0;
                $supletorio = ($tmpGrados->registros == 'supletorio') ? current($request->supletorio[$i]) : $tmpSupletorio ;
                // $supletorio = current($request->supletorio[$i]);
                
                if ($tmpGrados->registros == 'parcial_1') {
                    $promedio = ( current($request->parcial_1[$i]) + $parcial_2 ) / 2;
                } elseif ($tmpGrados->registros == 'parcial_2') {
                    $promedio = ( $parcial_1 + current($request->parcial_2[$i]) ) / 2;
                } else {
                    $promedio = ( $parcial_1 + $parcial_2 ) / 2;
                }
                // $promedio = ( current($request->parcial_1[$i]) + current($request->parcial_2[$i]) ) / 2;
                $promedio = round($promedio, 2);
                // Si esta habilidato el segundo parcial
                // if ($tmpGrados->registros == 'parcial_2' || $tmpGrados->registros == 'supletorio') {
                if (current($request->parcial_2[$i]) != null) {
                    if ($promedio != 0) {
                        switch ($promedio) {
                            case ($promedio >= 7):
                                $estado = 'Aprobado';
                                $nota_final = $promedio;
                                $supletorio = null;
                                break;
                            case ($promedio >= 4 && $promedio < 7):
                                $estado = 'Suspenso';
                                $nota_final = $promedio;
                                break;
                            default:
                                $estado = 'Reprobado';
                                $nota_final = $promedio;
                                $supletorio = null;
                                break;
                        }
                    } else {
                        $estado = 'Reprobado';
                        $nota_final = 0;
                        $supletorio = null;
                    }
                    if ($supletorio != null) {
                        $x = current($request->supletorio[$i]);
                        if ($x >= 7) {
                            $estado = 'Aprobado';
                            $nota_final = 7;
                        } else {
                            $estado = 'Reprobado';
                            $nota_final = $promedio;
                            // $nota_final = ($promedio > $x) ? $promedio : $x;
                        }
                    }
                }
                // solo para el primer parcial
                else {
                    $nota_final = 0;
                    $estado = '---';
                }
                // Verificar si el alumno ya tiene registrado alguna nota
                if (DB::table('notas_alumno')->where('grado_id', $grado_mat->grado_id)->where('materia_id', $grado_mat->materia_id)->where('alumno_id', key($request->parcial_1[$i]))->exists()) {
                    // actualizar registro de notas
                    $updateNotas = DB::table('notas_alumno')
                        ->select('id')
                        ->where('grado_id', $grado_mat->grado_id)
                        ->where('materia_id', $grado_mat->materia_id)
                        ->where('alumno_id', key($request->parcial_1[$i]))
                        ->first();
                    switch ($tmpGrados->registros) {
                        case 'parcial_1':
                            DB::update('update notas_alumno set parcial_1 = ?, nota = ?, estado = ? where id = ?', [current($request->parcial_1[$i]), $nota_final, $estado, $updateNotas->id]);
                            break;
                        case 'parcial_2':
                            DB::update('update notas_alumno set parcial_2 = ?, nota = ?, estado = ? where id = ?', [current($request->parcial_2[$i]), $nota_final, $estado, $updateNotas->id]);
                            break;
                        case 'supletorio':
                            DB::update('update notas_alumno set supletorio = ?, nota = ?, estado = ? where id = ?', [$supletorio, $nota_final, $estado, $updateNotas->id]);
                            break;
                        default:
                            break;
                    }
                } else {
                    // Insertar un nuevo registro en las notas
                    DB::table('notas_alumno')
                            ->insert([
                                'grado_id' => $grado_mat->grado_id,
                                'materia_id' => $grado_mat->materia_id,
                                'alumno_id' => key($request->parcial_1[$i]),
                                'parcial_1' => current($request->parcial_1[$i]),
                                'parcial_2' => current($request->parcial_2[$i]),
                                'supletorio' => $supletorio,
                                'nota' => $nota_final,
                                'estado' => $estado
                            ]);
                }
    
                if (current($request->parcial_2[$i]) != null) {
                    // Registrar si el alumno aprobo el grado en la matricula correspondiente
                    // Obteniendo la cantidad de materias del grado en curso
                    $numMaterias = DB::table('grado_materia')
                        ->where('grado_id', $grado_mat->grado_id)
                        ->count();
                    
                    // Registrar si el alumno aprobo el grado en la matricula correspondiente
                    $estadoAlumno = DB::table('notas_alumno')
                                ->select('estado')
                                ->where('alumno_id', key($request->parcial_1[$i]))
                                ->where('grado_id', $grado_mat->grado_id)
                                ->get();
                    
                    // Contadores para los estados del alumno
                    $countAprobados = 0;
                    $countSuspenso = 0;
                    $countVacios = 0;
                    // Preguntar si el numero de materia coincide con el numero de notas del alumno
                    if ($numMaterias == count($estadoAlumno)) {
                        foreach ($estadoAlumno as $item) {
                            switch ($item->estado) {
                                case 'Aprobado':
                                    $countAprobados++;
                                    break;
                                case 'Suspenso':
                                    $countSuspenso++;
                                    break;
                                case '---':
                                    $countVacios++;
                                    break;
                                default:
                                    break;
                            }
                        }

                        // Determinar el estado del alumno
                        $estado_alumno = 'en_curso';
                        if ($countAprobados == count($estadoAlumno)) {
                            $estado_alumno = 'promovido';
                        } elseif ($countSuspenso > 0 || $countVacios > 0) {
                            $estado_alumno = 'en_curso';
                        } else {
                            $estado_alumno = 'reprobado';
                        }
                        
                        // if ($countVacios == 0) {
                            // Actualizar la matricula cuando todas las notas esten registradas
                            $up_matricula = DB::table('matriculas')
                                ->where('alumno_id', key($request->parcial_1[$i]))
                                ->where('grado_id', $grado_mat->grado_id)
                                ->update(['estado_alumno' => $estado_alumno]);
                            // Actualizar el grado aprobado del alumno nuevo
                            DB::table('alumnos')
                                ->where('id', key($request->parcial_1[$i]))
                                ->update(['grado_aprobado' => null]);
                        // }
                    }
                }
                // dd($tmpGrados);
    
            }

            flash('
                <h4>Actualización de Notas</h4>
                <p>Las notas se han actualizado correctamente.</p>
            ')->success()->important();
            
        } else {
            flash('
                <h4>Permiso denegado</h4>
                <p>No tiene autorización para el registro de notas <small>Consulte en secretaría</small>.</p>
            ')->error()->important();
        }

        return redirect()->back();
    }


    /**
     * Muestra el formulario para crear un reporte de notas.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createReporte($id)
    {
        $grado = Grado::find($id);

        if (!$grado) {
            abort(404);
        }

        return view('notas.create-reporte')->with('grado', $grado);
    }

    /**
     * Genera un reporte de notas para descargar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function downloadReporte(Request $request)
    {
        // dd($request);
        // Validando datos de entrada.
        $request_data = array(
            'grado_id'  => 'required',
            'tipo'      => 'required',
        );

        $this->validate(request(), $request_data);

        $NUMERO_DE_MATERIAS_APLAZADAS_PARA_SER_RETENIDO = 1;

        $NOTA_PARA_APLAZAR_MATERIA = 7;
        
        // Fecha de creación.
        $hoy = Carbon::now()->format('d/m/y');

        // Grado.
        $grado = Grado::find($request->grado_id);

        // Materias.
        $materias_sin_ordenar = $grado->materias;
        $materias = $materias_sin_ordenar->sortBy('nombre')->values()->all();

        $matriculas = $grado->matriculas;

        // lista de usuarios para ordenarlos
        $tmp_alumnos = array();
        
        foreach ($matriculas as $matricula) {
            $est = DB::table('alumnos')
                    ->select('user_id', 'genero')
                    ->where('id', $matricula->alumno_id)
                    ->get()
                    ->first();

            $user = User::select('id', 'nombre', 'apellido')
                    ->where('id', $est->user_id)
                    ->first();
            $user->user_id = $user->id;
            $user->id = $matricula->alumno_id;
            $user->genero = $est->genero;
            
            $matricula->alumno = $user;

            // push a la lista de slumnos para ordenarlos
            $tmp_alumnos[$user->id] = $user->apellido;

        }

        // Ordenar las matriculas segun el apellido
        asort($tmp_alumnos);
        $matriculas_ordenado = $this->matriculaOrden($matriculas, $tmp_alumnos);
        // dd($matriculas_ordenado);

        // Matriculas reales (incluido estudiantes retirados).
        $matriculas_reales = Collection::make();

        foreach ($matriculas_ordenado as $matricula) {
            // Validación de alumnos que se han retirado.
            if ($request->desercion == 1 || $matricula->desercion == null) {
                $matriculas_reales->push($matricula);
            }
        }
        // dd($matriculas_reales);
        /* Revisar si las matriculas estan vacias */
        if($matriculas_reales->count() == 0) {
            flash('
                <h4>Grado sin alumnos</h4>
                <p>Ningun alumno registrado en este grado.</p>
            ')->error()->important();
            return back();
        }
        
        // Notas de evaluaciones en todas las materias y de todos los alumnos.
        $notas_all = Collection::make();

        // Promedios de todas las materia.
        $promedio_materia_all = Collection::make();

        // Ver las notas de todos los alumnos y todas las materias
        $tmp_notas = array();
        // 
        foreach ($materias as $materia) {

            // Notas de todos los alumnos en la materia especificada.
            $notas = Collection::make();

            // Puntos de la materia especificada.
            $puntos = 0;
            
            foreach ($matriculas_reales as $matricula) {

                /* 
                // Ver las notas de todos los alumnos y todas las materias
                */
                if ($request->tipo == 'all') {
                    // Obtener las notas de un alumno en su respectiva materia
                    $tmp_notas[$matricula->alumno->id][$materia->id] = $this->notasAlumnoMateria($grado->id, $materia->id, $matricula->alumno->id);
                }
                
                // Calculo de la nota del alumno por tipo de reporte
                $nota_alumno = $this->notaAlumno($grado->id, $materia->id, $matricula->alumno->id, $request->tipo);
                
                $notas->push($nota_alumno);
                // $notas->push($promedio);

                $puntos += $nota_alumno;
                // $puntos += $promedio;                
            }

            $notas_all->push($notas);

            $promedio_materia_all->push(round($puntos / count($matriculas_reales), 2));
        }

        // Estadísticas del periodo.
        if ($request->tipo == 'Nf') {

            // Contadores de matrícula inicial.
            $matricula_inicial_femenina = 0;
            $matricula_inicial_masculina = 0;

            // Contadores de retirados (desertaron).
            $retiradas = 0;
            $retirados = 0;

            foreach ($matriculas as $matricula) {
                if ($matricula->alumno->genero == 'F') {
                    $matricula_inicial_femenina++;

                    if ($matricula->desercion != null) {
                        $retiradas++;
                    }
                } else {
                    $matricula_inicial_masculina++;

                    if ($matricula->desercion != null) {
                        $retirados++;
                    }
                }
            }

            // Contadores de matrícula final.
            $matricula_final_femenina = $matricula_inicial_femenina - $retiradas;
            $matricula_final_masculina = $matricula_inicial_masculina - $retirados;

            // Contadores de retenidos (aplazaron el grado).
            $retenidas = 0;
            $retenidos = 0;

            // Recorriendo por filas (alumnos).
            for ($i = 0; $i < count($matriculas_reales); $i++) {

                // Número de materias aplazadas por el alumno.
                $aplazadas = 0;
                
                // Recorriendo por columnas (notas del alumno especificado en cada materia).
                for ($j = 0; $j < count($materias); $j++) { 
                    if ($notas_all[$j][$i] < $NOTA_PARA_APLAZAR_MATERIA) {
                        $aplazadas++;
                    }
                }

                if ($aplazadas >= $NUMERO_DE_MATERIAS_APLAZADAS_PARA_SER_RETENIDO) {

                    if ($matriculas_reales[$i]->alumno->genero == 'F' && $matriculas_reales[$i]->desercion == null) {
                        $retenidas++;
                    } elseif ($matriculas_reales[$i]->desercion == null) {
                        $retenidos++;
                    }
                }
            }

            // Contadores de promovidos (pasaron el grado).
            $promovidas = $matricula_final_femenina - $retenidas;
            $promovidos = $matricula_final_masculina - $retenidos;

            $estadisticas = [
                'matricula_inicial_femenina'  => $matricula_inicial_femenina,
                'matricula_inicial_masculina' => $matricula_inicial_masculina,
                'retiradas'                   => $retiradas,
                'retirados'                   => $retirados,
                'matricula_final_femenina'    => $matricula_final_femenina,
                'matricula_final_masculina'   => $matricula_final_masculina,
                'promovidas'                  => $promovidas,
                'promovidos'                  => $promovidos,
                'retenidas'                   => $retenidas,
                'retenidos'                   => $retenidos,
            ];
        } else {
            $estadisticas = null;
        }

        return view('notas.reporte')
            ->with('grado', $grado)
            ->with('hoy', $hoy)
            ->with('materias', $materias)
            ->with('matriculas', $matriculas)
            ->with('notas', $notas_all)
            ->with('mostrar_conducta', $request->conducta)
            ->with('promedios', $promedio_materia_all)
            ->with('tipo', $request->tipo)
            ->with('estadisticas', $estadisticas)
            ->with('matriculas_reales', $matriculas_reales)
            ->with('tmp_notas', $tmp_notas);
    }

    /**
     * Reporte de notas del alumno
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function alumnoReporte(Request $request, $id)
    {
        // Fecha de creación.
        $hoy = Carbon::now()->format('d/m/y');

        // Grado.
        $grado = Grado::find($id);

        // Materias.
        $materias_sin_ordenar = $grado->materias;
        $materias = $materias_sin_ordenar->sortBy('nombre')->values()->all();
        
        // Alumno
        $alumno = DB::table('alumnos')
                ->where('user_id', \Auth::user()->id)
                ->first();
        $alumno->nombre = \Auth::user()->nombre;
        $alumno->apellido = \Auth::user()->apellido;

        // Matricula
        $matricula = DB::table('matriculas')
                    ->select('*')
                    ->where('alumno_id', $alumno->id)
                    ->where('grado_id', $id)
                    ->get();

        // Notas de evaluaciones en todas las materias y de todos los alumnos.

        foreach ($materias as $materia) {
            
            // Notas del alumno en la materia especificada.
            $notas = $this->notasAlumnoMateria($grado->id, $materia->id, $alumno->id);

            $materia->notas = $notas;
        }
        
        return view('notas.reporte-alumno')
            ->with('grado', $grado)
            ->with('hoy', $hoy)
            ->with('materias', $materias);
    }

    /**
     * Retorna la nota de un alumno en una materia y tipo específico.
     *
     * @param  int  $grado
     * @param  int  $materia
     * @param  int  $alumno
     * @param  string  $tipo
     * @return int
     */
    public function notaAlumno($grado, $materia, $alumno, $tipo) {

        // echo ($grado.'-'.$materia.'-'.$alumno.'-'.$tipo);
        $nota = 0;
        /* Obteniendo la nota segun el tipo del alumno */
        switch ($tipo) {
            case 'P1':
                $tipo = 'parcial_1';
                break;
            case 'P2':
                $tipo = 'parcial_2';
                break;
            default:
                $tipo = 'nota';
                break;
        }
        // Nota del alumno
        
        if (DB::table('notas_alumno')->where('grado_id', $grado)->where('materia_id', $materia)->where('alumno_id', $alumno)->exists()) {
            $nota = DB::table('notas_alumno')
            ->select($tipo)
            ->where('grado_id', $grado)
            ->where('materia_id', $materia)
            ->where('alumno_id', $alumno)
            ->first()->$tipo;
        }
        
        return $nota;
    }

    /**
     * Retorna la nota de un alumno en una materia y tipo específico.
     *
     * @param  int  $grado
     * @param  int  $materia
     * @param  int  $alumno
     * @return array
     */
    public function notasAlumnoMateria($grado, $materia, $alumno) {

        // echo ($grado.'-'.$materia.'-'.$alumno);
        $notas = array();
        /* Evaluaciones del alumno */
        // Nota del alumno
        $nota_s = DB::table('notas_alumno')
            ->where('grado_id', $grado)
            ->where('materia_id', $materia)
            ->where('alumno_id', $alumno)
            ->first();

        if ($nota_s) {
            $notas['p1'] = $nota_s->parcial_1;
            $notas['p2'] = $nota_s->parcial_2;
            $notas['prom'] = round(($nota_s->parcial_1 + $nota_s->parcial_2) / 2, 2);
            $notas['sp'] = $nota_s->supletorio;
            $notas['estado'] = $nota_s->estado;
            $notas['nf'] = $nota_s->nota;
        } else {
            $notas['p1'] = 0;
            $notas['p2'] = 0;
            $notas['prom'] = 0;
            $notas['sp'] = 0;
            $notas['estado'] = '---';
            $notas['nf'] = 0;
        }

        return $notas;
    }
    /**
     * Retorna el promedio de un alumno en una materia y trimestre específico.
     *
     * @param  int  $grado
     * @param  int  $materia
     * @param  int  $alumno
     * @param  int  $trimestre
     * @return float
     */
    /* public function promediarTrimestre($grado, $materia, $alumno, $trimestre)
    {
        // Evaluaciones del trimestre.
        $evaluaciones = Evaluacion::where('tipo', 'EXA')
            ->where('grado_id', $grado)
            ->where('materia_id', $materia)
            ->where('trimestre', $trimestre)
            ->orWhere('tipo', 'ACT')
            ->where('grado_id', $grado)
            ->where('materia_id', $materia)
            ->where('trimestre', $trimestre)
            ->get();

        // Promedio del trimestre.
        $promedio = 0;

        // Si hay evaluaciones.
        if (count($evaluaciones) > 0) {
            foreach ($evaluaciones as $evaluacion) {
                $nota = DB::table('alumno_evaluacion')
                    ->where('alumno_id', $alumno)
                    ->where('evaluacion_id', $evaluacion->id)
                    ->first();

                // Si hay registro.
                if ($nota) {
                    $promedio += round($nota->nota * $evaluacion->porcentaje, 2);
                } else {
                    $promedio += 0;
                }
            }
        }

        // Evaluación de recuperación.
        $recuperacion = Evaluacion::where('tipo', 'REC')
            ->where('grado_id', $grado)
            ->where('materia_id', $materia)
            ->where('trimestre', $trimestre)
            ->first();

        // Si hay evaluación de recuperación.
        if ($recuperacion) {
            $nota_recuperacion = DB::table('alumno_evaluacion')
                ->where('alumno_id', $alumno)
                ->where('evaluacion_id', $recuperacion->id)
                ->first();

            if ($nota_recuperacion) {
                $promedio += round($nota_recuperacion->nota, 2);
            }
        } else {
            $promedio += 0;
        }

        return $promedio;
    } */

    /**
     * Retorna el promedio de nota de conducta de un alumno en un trimestre
     * específico.
     *
     * @param  int  $grado
     * @param  int  $valor
     * @param  int  $alumno
     * @param  int  $trimestre
     * @return int
     */
    /* public function promediarTrimestreConducta($grado, $valor, $alumno, $trimestre)
    {
        $nota_c = DB::table('alumno_valor')
            ->where('alumno_id', $alumno)
            ->where('valor_id', $valor)
            ->where('grado_id', $grado)
            ->where('trimestre', $trimestre)
            ->first();

        if ($nota_c) {
            switch ($nota_c->nota) {
                case 'E':
                    $nota = 10;
                    break;

                case 'MB':
                    $nota = 8;
                    break;

                case 'B':
                    $nota = 6;
                    break;
                
                case 'R':
                    $nota = 4;
                    break;

                case 'M':
                    $nota = 2;
                    break;

                default:
                    $nota = 0;
                    break;
            }
        } else {
            $nota = 0;
        }

        return $nota;
    } */

    /**
     * Retorna la nota promedio de conducta de un alumno como cadena de caracteres
     * según corresponda en la escala: E, MB, B, R, M.
     *
     * @param  float  $nota
     * @return string
     */
    /* public function traducirNotaConducta($nota)
    {
        switch ($nota) {
            case $nota > 8:
                $n = 'E';
                break;

            case $nota > 6:
                $n = 'MB';
                break;

            case $nota > 4:
                $n = 'B';
                break;
            
            case $nota > 2:
                $n = 'R';
                break;

            case $nota <= 2:
                $n = 'M';
                break;
        }

        return $n;
    } */

    /**
     * Retorna la lista de matriculas ordenadop por apellidos
     *
     * @param  collection  $matriculas
     * @param  array  $alm_orden
     * @return 
     */
    public function matriculaOrden($matriculas, $alm_orden)
    {
        $matriculas_ordenadas = Collection::make();
        foreach ($alm_orden as $key => $value) {
            foreach ($matriculas as $row) {
                if ($row->alumno->id == $key) {
                    $matriculas_ordenadas->push($row);
                }
            }
        }
        return $matriculas_ordenadas;
    }
}
