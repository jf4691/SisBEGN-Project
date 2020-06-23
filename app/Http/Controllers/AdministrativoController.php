<?php

namespace App\Http\Controllers;

use App\Administrativo;
use App\Provincia;
use App\Ciudad;
use App\User;
use App\Http\Requests\AdministrativoRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Barryvdh\DomPDF\Facade as PDF;
use DB;


class AdministrativoController extends Controller
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

            $administrativos = DB::table('administrativos as ad')
            ->join('users as u','ad.user_id','u.id')
            ->select('ad.id','u.cedula','u.nombre','u.apellido','ad.cargo','ad.estado')
            //->where('ad.estado', 1)
            
                
            ->orderBy('id', 'asc')
            ->paginate(5);
        }

        return view('administrativos.index')
            ->with('administrativos', $administrativos)
            ->with('searchText', $query);
        
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
        $users = User::doesntHave('administrativos')
        ->where([
            ['estado', 1],
            ['rol_id','<=' ,2],
        ])
        
        ->orderBy('apellido', 'asc')
        ->get();
        
        return view('administrativos.create')->with('users', $users)
        ->with('provincias', $provincias)
        ->with('ciudades', $ciudades);
    }

    /**
     * Almacena un docente en la base de datos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdministrativoRequest $request)
    {
        /* if (Docente::where('user_id', $request->user_id)->exists()) {
            flash('
                <h4>EL DOCENTE YA EXISTE</h4>
                <p>El Docente ya esta registrado en el sistema.</p>
            ')->error()->important();

            return back();
        } */
        $administrativo = new Administrativo;

        $fecha = $this->crearFecha($request->fecha_nacimiento);

        if ($fecha == null) {
            flash('
                <h4>Error en Ingreso de Datos</h4>
                <p>El formato de la fecha es incorrecto.</p>
            ')->error()->important();

            return back();
        }
        
        $administrativo->user_id = $request->user_id;
        $administrativo->ciudad_id = $request->ciudad_id;
        $administrativo->fecha_nacimiento = $fecha;
        $administrativo->genero = $request->genero;
        $administrativo->direccion = $request->direccion;
        $administrativo->telefono = $request->telefono;
        $administrativo->cargo = $request->cargo;
        $administrativo->estado = 1;

        $administrativo->save();

        flash('
            <h4>Registro de Administrativo</h4>
            <p>El Administrativo <strong>' . $administrativo->user->nombre . ' ' . $administrativo->user->apellido . '</strong> se ha registrado correctamente.</p>
        ')->success()->important();

        return redirect()->route('administrativos.index');
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
        $administrativo = Administrativo::find($id);
        //dd($docente->ciudad);
        /* if (!$docente || $docente->estado == 0) {
            abort(404);
        } */

        $provincias = Provincia::orderBy('nombre', 'asc')->pluck('nombre', 'id');
        $ciudades = Ciudad::orderBy('nombre', 'asc')->get();

        $users = User::where('rol_id', '2')->orderBy('apellido', 'asc')->get();

        return view('administrativos.edit')
            ->with('administrativo', $administrativo)
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
    public function update(AdministrativoRequest $request, $id)
    {
        $administrativo = Administrativo::find($id);

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
        
        $administrativo->user_id = $request->user_id;
        $administrativo->ciudad_id = $request->ciudad_id;
        $administrativo->fecha_nacimiento = $fecha;
        $administrativo->genero = $request->genero;
        $administrativo->direccion = $request->direccion;
        $administrativo->telefono = $request->telefono;
        $administrativo->cargo = $request->cargo;
        $administrativo->estado = ($request->estado) ? $request->estado : 0 ;
        $administrativo->save();

        flash('
            <h4>Edición de Administrativo</h4>
            <p>El Administrativo <strong>' . $administrativo->user->nombre .' '. $administrativo->user->apellido . '</strong> se ha editado correctamente.</p>
        ')->success()->important();

        return redirect()->route('administrativos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $administrativo = Administrativo::find($id);

        if (!$administrativo || $administrativo->estado == 0) {
            abort(404);
        }

        $administrativo->estado = 0;

        $administrativo->save();

        flash('
            <h4>Baja de Administrativo</h4>
            <p>El Administrativo <strong>' . $administrativo->user->nombre .' '. $administrativo->user->apellido . '</strong> se ha dado de baja correctamente.</p>
        ')->error()->important();

        return redirect()->route('administrativos.index');
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

}
