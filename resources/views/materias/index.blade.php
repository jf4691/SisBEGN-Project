@extends('layouts.general')

@section('titulo', 'SISBEGN | Materias')

@section('encabezado', 'Materias')

@section('subencabezado', 'Gestión')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-users"></i> Configuración
</li>
<li class="breadcrumb-item active">
  Materias
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Lista de Materias</h3>
      </div>
      <div class="card-body my-card-body">
        <div class="row">
          <div class="col-sm-6">
            <a href="{{ route('materias.create') }}" class="btn btn-success"><i class="fa fa-book" style="font-size:20px"></i> Nueva Materia</a>
          </div>
        <div class="col-sm-6">
            <!-- Barra de búsqueda -->
            @include('materias.search')
          </div>
        </div>
        <!-- Listado de docentes -->
        @if ($materias->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead class="my-table-thead">
              <tr>
                <th>CÓDIGO</th>
                <th>ASIGNATURA</th>
                <th>ESTADO</th>
                <th>ACCIONES</th>
              </tr>
            </thead>
            <tbody>
              @foreach($materias as $materia)
              <tr>
                <td>{{ $materia->codigo }}</td>
                <td>{{ $materia->nombre }}</td>
                <td>
                  @if($materia->estado === 1)
                    <span class="badge badge-success">ACTIVO</span>
                  @else
                    <span class="badge badge-warning">INACTIVO</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('materias.edit', $materia->id) }}" class="btn btn-default btn-flat">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                  </a>
                  @if($materia->estado === 1)
                    <a href="" data-target="#modal-delete-{{ $materia->id }}" data-toggle="modal" class="btn btn-danger">
                      <i class="fa fa-trash-alt" aria-hidden="true"></i>
                    </a>
                  @endif
                </td>
              </tr>
              <!-- Modal para dar de baja -->
              @include('materias.modal')
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- Si no hay docentes -->
        @else
          <div class="text-center">
            <i class="fa fa-search fa-5x" aria-hidden="true"></i>
            <h4>No se encontraron materias</h4>
          </div>
        @endif
      </div>
      <!-- /.box-body -->
      <div class="card-footer">
        <div class="pull-right">
          <!-- Paginación -->
          {!! $materias->render() !!}
        </div>
      </div>
      {!! Form::close() !!}
      <!-- /.box-footer-->
    </div>
  </div>
</div>
<!-- /.box -->
@endsection