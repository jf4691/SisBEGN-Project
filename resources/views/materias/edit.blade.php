@extends('layouts.general')

@section('titulo', 'SISBEGN | Materia')

@section('encabezado', 'Materia')

@section('subencabezado', 'Editar')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-users"></i> Configuracion 
</li>
<li class="breadcrumb-item active">
  <a href="{{ route('materias.index') }}">Materia</a>
</li>
<li class="breadcrumb-item active">
  Editar Materia
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Editar Materia</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => ['materias.update',$materia], 'autocomplete' => 'off', 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">
          <!-- Código -->
          <div class="form-group row{{ $errors->has('codigo') ? ' has-error' : '' }}">
            {!! Form::label('Codigo', 'Código', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('codigo', $materia->codigo, ['class' => 'form-control', 'placeholder' => 'Ej: MAT1', 'required', 'maxlength' => '4']) !!}
                @if ($errors->has('codigo'))
                <span class="text-danger">{{ $errors->first('codigo') }}</span>
                @endif
            </div>
          </div>
          <!-- Nombre -->
          <div class="form-group row{{ $errors->has('nombre') ? ' has-error' : '' }}">
            {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('nombre', $materia->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre de la materia', 'required']) !!}
                @if ($errors->has('nombre'))
                <span class="text-danger">{{ $errors->first('nombre') }}</span>
                @endif
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-4" style="text-align:right">Estado</label>
            <div class="col-sm-5 check-group">
                <input type="checkbox" name="estado" value="1" {{ $materia->estado == '1' ? 'checked' : ''}}> 
            </div>
          </div>

        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('materias.index') }}" class="btn btn-secondary">Cancelar</a>
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