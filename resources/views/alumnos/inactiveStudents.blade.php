@extends('layouts.general')

@section('titulo', 'SISBEGN | Estudiantes')

@section('encabezado', 'Estudiantes')

@section('subencabezado', 'Gestión')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-child"></i> Estudiantes Inactivos
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Lista de Estudiantes Inactivos</h3>
      </div>
      <div class="card-body my-card-body">
        <div class="row">
          
          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
            <!-- Barra de búsqueda -->
            @include('alumnos.searchInactiveStudents')
          </div>
        </div>
        <!-- Listado de alumnos -->
        @if ($alumnos->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead class="my-table-thead">
              <tr>
                <th>ID</th>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Género</th>
                <th>Periódo Ingreso</th>
                <th>Estado</th>
                <th>Opciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($alumnos as $alumno)
              <tr>
                <td>{{ $alumno->id }}</td>
                <td>{{ $alumno->cedula }}</td>
                <td class="tdNombre">{{ $alumno->apellido }} {{ $alumno->nombre }}</td>
                <td>{{ $alumno->genero }}</td>
                <td>{{ $alumno->numero }}</td>
                <td>
                  @if($alumno->estado === 1)
                    <span class="badge badge-success">ACTIVO</span>
                  @else
                    <span class="badge badge-warning">INACTIVO</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('alumnos.show', $alumno->id) }}" class="btn btn-default btn-flat" title="Ver detalle">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </a>
                  <a href="{{ route('alumnos.edit', $alumno->id) }}" class="btn btn-default btn-flat" title="Editar">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                  </a>
                  
                </td>
              </tr>
              <!-- Modal para dar de baja -->
              
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- Si no hay alumnos -->
        @else
          <div class="text-center">
            <i class="fa fa-search fa-5x" aria-hidden="true"></i>
            <h4>No se encontraron estudiantes</h4>
          </div>
        @endif
      </div>
      <!-- /.box-body -->
      <div class="card-footer">
        <div class="pull-right">
          <!-- Paginación -->
          {!! $alumnos->render() !!}
        </div>
      </div>
      <!-- /.box-footer-->
    </div>
  </div>
</div>
<!-- /.box -->
@endsection