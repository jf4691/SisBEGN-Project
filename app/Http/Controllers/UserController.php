<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use App\Rol;
use App\Docente;
use App\Alumno;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
//para la importacion de archivos excel
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Muestra una lista de usuarios.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request) {
            
            $query = trim((string)$request->get('searchText'));

            $users = User::where([
                ['estado', 1],
                ['cedula', 'like', '%' . $query . '%'],
            ])
            ->orWhere([
                ['estado', 1],
                ['apellido', 'like', '%' . $query . '%'],
            ])
            ->orWhere([
                ['estado', 1],
                ['nombre', 'like', '%' . $query . '%'],
            ])
            ->orderBy('rol_id', 'asc')
            ->paginate(25);

        }

        /* Obteniendo los roles */
        $roles = \DB::table('roles')
                ->where('nombre', '!=', 'Administrador')->get();

        //$this->authorize($user);
        return view('users.index')
            ->with('users', $users)
            ->with('searchText', $query)
            ->with('roles', $roles);
    }

    //funcion para usuarios inactivos
    public function usuariosInactivos(Request $request)
    {
        //$user = User::findOrFile($id);
        if ($request) {
            
            $query = trim((string)$request->get('searchText'));

            $users = User::where([
                ['estado', 0],
                ['cedula', 'like', '%' . $query . '%'],
            ])
            ->orWhere([
                ['estado', 0],
                ['apellido', 'like', '%' . $query . '%'],
            ])
            ->orWhere([
                ['estado', 0],
                ['nombre', 'like', '%' . $query . '%'],
            ])
            ->orderBy('rol_id', 'asc')
            ->paginate(25);
        }
        /* Obteniendo los roles */
        $roles = \DB::table('roles')
                ->where('nombre', '!=', 'Administrador')
                ->get();

        //$this->authorize($user);
        return view('users.inactiveUsers')
            ->with('users', $users)
            ->with('searchText', $query)
            ->with('roles', $roles);;
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$roles = Rol::where('id', '<', 4)->orderBy('id', 'asc')->pluck('nombre', 'id');
        $roles = Rol::where('id', '!=', 4)->orderBy('nombre', 'asc')->pluck('nombre', 'id');
        return view('users.create')->with('roles', $roles);
    }

    /**
     * Almacena un usuario recién creado en la base de datos.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        // Almacenamiento de la imagen.
        if ($request->file('imagen')) {
            $file = $request->file('imagen');

            $nombre = 'user_' . time() . '.' . $file->getClientOriginalExtension();

            $path = public_path() . '/img/users/';

            $file->move($path, $nombre);
        } else {
            $nombre = "user_default.jpg";
        }

        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->imagen = $nombre;
        $user->estado = 1;

        $user->save();

        flash('
            <h4>Registro de Usuario</h4>
            <p>El usuario <strong>' . $user->nombre . ' ' . $user->apellido . '</strong> se ha registrado correctamente.</p>
        ')->success()->important();

        return redirect()->route('users.index');
    }

    /**
     * Muestra el usuario especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user || $user->estado == 0) {
            abort(404);
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Muestra el formulario para editar el usuario especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        /* if (!$user || $user->estado == 0) {
            abort(404);
        } */
        $roles = Rol::where('id', '>', 0)->orderBy('id', 'asc')->pluck('nombre', 'id');
        //$roles = Rol::where('id', 2)->orWhere('id', 3)->orderBy('nombre', 'asc')->pluck('nombre', 'id');
    
        return view('users.edit')
            ->with('user', $user)
            ->with('roles', $roles);
    }

    /**
     * Actualiza el usuario especificado en la base de datos.
     *
     * @param  \App\Http\Requests\RolRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);

        /* if (!$user || $user->estado == 0) {
            abort(404);
        } */

        // Almacenamiento de la imagen.
        if ($request->file('imagen')) {
            $file = $request->file('imagen');

            $nombre = 'user_' . time() . '.' . $file->getClientOriginalExtension();

            $path = public_path() . '/img/users/';

            $file->move($path, $nombre);

            // Eliminación de la imagen anterior.
            if (\File::exists($path . $user->imagen) && $user->imagen != 'user_default.jpg') {
                \File::delete($path . $user->imagen);
            }
        } else {
            $nombre = $user->imagen;
        }

        $user->fill($request->all());
        $user->imagen = $nombre;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if (!$request->estado) {
            $user->estado = 0;
        }

        // Actualizar las tablas foraneas
        $user->docentes;
        $user->alumnos;
        if ($user->docentes->count()) {
            $doc = Docente::find($user->docentes[0]->id);
            $doc->estado = ($request->estado) ? $request->estado : 0;
            $doc->save();
        }
        if ($user->alumnos->count()) {
            $alm = Alumno::find($user->alumnos[0]->id);
            $alm->estado = ($request->estado) ? $request->estado : 0;
            $alm->save();
        }
        
        $user->save();

        flash('
            <h4>Edición de Usuario</h4>
            <p>El usuario <strong>' . $user->nombre . ' ' . $user->apellido . '</strong> se ha editado correctamente.</p>
        ')->success()->important();

        return redirect()->route('users.index');
    }

    /**
     * Da de baja al usuario especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user || $user->estado == 0) {
            abort(404);
        }

        $user->estado = 0;

        $user->save();

        flash('
            <h4>Baja de Usuario</h4>
            <p>El usuario <strong>' . $user->nombre . ' ' . $user->apellido . '</strong> se ha dado de baja correctamente.</p>
        ')->error()->important();

        return redirect()->route('users.index');
    }

    // ajax show grades for estudents id
    /* Funcion de prueba para saber si un alumno aprobo el grado */
    public function getusers(Request $request)
    {
        $output = '';
        if($request->ajax()){
            if ($request->roles) {
                
                $users = User::where('estado', 1)
                    ->whereIn('rol_id', $request->roles)
                    ->orderBy('rol_id', 'asc')
                    ->get();
                foreach ($users as $value) {
                    $output .= '<tr>
                                    <td>'.$value->id.'</td>
                                    <td>'.$value->cedula.'</td>
                                    <td class="tdNombre">'.$value->nombre.' '.$value->apellido.'</td>
                                    <td>'.$value->rol->nombre.'</td>
                                    <td>';
                                    if ($value->estado === 1) {
                    $output .= '        <span class="badge badge-success">ACTIVO</span>';
                                    } else {
                    $output .= '        <span class="badge badge-warning">INACTIVO</span>';
                                    }
                    $output .= '    </td>
                                    <td>
                                        <a href="'.route('users.show', $value->id).'" class="btn btn-default btn-flat">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="'.route('users.edit', $value->id).'" class="btn btn-default btn-flat">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>';
                                        if ($value->rol_id !== 1) {
                                            $output .= '<a href="" data-target="#modal-delete-'.$value->id.'" data-toggle="modal" class="btn btn-danger btn-flat">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>';
                                        }
                    $output .=      '</td>
                                </tr>';
                }
            }else {
                $users = User::where('estado', 1)
                    ->orderBy('rol_id', 'asc')
                    ->get();
                foreach ($users as $value) {
                    $output .= '<tr>
                                    <td>'.$value->id.'</td>
                                    <td>'.$value->cedula.'</td>
                                    <td class="tdNombre">'.$value->nombre.' '.$value->apellido.'</td>
                                    <td>'.$value->rol->nombre.'</td>
                                    <td>';
                                    if ($value->estado === 1) {
                    $output .= '        <span class="badge badge-success">ACTIVO</span>';
                                    } else {
                    $output .= '        <span class="badge badge-warning">INACTIVO</span>';
                                    }
                    $output .= '    </td>
                                    <td>
                                        <a href="'.route('users.show', $value->id).'" class="btn btn-default btn-flat">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="'.route('users.edit', $value->id).'" class="btn btn-default btn-flat">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>';
                                        if ($value->rol_id !== 1) {
                                            $output .= '<a href="" data-target="#modal-delete-'.$value->id.'" data-toggle="modal" class="btn btn-danger btn-flat">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>';
                                        }
                    $output .=      '</td>
                                </tr>';
                }
            }
        }
        
        // return Response($output);
        return response()->json($output);
    }

    //funcion para filtrar solo usuarios inactivos
    public function getusers2(Request $request)
    {
        $output = '';
        if($request->ajax()){
            if ($request->roles) {
                
                $users = User::where('estado', 0)
                    ->whereIn('rol_id', $request->roles)
                    ->orderBy('rol_id', 'asc')
                    ->get();
                foreach ($users as $value) {
                    $output .= '<tr>
                                    <td>'.$value->id.'</td>
                                    <td>'.$value->cedula.'</td>
                                    <td class="tdNombre">'.$value->nombre.' '.$value->apellido.'</td>
                                    <td>'.$value->rol->nombre.'</td>
                                    <td>';
                                    if ($value->estado === 1) {
                    $output .= '        <span class="badge badge-success">ACTIVO</span>';
                                    } else {
                    $output .= '        <span class="badge badge-warning">INACTIVO</span>';
                                    }
                    $output .= '    </td>
                                    <td>
                                        <a href="'.route('users.show', $value->id).'" class="btn btn-default btn-flat">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="'.route('users.edit', $value->id).'" class="btn btn-default btn-flat">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>
                                        <a href="" data-target="#modal-delete-'.$value->id.'" data-toggle="modal" class="btn btn-danger btn-flat">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>';
                }
            }else {
                $users = User::where('estado', 0)
                    ->orderBy('rol_id', 'asc')
                    ->get();
                foreach ($users as $value) {
                    $output .= '<tr>
                                    <td>'.$value->id.'</td>
                                    <td>'.$value->cedula.'</td>
                                    <td class="tdNombre">'.$value->nombre.' '.$value->apellido.'</td>
                                    <td>'.$value->rol->nombre.'</td>
                                    <td>';
                                    if ($value->estado === 1) {
                    $output .= '        <span class="badge badge-success">ACTIVO</span>';
                                    } else {
                    $output .= '        <span class="badge badge-warning">INACTIVO</span>';
                                    }
                    $output .= '    </td>
                                    <td>
                                        <a href="'.route('users.show', $value->id).'" class="btn btn-default btn-flat">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="'.route('users.edit', $value->id).'" class="btn btn-default btn-flat">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>
                                        <a href="" data-target="#modal-delete-'.$value->id.'" data-toggle="modal" class="btn btn-danger btn-flat">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>';
                }
            }
        }
        
        // return Response($output);
        return response()->json($output);
    }

    /* 
    Importar excel
    */
    public function import(Request $request){
        $file = $request->file('file');
        // Almacenamiento de la imagen.
        if ($file->getClientOriginalExtension() == 'xlsx' || $file->getClientOriginalExtension() == 'xls') {
            Excel::import(new UsersImport, $file);
        } else {
            flash('
                    <h4>Tipo Archivo invalido</h4>
                    <p>Asegurese de importar un archivo excel</p>
            ')->error()->important();
        }

        return back();
    }
 
}