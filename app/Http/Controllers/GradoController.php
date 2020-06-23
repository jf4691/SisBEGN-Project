<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Anio;
use App\Docente;
use App\Grado;
use App\Http\Requests\GradoRequest;
use App\Nivel;
use App\User;
use Laracasts\Flash\Flash;
use DB;

class GradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         if ($request) {
            $query = trim($request->get('searchText'));
            $anios = Anio::orderBy('id', 'desc')->get();
            $anio="";

            if ($request->get('searchAnio') == null) {

                //cuando no se ha seleccionado un periodo
                $grados = DB::table('grados')
                ->join('anios', 'grados.anio_id', 'anios.id')
                ->join('niveles', 'grados.nivel_id', 'niveles.id')
                ->join('docentes', 'grados.docente_id', 'docentes.id')
                ->join('users', 'docentes.user_id', 'users.id')
                ->select('grados.id', 'grados.codigo', 'grados.seccion', 'grados.estado', 
                'grados.registros', 'anios.numero', 'anios.activo', 'niveles.nombre', 
                'users.nombre as nombreDocente', 'users.apellido as apellidoDocente')
                ->orwhere([
                    ['anios.activo', 1],
                    ['niveles.nombre', 'like', '%' . $query . '%'],
                ])
                ->orWhere([
                    ['anios.activo', 1],
                    ['users.apellido', 'like', '%' . $query . '%'],
                ])
                ->orWhere([
                    ['anios.activo', 1],
                    ['users.nombre', 'like', '%' . $query . '%'],
                ])
                ->orderBy('niveles.nombre', 'asc')
                ->orderBy('grados.seccion', 'asc')
                ->paginate(25);

            }else{

                //cuando se ha seleccionado un periodo
                $anio = trim($request->get('searchAnio'));
                
                $grados = DB::table('grados')
                ->join('anios', 'grados.anio_id', 'anios.id')
                ->join('niveles', 'grados.nivel_id', 'niveles.id')
                ->join('docentes', 'grados.docente_id', 'docentes.id')
                ->join('users', 'docentes.user_id', 'users.id')
                ->select('grados.id', 'grados.codigo', 'grados.seccion', 'grados.estado', 
                'grados.registros', 'anios.numero', 'anios.activo', 'niveles.nombre', 
                'users.nombre as nombreDocente', 'users.apellido as apellidoDocente')
                ->where('anios.id', $anio)
                ->orderBy('niveles.nombre', 'asc')
                ->orderBy('grados.seccion', 'asc')
                ->paginate(25);

            }
        }

        return view('grados.index')
            ->with('grados', $grados)
            ->with('searchText', $query)
            ->with('anios', $anios)
            ->with('anio', $anio);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $niveles = Nivel::where('estado', 1)->orderBy('nombre', 'asc')->pluck('nombre', 'id');
        $anios = Anio::where('activo', 1)->orderBy('numero', 'asc')->pluck('numero', 'id');
        $docentes = Docente::where('estado', 1)->orderBy('id', 'asc')->get()->pluck('nombre_and_apellido', 'id');

        return view('grados.create')
                ->with('niveles', $niveles)
                ->with('anios',$anios)
                ->with('docentes',$docentes);
    }

    /**
     * Store a newly created resource in storage. \App\Http\Requests\UserRequest
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GradoRequest $request)
    {
        $nivel = Nivel::find($request->nivel_id);
        $anio = Anio::find($request->anio_id);

        // Validando registro único.
        if (!$this->esUnico($request->nivel_id, $request->anio_id, $request->seccion)) {
             flash('
                <h4>Error en Ingreso de Datos</h4>
                <p>Ya existe el grado.</p>
            ')->error()->important();

             return back();
         }

        $grado = new Grado($request->all());
        // dd($grado);
        $grado->estado = 1;

        if ($request->seccion) {
            $grado->codigo = $nivel->nombre . '-' . $request->seccion . '-' . $anio->numero;
        } else {
            $grado->codigo = $nivel->nombre . '-' . $anio->numero;
        }

        $grado->save();

        // Almacenando las materias impartidas en el grado. Se guarda en la tabla grado_materia
        $materias = $nivel->materias;
        //dd($materias->toArray());

        //También verifica si la opcion orientador_materia esta activada para
        //para asignar el docente a todas las materias 
        if ($grado->nivel->orientador_materia == 1) {
            $docente = $grado->docente_id;
        
            $form_extra = false;
        } else {
            $docente = null;

            $form_extra = true;
        }

        foreach ($materias as $materia) {
            $grado->materias()->attach($materia->id, ['docente_id' => $docente]);
        }

        flash('
            <h4>Registro de Grado</h4>
            <p>El Grado <strong>' . $grado->codigo . '</strong> se ha registrado correctamente.</p>
        ')->success()->important();

        if ($form_extra) {
            return redirect()->route('grados.edit', $grado->id);
        } else {
            return redirect()->route('grados.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grado = Grado::find($id);

        /* if (!$grado || $grado->estado == 0) {
            abort(404);
        } */

        $niveles = Nivel::orderBy('nombre', 'asc')->pluck('nombre', 'id');
        $anios = Anio::where('estado', 1)->orderBy('numero', 'asc')->pluck('numero', 'id');
        $docentes = Docente::where('estado', 1)->orderBy('id', 'asc')->get()->pluck('nombre_and_apellido', 'id');

        /* verificar si existe un materia registrado en la tabla grado_materia */
        $nivel = Nivel::find($grado->nivel_id);
        $materias_nivel = $nivel->materias;
        
        $materias_grado = \DB::table('grado_materia')->where('grado_id', $id)->get();
        /* Calculo de los ids de las materias que se modificaron */
        $tmp_mat = array();
        foreach ($materias_grado as $item) {
            array_push($tmp_mat, $item->materia_id);
        }
        $tmp_niv = array();
        foreach ($materias_nivel as $value) {
            array_push($tmp_niv, $value->id);
        }
        /* Guardar los ids que se debe de eliminar o insertar segun sea el resultado de la consulta */
        $intersec = (count($tmp_niv) > count($tmp_mat)) ? array_diff($tmp_niv, $tmp_mat) : array_diff($tmp_mat, $tmp_niv) ;
        if ($intersec) {
            foreach ($intersec as $mat_id) {
                if (\DB::table('grado_materia')->where('grado_id', $id)->where('materia_id', $mat_id)->exists()) {
                    \DB::table('grado_materia')
                    ->where('grado_id', $id)
                    ->where('materia_id', $mat_id)
                    ->delete();
                }else {
                    \DB::table('grado_materia')->insert([
                        'grado_id' => $id,
                        'materia_id' => $mat_id
                    ]);
                }
            }
        }

        $materias = $grado->materias;
        // dd($materias);
        
        /* Control, si existe materias al momento de editar un grado */
        if ($materias->count() == 0) {
            $materias = \DB::table('materias')
                ->join('materia_nivel', 'materias.id', 'materia_nivel.materia_id')
                ->select('materias.*')
                ->where('materia_nivel.nivel_id', $grado->nivel_id)
                ->orderBy('nombre', 'asc')
                ->get();
            // dd($materias);
        }
        return view('grados.edit')
            ->with('grado', $grado)
            ->with('niveles', $niveles)
            ->with('anios',$anios)
            ->with('docentes',$docentes)
            ->with('materias', $materias);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Actualizacion de permisos para el registro de notas
        if ($request->enablenotes) {
            $modGrados = Grado::find($id);
            $modGrados->registros = $request->enablenotes;
            $modGrados->save();

            return back();
        }else{
            // Flujo normal de actualizacion
            $grado = Grado::find($id);

            /*  if (!$grado || $grado->estado == 0) {
                abort(404);
            } */
            
            $grado->fill($request->all());
            
            $grado->save();

            // Almacenando las materias impartidas en el grado.
            for ($i=0; $i < count($request->materias); $i++) { 
                // $grado->materias()->updateExistingPivot($request->materias[$i], ['docente_id' => $request->docentes[$i]]);
                /* Verificar si existe asignado materias a este grado */
                if (\DB::table('grado_materia')->where('grado_id', $grado->id)->where('materia_id', $request->materias[$i])->exists()) {
                    $grado->materias()->updateExistingPivot($request->materias[$i], ['docente_id' => $request->docentes[$i]]);
                } else {
                    \DB::table('grado_materia')
                    ->insert([
                        'grado_id' => $grado->id,
                        'materia_id' => $request->materias[$i],
                        'docente_id' => $request->docentes[$i]
                    ]);
                }
            }

            flash('
                <h4>Edición de Docente</h4>
                <p>El docente <strong>' . $grado->codigo . '</strong> se ha editado correctamente.</p>
            ')->success()->important();

            return redirect()->route('grados.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $grado = Grado::find($id);

        if (!$grado || $grado->estado == 0) {
            abort(404);
        }

        $grado->estado = 0;

        $grado->save();

        flash('
            <h4>Baja de Grado</h4>
            <p>El Grado <strong>' . $grado->codigo .  '</strong> se ha dado de baja correctamente.</p>
        ')->error()->important();

        return redirect()->route('grados.index');
    }



public function pdf(Request $request)
    {
         if ($request) {
            $query = trim($request->get('searchText'));

            $grados = Grado::where('estado', 1)
                ->where('codigo', 'like', '%' . $query . '%')
                ->orWhere('estado', 1)
                ->where('seccion', 'like', '%' . $query . '%')
                ->orderBy('id', 'asc')
                ->paginate(25);
        }

        return view('grados.pdf')
            ->with('grados', $grados)
            ->with('searchText', $query);
    }

    /**
     * Verifica que el grado sea único.
     *
     * @param  int  $nivel
     * @param  int  $anio
     * @param  string  $seccion
     * @return bool
     */
    public function esUnico($nivel, $anio, $seccion)
    {
        $grado = Grado::where('nivel_id', $nivel)
            ->where('anio_id', $anio)
            ->where('seccion', $seccion)
            ->first();

        if ($grado) {
            return false;
        } else {
            return true;
        }
    }
}
