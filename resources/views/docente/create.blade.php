@extends('layouts.general')

@section('titulo', 'SISBEGN | Crear Docente')

@section('encabezado', 'Crear Docente')

@section('estilos')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('subencabezado', 'Registro')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-users"></i> Personal
</li>
<li class="breadcrumb-item active">
  <a href="{{ route('docentes.index') }}">Docente</a>
</li>
<li class="breadcrumb-item active">
  Registrar Docente
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Registrar Docente</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => 'docentes.store', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">

          <!-- Id de Usuario -->
          <div class="form-group row{{ $errors->has('user_id') ? ' has-error' : '' }}">
            {!! Form::label('user_id', 'Buscar Docente', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              <select name="user_id" class="form-control select2" id="user_id2" aria-placeholder="--Seleccione un Docente--">
                <option value="">-- Seleccione un Docente --</option>
                @foreach($users as $us)
                  <option value="{{$us->id}}" data-cedula="{{$us->cedula}}">{{$us->cedula}} - {{$us->apellido}} {{$us->nombre}}</option>
                @endforeach
              </select>
              @if ($errors->has('user_id'))
              <span class="text-danger">{{ $errors->first('user_id') }}</span>
              @endif
            </div>
          </div>

          <!-- cedula -->
          <div class="form-group row{{ $errors->has('cedula') ? ' has-error' : '' }}">
            {!! Form::label('cedula', 'Cédula', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              <input type="text" name="cedula" id="cedula" class="form-control" required disabled>
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
        <!-- Dirección -->
        <div class="form-group row{{ $errors->has('direccion') ? ' has-error' : '' }}">
          {!! Form::label('direccion', 'Dirección', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
          <div class="col-sm-5">
            {!! Form::textarea('direccion', old('direccion'), ['class' => 'form-control', 'placeholder' => 'Dirección del Docente']) !!}
            @if ($errors->has('direccion'))
            <span class="text-danger">{{ $errors->first('direccion') }}</span>
            @endif
          </div>
        </div>
        <!-- Provincia -->
        <div class="form-group row{{ $errors->has('provincia_id') ? ' has-error' : '' }}">
          {!! Form::label('provincia_id', 'Provincia *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
          <div class="col-sm-5">
            {!! Form::select('provincia_id', $provincias, old('provincia_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione una provincia --', 'onchange' => 'cargarCiudades(this.value);', 'required']) !!}
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
        <!-- Teléfono -->
        <div class="form-group row{{ $errors->has('telefono') ? ' has-error' : '' }}">
          {!! Form::label('telefono', 'Teléfono *', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
          <div class="col-sm-5">
            {!! Form::text('telefono', old('telefono'), ['class' => 'form-control', 'placeholder' => 'Teléfono de contacto', 'required', 'maxlength' => '12']) !!}
            @if ($errors->has('telefono'))
            <span class="text-danger">{{ $errors->first('telefono') }}</span>
            @endif
          </div>
        </div>
        <!-- Especialidad -->
          <div class="form-group row{{ $errors->has('especialidad') ? ' has-error' : '' }}">
            {!! Form::label('especialidad', 'Especialidad', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('especialidad', old('especialidad'), ['class' => 'form-control', 'placeholder' => 'Especialidad del Docente', 'required']) !!}
                @if ($errors->has('especialidad'))
                <span class="text-danger">{{ $errors->first('especialidad') }}</span>
                @endif
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('docentes.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
          </div>
        </div>
      {!! Form::close() !!}
      <!-- /.box-footer-->
    </div>
  </div>
</div>
<!-- /.box -->
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
  $(document).ready(function() {
    $('#user_id2').select2().on("change", function(e) {
      // var obj = $("#user_id2").select2("data");
      var cedula = $('#user_id2').find(':selected').data('cedula');
      $('#cedula').val(cedula);
    });
  });
  
</script>
@endsection