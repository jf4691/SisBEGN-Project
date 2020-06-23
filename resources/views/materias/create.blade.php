@extends('layouts.general')

@section('titulo', 'SISBEGN | Crear Materia')

@section('encabezado', 'Crear Materia')

@section('subencabezado', 'Registro')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-users"></i> Configuración
</li>
<li class="breadcrumb-item active">
  <a href="{{ route('materias.index') }}">Materia</a>
</li>
<li class="breadcrumb-item active">
  Registrar Materia
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Registrar Materia</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => 'materias.store', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">
          <!-- Código -->
          <div class="form-group row{{ $errors->has('user_id') ? ' has-error' : '' }}">
            {!! Form::label('Codigo', 'Código', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('codigo', old('codigo'), ['class' => 'form-control', 'placeholder' => 'Ej: MAT1', 'required', 'maxlength' => '4']) !!}
                @if ($errors->has('codigo'))
                <span class="text-danger">{{ $errors->first('codigo') }}</span>
                @endif
            </div>
          </div>
          <!-- Nombre -->
          <div class="form-group row{{ $errors->has('cedula') ? ' has-error' : '' }}">
            {!! Form::label('Nombre', 'Nombre', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('nombre', old('nombre'), ['class' => 'form-control', 'placeholder' => 'Nombre de la materia', 'required']) !!}
                @if ($errors->has('nombre'))
                <span class="text-danger">{{ $errors->first('nombre') }}</span>
                @endif
            </div>
          </div>
        </div>

        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('materias.index') }}" class="btn btn-secondary">Cancelar</a>
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