@extends('layouts.general')

@section('titulo', 'SISBEGN | Crear Nivel Educativo')

@section('estilos')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('encabezado', 'Crear Nivel Educativo')

@section('subencabezado', 'Registro')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-cog"></i> Configuración
</li>
<li class="breadcrumb-item active">
  <a href="{{ route('nivel.index') }}">Nivel Educativo</a>
</li>
<li class="breadcrumb-item active">
  Registrar Nivel Educativo
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Registrar Nivel Educativo</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => 'nivel.store', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">
          <!-- Código -->
          <div class="form-group row{{ $errors->has('codigo') ? ' has-error' : '' }}" hidden>
            {!! Form::label('Codigo', 'Código Nivel', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('codigo', old('codigo'), ['class' => 'form-control', 'placeholder' => 'Ej: EB1', 'required', 'maxlength' => '3', 'id' => 'codigo']) !!}
                @if ($errors->has('codigo'))
                <span class="text-danger">{{ $errors->first('codigo') }}</span>
                @endif
            </div>
          </div>
          <!-- Nombre -->
          <div class="form-group row{{ $errors->has('nombre') ? ' has-error' : '' }}">
            {!! Form::label('nombre', 'Nombre Nivel', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              <select name="nombre" class="form-control" id="nombre" required>
                <option value="">-- Seleccione un nivel --</option>
                <option value="Octavo" data-codigo="EB1">Octavo</option>
                <option value="Noveno" data-codigo="EB2">Noveno</option>
                <option value="Décimo" data-codigo="EB3">Décimo</option>
                <option value="Primero BGU" data-codigo="BA1">Primero BGU</option>
                <option value="Segundo BGU" data-codigo="BA2">Segundo BGU</option>
                <option value="Tercero BGU" data-codigo="BA3">Tercero BGU</option>
              </select>
              {{-- {!! Form::text('nombre', old('nombre'), ['class' => 'form-control', 'placeholder' => 'Ej: Octavo', 'required']) !!} --}}
              @if ($errors->has('nombre'))
              <span class="text-danger">{{ $errors->first('nombre') }}</span>
              @endif
            </div>
          </div>
          <!-- Materias -->
          <div class="form-group row">
            {!! Form::label('materias', 'Asignar Materias', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('materias[]', $materias, old('materias[]'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder' => '-- Seleccione las materias que se imparten --', 'style' => 'width: 100%']) !!}
            </div>
          </div>
          
          <!-- Orientador imparte todas las materias -->
          <div class="form-group row">
            <label class="col-sm-4" style="text-align:right"></label>
            <div class="col-sm-5 check-group">
                <input type="checkbox" name="orientador_materia" value="1"> 
                <small><b>NOTA:</b> Marque esta casilla si las materias 
                de este nivel seran dictadas por un solo profesor.</small>
            </div>
          </div>


          

        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('nivel.index') }}" class="btn btn-secondary">Cancelar</a>
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
<!-- Select2 -->
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  });

  document.getElementById('nombre').onchange = function() {
  /* Referencia al option seleccionado */
    var mOption = this.options[this.selectedIndex];
    /* Referencia a los atributos data de la opción seleccionada */
    var mData = mOption.dataset;
    /* Referencia a los input */
    
    var cod = document.getElementById('codigo');
    /* Asignamos cada dato a su input*/
    cod.value = mData.codigo;
      
  };
</script>
@endsection
