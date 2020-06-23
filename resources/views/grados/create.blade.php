@extends('layouts.general')

@section('titulo', 'SISBEGN | Crear Grado')

@section('encabezado', 'Crear Grado')

@section('subencabezado', 'Registro')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-graduation-cap"></i>
  <a href="{{ route('docentes.index') }}">Grado</a>
</li>
<li class="breadcrumb-item active">
  Registrar Grado
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Registrar Grado</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => 'grados.store', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">

          <!-- Nivel Académico -->
          <div class="form-group row{{ $errors->has('nivel_id') ? ' has-error' : '' }}">
            {!! Form::label('nivel_id>', 'Nivel Académico', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('nivel_id', $niveles, old('nivel_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione un nivel académico --', 'required']) !!}
              @if ($errors->has('nivel_id'))
              <span class="text-danger">{{ $errors->first('nivel_id') }}</span>
              @endif
            </div>
          </div>

        <!-- Anio -->
          <div class="form-group row{{ $errors->has('anio_id') ? ' has-error' : '' }}">
            {!! Form::label('numero>', 'Período Académico', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('anio_id', $anios, old('anio_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione un Año --', 'required']) !!}
              @if ($errors->has('anio_id'))
              <span class="text-danger">{{ $errors->first('anio_id') }}</span>
              @endif
            </div>
          </div>

          <!-- Sección -->
          <div class="form-group row{{ $errors->has('seccion') ? ' has-error' : '' }}">
            {!! Form::label('seccion', 'Sección', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('seccion', old('seccion'), ['class' => 'form-control', 'placeholder' => 'Sección', 'maxlength' => '1']) !!}
                @if ($errors->has('seccion'))
                <span class="text-danger">{{ $errors->first('seccion') }}</span>
                @endif
            </div>
          </div>

          <!-- Profesor Dirigente -->
          <div class="form-group row{{ $errors->has('docente_id') ? ' has-error' : '' }}">
            {!! Form::label('docente_id', 'Docente Dirigente', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('docente_id', $docentes, old('docente_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione un docente --', 'required']) !!}
              @if ($errors->has('docente_id'))
              <span class="text-danger">{{ $errors->first('docente_id') }}</span>
              @endif
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('grados.index') }}" class="btn btn-secondary">Cancelar</a>
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