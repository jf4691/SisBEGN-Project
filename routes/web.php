<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Solo tienen acceso usuarios autentificados.
 */
Route::group(['middleware' => ['auth', 'usernew', 'isActive']], function() {

    /**
     * Solo tienen acceso usuarios con rol de administrador.
     */
    Route::group(['middleware' => ['role:admin']], function() {

        // Roles de usuario.
        Route::resource('roles', 'RolController');

        //ruta para Usuarios Inactivos
        Route::get('inactive_users', 'UserController@usuariosInactivos')->name('users.inactiveUsers');

        // Usuarios.
        Route::resource('users', 'UserController');


        // Materias.
        Route::resource('materias', 'MateriaController');

        // Grados
        Route::resource('nivel', 'NivelEducativoController');

        // Años (Periodos)
        Route::resource('anios','AnioController');

        // Administrativos.
        Route::resource('administrativos', 'AdministrativoController');

        // Docentes.
        Route::resource('docentes', 'DocenteController');

    });

    /**
     * Solo tienen acceso usuarios con rol administrador o secretaria.
     */
    Route::group(['middleware' => ['role:admin,secre']], function() {

        //Ruta para Estudiantes Inactivos
        Route::get('inactive_students', 'AlumnoController@inactiveStudents')->name('alumnos.inactiveStudents');
    
        // Alumnos.
        Route::resource('alumnos','AlumnoController');

        // Récord de notas.
        Route::get('alumnos/{alumno}/record', 'AlumnoController@record')->name('alumnos.record');

        // Matriculas.
        Route::resource('matriculas','MatriculaController');

        // Asignacion de Profesores y Materias a Grados
        Route::resource('grados', 'GradoController');

        // Vista de la Pagina Reportes
        Route::get('reportes', function(){
            return view('pdf.principal');
        })->name('reportes');

        // Para descargar PDF de Grados
        Route::get('descargar/grados', 'GradoController@pdf')->name('grados.pdf');

        // Para descargar PDF de niveles
        Route::get('descargar/niveles', 'NivelEducativoController@pdf')->name('nivel.pdf');

        // Para descargar PDF de Docentes
        Route::get('descargar/docentes', 'DocenteController@pdf')->name('docentes.pdf');

        // Para descargar PDF de MAterias
        Route::get('descargar/materias', 'MateriaController@pdf')->name('materias.pdf');

        // Reportes de notas.
        // Route::get('notas', 'NotaController@index')->name('notas.index');
        Route::get('notas/{grado}/reportes', 'NotaController@createReporte')->name('notas.create-reporte');
        Route::post('notas/reportes/descargar', 'NotaController@downloadReporte')->name('notas.reporte');
    });

    Route::group(['middleware' => ['role:docen,admin,secre']], function() {
        //Reporte 
        // Route::get('notas', 'NotaController@index')->name('notas.index');
        Route::get('notas/{grado}/reportes', 'NotaController@createReporte')->name('notas.create-reporte');
        Route::post('notas/reportes/descargar', 'NotaController@downloadReporte')->name('notas.reporte');

    });

    Route::group(['middleware' => ['role:docen']], function() {
        //Reporte 
        Route::get('notas/{gra_mat}/edit', 'NotaController@edit')->name('notas.edit');
        Route::put('notas/update', 'NotaController@update')->name('notas.update');
    });
    //Solo tiene acceso el usuario con rol estudiante
    Route::group(['middleware' => ['role:estud']], function() {
        // Reportes de notas del alumno
        // Route::get('notas', 'NotaController@index')->name('notas.index');
        Route::get('notas/{grado}/descargar', 'NotaController@alumnoReporte')->name('notas.alumno');
    });
    // Acceso todos los roles
    Route::get('notas', 'NotaController@index')->name('notas.index');


    

    // Editar imagen de perfil.
    Route::put('/{user}', 'HomeController@actualizarImagen')->name('actualizar-imagen');
    
    // Editar contraseña.
    Route::put('/{user}/password', 'HomeController@actualizarPassword')->name('actualizar-password');

});

Route::put('/{user}/password', 'HomeController@actualizarPassword')->name('actualizar-password');
/* Middleware para redirigir al usuario nuevo */
Route::group(['middleware' => ['usernew', 'isActive']], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::get('/change-pass', function () {
    return view('auth.changePass');
})->middleware('auth');

Route::get('/in-active', function () {
    return view('users.inActive');
});

Auth::routes();

// import file excel
Route::post('importar-estudiantes', 'UserController@import')->name('import.students');