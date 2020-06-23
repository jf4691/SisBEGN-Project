@extends('layouts.general')

@section('titulo', 'SISBEGN | Roles de usuario')

@section('encabezado', 'Roles de usuario')

@section('subencabezado', 'Edición')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-shield"></i> Seguridad
</li>
<li class="breadcrumb-item active">
  <a href="{{ route('roles.index') }}">Roles de usuario</a>
</li>
<li class="breadcrumb-item active">
  Editar Rol de Usuario
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
    <!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Editar Rol de Usuario</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => ['roles.update', $rol], 'autocomplete' => 'off', 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">
          <!-- Nombre -->
          <div class="form-group row{{ $errors->has('nombre') ? ' has-error' : '' }}">
            {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('nombre', $rol->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre rol', 'required']) !!}
                @if ($errors->has('nombre'))
                <span class="text-danger">{{ $errors->first('nombre') }}</span>
                @endif
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Actualizar</button>
          </div>
        </div>
      {!! Form::close() !!}
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->
  </div>
</div>
@endsection