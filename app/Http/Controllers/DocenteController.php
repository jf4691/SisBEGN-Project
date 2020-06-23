<?php

namespace App\Http\Controllers;

use App\Docente;
use App\Grados;
use App\Provincia;
use App\Ciudad;
use App\User;
use App\Http\Requests\DocenteRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Barryvdh\DomPDF\Facade as PDF;
use DB;

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request) {
            $query = trim((string)$request->get('searchText'));
            
            $tmpGrados = array();
            if (DB::table('anios')->exists()) {
                // Obteniendo el año activo
                $anio = DB::table('anios')
                ->select('id')
                ->where('activo', 1)
                ->first();

                // Obteniendo los grados
                $grados = DB::table('grados')
                    ->where('estado', 1)
                    ->where('anio_id', $anio->id)
                    ->get();
                
                foreach ($grados as $row) {
                    $tmpGrados[$row->id] = $row->codigo;
                }

                $docentes = User::with(['docentes.grados' => function ($x) use($anio) {
                        $x->where('anio_id', $anio->id);
                    } ])
                    ->with('docentes.materias')
                    ->whereHas('docentes')
                    // ->where('cedula', 'LIKE', '%'.$query.'%')
                    // ->orwhere('apellido', 'LIKE', '%'.$query.'%')
                    // ->orwhere('nombre', 'LIKE', '%'.$query.'%')
                    ->orderBy('apellido', 'asc')
                    ->orderBy('nombre', 'asc')
                    ->paginate(25);
            } else {
                $docentes = User::with('docentes.grados')
                ->with('docentes.materias')
                ->whereHas('docentes')
                
                // ->where('cedula', 'LIKE', '%'.$query.'%')
                // ->orwhere('apellido', 'LIKE', '%'.$query.'%')
                // ->orwhere('nombre', 'LIKE', '%'.$query.'%')
                ->orderBy('apellido', 'asc')
                ->orderBy('nombre', 'asc')
                ->paginate(25);
            }
        }

        return view('docente.index')
            ->with('docentes', $docentes)
            ->with('searchText', $query)
            ->with('grados', $tmpGrados);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provincias = Provincia::orderBy('nombre', 'asc')->pluck('nombre', 'id');
        $ciudades = Ciudad::orderBy('nombre', 'asc')->get();
        $users = User::doesntHave('docentes')
                ->where('estado', '1')
                ->where('rol_id', '3')
                ->orderBy('apellido', 'asc')
                ->get();
        return view('docente.create')->with('users', $users)
        ->with('provincias', $provincias)
        ->with('ciudades', $ciudades);
    }

    /**
     * Almacena un docente en la base de datos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocenteRequest $request)
    {
        if (Docente::where('user_id', $request->user_id)->exists()) {
            flash('
                <h4>EL DOCENTE YA EXISTE</h4>
                <p>El Docente ya esta registrado en sistema.</p>
            ')->error()->important();

            return back();
        }
        $docente = new Docente;

        $fecha = $this->crearFecha($request->fecha_nacimiento);

        if ($fecha == null) {
            flash('
                <h4>Error en Ingreso de Datos</h4>
                <p>El formato de la fecha es incorrecto.</p>
            ')->error()->important();

            return back();
        }
        
        $docente->user_id = $request->user_id;
        $docente->ciudad_id = $request->ciudad_id;
        $docente->fecha_nacimiento = $fecha;
        $docente->genero = $request->genero;
        $docente->direccion = $request->direccion;
        $docente->telefono = $request->telefono;
        $docente->especialidad = $request->especialidad;
        $docente->estado = 1;

        $docente->save();

        flash('
            <h4>Registro de Docente</h4>
            <p>El Docente <strong>' . $docente->user->nombre . ' ' . $docente->user->apellido . '</strong> se ha registrado correctamente.</p>
        ')->success()->important();

        return redirect()->route('docentes.index');
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
        $docente = Docente::find($id);
        //dd($docente->ciudad);
        /* if (!$docente || $docente->estado == 0) {
            abort(404);
        } */

        $provincias = Provincia::orderBy('nombre', 'asc')->pluck('nombre', 'id');
        $ciudades = Ciudad::orderBy('nombre', 'asc')->get();

        $users = User::where('rol_id', '3')->orderBy('apellido', 'asc')->get();

        return view('docente.edit')
            ->with('docente', $docente)
            ->with('users', $users)
            ->with('provincias', $provincias)
            ->with('ciudades', $ciudades);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocenteRequest $request, $id)
    {
        $docente = Docente::find($id);

        /* if (!$docente || $docente->estado == 0) {
            abort(404);
        } */

        // Validación de la fecha.
        $fecha = $this->crearFecha($request->fecha_nacimiento);

        if ($fecha == null) {
            flash('
                <h4>Error en Ingreso de Datos</h4>
                <p>El formato de la fecha es incorrecto.</p>
            ')->error()->important();
 
            return back();
        }
        
        $docente->user_id = $request->user_id;
        $docente->ciudad_id = $request->ciudad_id;
        $docente->fecha_nacimiento = $fecha;
        $docente->genero = $request->genero;
        $docente->direccion = $request->direccion;
        $docente->telefono = $request->telefono;
        $docente->especialidad = $request->especialidad;
        $docente->estado = ($request->estado) ? $request->estado : 0 ;
        $docente->save();

        flash('
            <h4>Edición de Docente</h4>
            <p>El docente <strong>' . $docente->user->nombre .' '. $docente->user->apellido . '</strong> se ha editado correctamente.</p>
        ')->success()->important();

        return redirect()->route('docentes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $docente = Docente::find($id);

        if (!$docente || $docente->estado == 0) {
            abort(404);
        }

        $docente->estado = 0;

        $docente->save();

        flash('
            <h4>Baja de Docente</h4>
            <p>El Docente <strong>' . $docente->user->nombre .' '. $docente->user->apellido . '</strong> se ha dado de baja correctamente.</p>
        ')->error()->important();

        return redirect()->route('docentes.index');
    }

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

    public function pdf(Request $request)
    {        
        if ($request) {
            $query = trim($request->get('searchText'));
            $docentes = DB::table('docentes as d')
            ->join('users as u', 'd.user_id', '=', 'u.id')
            ->select('u.*', 'd.*')
            ->where('d.estado', 1)
            ->where('u.cedula', 'LIKE', '%'.$query.'%')
            ->orderBy('d.id', 'asc')
            ->paginate(25);
            /* $docentes = Docente::where('estado', 1)
                ->where('user_id', 'like', '%' . $query . '%')
                ->orWhere('estado', 1)
                ->where('cedula', 'like', '%' . $query . '%')
                ->orderBy('id', 'asc')
                ->paginate(25); */
        }

        return view('docente.pdf')
            ->with('docentes', $docentes)
            ->with('searchText', $query);
    }
}
