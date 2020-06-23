@extends('layouts.general')

@section('titulo', 'SISBEGN | Estudiantes')

@section('encabezado', 'Estudiantes')
@section('estilos')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('subencabezado', 'Registro')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-child"></i>
  <a href="{{ route('alumnos.index') }}">Estudiantes</a>
</li>
<li class="breadcrumb-item active">
  Registrar Estudiante
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- card Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Registrar Estudiante</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => 'alumnos.store', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">
          <!-- Anio -->
          <div class="form-group row{{ $errors->has('anio_id') ? ' has-error' : '' }}">
            {!! Form::label('numero', 'Período Académico', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              <select name="anio_id" id="anio_id" class="form-control" required>
                @foreach ($anios as $anio)
                  <option value="{{$anio->id}}">{{$anio->numero}}</option>
                @endforeach
              </select>
              @if ($errors->has('anio_id'))
              <span class="text-danger">{{ $errors->first('anio_id') }}</span>
              @endif
            </div>
          </div>
          <!-- Nombre -->
          <div class="form-group row{{ $errors->has('nombre') ? ' has-error' : '' }}">
            {!! Form::label('nombre', 'Nombre *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('nombre', old('nombre'), ['class' => 'form-control', 'placeholder' => 'Nombre del estudiante', 'required']) !!}
              @if ($errors->has('nombre'))
              <span class="text-danger">{{ $errors->first('nombre') }}</span>
              @endif
            </div>
          </div>
          <!-- Apellido -->
          <div class="form-group row{{ $errors->has('apellido') ? ' has-error' : '' }}">
            {!! Form::label('apellido', 'Apellido *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('apellido', old('apellido'), ['class' => 'form-control', 'placeholder' => 'Apellido del estudiante', 'required']) !!}
              @if ($errors->has('apellido'))
              <span class="text-danger">{{ $errors->first('apellido') }}</span>
              @endif
            </div>
          </div>
          <!-- Email -->
          <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', 'Correo electrónico *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Ej: example@address.com', 'required']) !!}
              @if ($errors->has('email'))
              <span class="text-danger">{{ $errors->first('email') }}</span>
              @endif
            </div>
          </div>

          <!-- Password -->
          <div class="form-group row">
              {!! Form::label('password', 'Contraseña *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
              <div class="col-sm-5">
                <div class="input-group">
                  <input type="password" name="password" id="password" value="123456" class="form-control" placeholder="Contraseña" required readonly>
                  {{-- {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña', 'required']) !!} --}}
                  @if ($errors->has('password'))
                  <span class="text-danger">{{ $errors->first('password') }}</span>
                  @endif
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-primary" onClick="cGenerate();">
                      Generar contraseña
                    </button>
                  </span>
                </div>
              </div>
          </div>

          <!-- Cédula -->
          <div class="form-group row{{ $errors->has('cedula') ? ' has-error' : '' }}">
            {!! Form::label('cedula', 'Cédula *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('cedula', old('cedula'), ['class' => 'form-control', 'placeholder' => 'Ej: 1799999999', 'required', 'maxlength' => '10']) !!}
              @if ($errors->has('cedula'))
              <span class="text-danger">{{ $errors->first('cedula') }}</span>
              @endif
            </div>
          </div>
      
          <!-- Fecha de nacimiento -->
          <div class="form-group row{{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }} input-btn-alinear">
            {!! Form::label('fecha_nacimiento', 'Fecha de nacimiento *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5 input-group">
              {!! Form::text('fecha_nacimiento', old('fecha_nacimiento'), ['class' => 'form-control', 'placeholder' => 'dd/mm/yyyy', 'required', 'data-inputmask' => '"alias": "dd/mm/yyyy"', 'data-mask']) !!}
              @if ($errors->has('fecha_nacimiento'))
              <span class="text-danger">{{ $errors->first('fecha_nacimiento') }}</span>
              @endif
            </div>
          </div>
          <!-- Género -->
          <div class="form-group row{{ $errors->has('genero') ? ' has-error' : '' }}">
            {!! Form::label('genero', 'Género *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('genero', ['F' => 'Femenino', 'M' => 'Masculino'], old('genero'), ['class' => 'form-control', 'placeholder' => '-- Seleccione un género --', 'required'] ) !!}
              @if ($errors->has('genero'))
              <span class="text-danger">{{ $errors->first('genero') }}</span>
              @endif
            </div>
          </div>
          <!-- Provincia -->
          <div class="form-group row{{ $errors->has('provincia_id') ? ' has-error' : '' }}">
            {!! Form::label('provincia_id', 'Provincia *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('provincia_id', $provincias, old('provincia_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione un provincia --', 'onchange' => 'cargarCiudades(this.value);', 'required']) !!}
              @if ($errors->has('provincia_id'))
              <span class="text-danger">{{ $errors->first('provincia_id') }}</span>
              @endif
            </div>
          </div>
          <!-- Ciudad -->
          <div class="form-group row{{ $errors->has('ciudad_id') ? ' has-error' : '' }}">
            {!! Form::label('ciudad_id', 'Ciudad *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              <select id='ciudad_id' name='ciudad_id' class='form-control' required disabled>
                <option value='0'>-- Seleccione una ciudad --</option>
              </select>
              @if ($errors->has('ciudad_id'))
              <span class="text-danger">{{ $errors->first('ciudad_id') }}</span>
              @endif
            </div>
          </div>
          <!-- Dirección -->
          <div class="form-group row{{ $errors->has('direccion') ? ' has-error' : '' }}">
            {!! Form::label('direccion', 'Dirección', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::textarea('direccion', old('direccion'), ['class' => 'form-control', 'placeholder' => 'Dirección del estudiante']) !!}
              @if ($errors->has('direccion'))
              <span class="text-danger">{{ $errors->first('direccion') }}</span>
              @endif
            </div>
          </div>
          <!-- Teléfono -->
          <div class="form-group row{{ $errors->has('telefono') ? ' has-error' : '' }}">
            {!! Form::label('telefono', 'Teléfono (Casa)', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('telefono', old('telefono'), ['class' => 'form-control', 'placeholder' => 'Ej: 02222222', 'maxlength' => '9']) !!}
              @if ($errors->has('telefono'))
              <span class="text-danger">{{ $errors->first('telefono') }}</span>
              @endif
            </div>
          </div>
          <!-- Responsable -->
          <div class="form-group row{{ $errors->has('responsable') ? ' has-error' : '' }}">
            {!! Form::label('responsable', 'Responsable *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('responsable', old('responsable'), ['class' => 'form-control', 'placeholder' => 'Ej: Juan Perez', 'required']) !!}
              @if ($errors->has('responsable'))
              <span class="text-danger">{{ $errors->first('responsable') }}</span>
              @endif
            </div>
          </div>

          <!-- Celular -->
          <div class="form-group row{{ $errors->has('celular') ? ' has-error' : '' }}">
            {!! Form::label('celular', 'Celular *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('celular', old('celular'), ['class' => 'form-control', 'placeholder' => 'Ej: 0999999999', 'required', 'maxlength' => '12']) !!}
              @if ($errors->has('celular'))
              <span class="text-danger">{{ $errors->first('celular') }}</span>
              @endif
            </div>
          </div>

          <!-- Grado aprobado -->
          <div class="form-group row{{ $errors->has('if_grado') ? ' has-error' : '' }}">
            {!! Form::label('if_grado', 'Último Grado Aprobado', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('if_grado', [
                'epf' => 'Educación Primaria Finalizada',
                '8' => 'Octavo',
                '9' => 'Noveno',
                '10' => 'Décimo',
                '11' => 'Primero BGU',
                '12' => 'Segundo BGU'
                ], old('if_grado'), ['class' => 'form-control', 'placeholder' => '-- Ninguno --']) !!}
              @if ($errors->has('if_grado'))
              <span class="text-danger">{{ $errors->first('if_grado') }}</span>
              @endif
            </div>
          </div>
        
        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
          </div>
        </div>
      {!! Form::close() !!}
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
// Funcion que se ejecuta al seleccionar una opcion del select de provincias.
function cargarCiudades(valor)
{
  var arrayValores=new Array(
    @foreach ($ciudades as $ciudad)
    new Array({{ $ciudad->provincia_id }}, {{ $ciudad->id }}, "{{ $ciudad->nombre }}"),
    @endforeach
  );

  if(valor == 0)
  {
      // Desactivamos el select de ciudades.
      document.getElementById("ciudad_id").disabled = true;
  } else {
      // Eliminamos todos los posibles valores que contenga el select de ciudades.
      document.getElementById("ciudad_id").options.length = 0;

      // Añadimos los nuevos valores al select de ciudades.
      document.getElementById("ciudad_id").options[0] = new Option("-- Seleccione una ciudad --", "0");

      // Únicamente añadimos los ciudades que pertenecen al id del provincia seleccionado.
      for(i=0; i<arrayValores.length; i++)
      {
        if(arrayValores[i][0] == valor)
        {
          document.getElementById("ciudad_id").options[document.getElementById("ciudad_id").options.length] = new Option(arrayValores[i][2], arrayValores[i][1]);
        }
      }

      // Habilitamos el select de ciudades.
      document.getElementById("ciudad_id").disabled = false;
  }
}
    
</script>
<!-- InputMask -->
<script src="{{ asset('js/jquery.inputmask.js') }}"></script>
<script src="{{ asset('js/jquery.inputmask.date.extensions.js') }}"></script>
<script type="text/javascript">
  $(function () {
    $('[data-mask]').inputmask()
  })
</script>

<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  });
  function randomPassword(length) {
    var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
  }

  function cGenerate() {
    $('#password').attr('type', 'text');
    $('#password').val(randomPassword(6));
  }
</script>
@endsection