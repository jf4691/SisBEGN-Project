@extends('layouts.general')

@section('titulo', 'SISBEGN | Nivel Educativo')

@section('estilos')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('encabezado', 'Nivel Educativo')

@section('subencabezado', 'Editar')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-cog"></i> Configuración
</li>
<li class="breadcrumb-item active">
  <a href="{{ route('nivel.index') }}">Nivel Educativo</a>
</li>
<li class="breadcrumb-item active">
  Editar Nivel Educativo
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Editar Nivel Educativo</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => ['nivel.update',$nivel], 'autocomplete' => 'off', 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">
          <!-- Código -->
          <div class="form-group row{{ $errors->has('codigo') ? ' has-error' : '' }}" hidden>
            {!! Form::label('Codigo', 'Código Nivel', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('codigo', $nivel->codigo, ['class' => 'form-control', 'placeholder' => 'Ej: EB1', 'required']) !!}
                @if ($errors->has('codigo'))
                <span class="text-danger">{{ $errors->first('codigo') }}</span>
                @endif
            </div>
          </div>
          <!-- Nombre -->
          <div class="form-group row{{ $errors->has('cedula') ? ' has-error' : '' }}">
            {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('nombre', [
                'Octavo' => 'Octavo',
                'Noveno' => 'Noveno',
                'Décimo' => 'Décimo',
                'Primero BGU' => 'Primero BGU',
                'Segundo BGU' => 'Segundo BGU',
                'Tercero BGU' => 'Tercero BGU'
                ], $nivel->nombre, ['class' => 'form-control', 'placeholder' => '-- Ninguno --', 'required']) !!}
              {{-- {!! Form::text('nombre', $nivel->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre de nivel', 'required']) !!} --}}
                @if ($errors->has('nombre'))
                <span class="text-danger">{{ $errors->first('nombre') }}</span>
                @endif
            </div>
          </div>
          <!-- Materias -->
          <div class="form-group row">
            {!! Form::label('materias', 'Materias', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('materias[]', $materias, $mis_materias, ['class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder' => '-- Seleccione las materias que se imparten --', 'style' => 'width: 100%']) !!}
            </div>
          </div>
          <!-- Dirigente dicta todas las materias -->
          <div class="form-group row">
            <label class="col-sm-4" style="text-align:right"></label>
            <div class="col-sm-5 check-group">
                <input type="checkbox" name="orientador_materia" value="1" {{ $nivel->orientador_materia == '1' ? 'checked' : ''}}> 
                <small>Marque esta casilla si las materias de este nivel seran dictadas por un solo profesor</small>
            </div>
          </div>
          <!-- Estado -->
          <div class="form-group row">
            <label class="col-sm-4" style="text-align:right">Activar</label>
            <div class="col-sm-5 check-group">
                <input type="checkbox" name="estado" value="1" {{ $nivel->estado == '1' ? 'checked' : ''}}> 
            </div>
          </div>

        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('nivel.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Actualizar</button>
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
  })
</script>
@endsection
