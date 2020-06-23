@extends('layouts.general')

@section('titulo', 'SISBEGN | Estudiantes')

@section('encabezado', 'Estudiantes')

@section('subencabezado', 'Detalle')

@section('breadcrumb')
<li class="breadcrumb-item active">
  <i class="fa fa-child"></i>
  <a href="{{ route('alumnos.index') }}">Estudiantes</a>
</li>
<li class="breadcrumb-item active">
  Detalle del Estudiante
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
    <div class="col-sm-6 col-md-offset-3">
      <!-- Profile Image -->
      <div class="card card-primary">
        <div class="card-body my-card-body">
          <h3 class="profile-username text-center">{{ $user->nombre }} {{ $user->apellido }}</h3>
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Período de Ingreso</b> <a class="float-right">{{ $alumno->anio->numero }}</a>
            </li>
            <li class="list-group-item">
              <b>Cédula</b> <a class="float-right">{{ $user->cedula }}</a>
            </li>
            <li class="list-group-item">
              <b>Correo</b> <a class="float-right">{{ $user->email }}</a>
            </li>
            <li class="list-group-item">
              <b>Género</b> <a class="float-right">{{ $alumno->genero }}</a>
            </li>
            <li class="list-group-item">
              <b>Fecha de nacimiento</b> <a class="float-right">{{ $alumno->fecha_nacimiento }}</a>
            </li>
            <li class="list-group-item">
              <b>Teléfono (casa)</b> <a class="float-right">{{ $alumno->telefono }}</a>
            </li>
            <li class="list-group-item">
              <b>Provincia</b> <a class="float-right">{{ $alumno->ciudad->provincia->nombre }}</a>
            </li>
            <li class="list-group-item">
              <b>Ciudad</b> <a class="float-right">{{ $alumno->ciudad->nombre }}</a>
            </li>
            <li class="list-group-item">
              <b>Dirección</b> <a class="float-right">{{ $alumno->direccion }}</a>
            </li>
            <li class="list-group-item">
              <b>Responsable</b> <a class="float-right">{{ $alumno->responsable }}</a>
            </li>
            <li class="list-group-item">
              <b>Celular Responsable</b> <a class="float-right">{{ $alumno->celular }}</a>
            </li>
          </ul>
          <a href="{{ route('alumnos.index', $alumno->id) }}" class="btn btn-success btn-block"><b>Volver a la lista</b></a>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</div>
@endsection