@extends('layouts.general')

@section('titulo', 'SISBEGN | Editar Período Académico')

@section('encabezado', 'Editar Período Académico')

@section('subencabezado', 'Edición')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-users"></i> Configuración
</li>
<li class="breadcrumb-item active">
  <a href="{{ route('anios.index') }}">Período Académico</a>
</li>
<li class="breadcrumb-item active">
  Editar Período Académico
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Registrar Período Académico</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => ['anios.update', $anio], 'autocomplete' => 'off', 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">

          <!-- Año -->
          <div class="form-group row{{ $errors->has('numero') ? ' has-error' : '' }}">
            {!! Form::label('numero', 'Período Académico', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('numero', $anio->numero, ['class' => 'form-control', 'placeholder' => 'Ej: 2000-X', 'maxlength' => '6','required']) !!}
                @if ($errors->has('numero'))
                <span class="text-danger">{{ $errors->first('numero') }}</span>
                @endif
            </div>
          </div>

          <!-- Activo -->
          <div class="form-group row">
            <label class="col-sm-4" style="text-align:right">Activo</label>
            <div class="col-sm-5 check-group custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name="activo" id="activo" value="1" {{ $anio->activo == '1' ? 'checked' : ''}}> 
              <label class="custom-control-label text-checkbox" for="activo">Indica si este es el año lectivo que actualmente se está impartiendo. 
              Permite visualizar primero los registros pertenecientes a este año. Solo puede 
              existir un año escolar activo. Los demas años estan Inactivos. Si el año es activo, 
              automáticamente es Editable.</label>
            </div>
          </div>
          <!-- Editable -->
          <div class="form-group row">
            <label class="col-sm-4" style="text-align:right">Editable</label>
            <div class="col-sm-5 check-group check-group custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" name="editable" id="editable" value="1" {{ $anio->editable == '1' ? 'checked' : ''}}> 
              <label class="custom-control-label text-checkbox" for="editable">Al activar esta casilla permite que registros pertenecientes a este año lectivo 
              puedan ser editados. En caso de no marcar, los registros pertenecientes a este año 
              no podrán visualizarse en el sistema.</label>
            </div>
          </div>

        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('anios.index') }}" class="btn btn-secondary">Cancelar</a>
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