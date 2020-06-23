@extends('layouts.general')

@section('titulo', 'SISBEGN | Nivel Educativo')

@section('encabezado', 'Nivel Educativo ')

@section('subencabezado', 'Gestión')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-cog"></i> Configuración
</li>
<li class="breadcrumb-item active">
  Nivel Educativo
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Lista de Niveles Educativos</h3>
      </div>
      <div class="card-body my-card-body">
        <div class="row">
          <div class="col-sm-6">
            <a href="{{ route('nivel.create') }}" class="btn btn-success"><i class="fa fa-layer-group" style="font-size:20px"></i> Nuevo Nivel</a>
          </div>
        <div class="col-sm-6">
            <!-- Barra de búsqueda -->
            @include('nivel.search')
          </div>
        </div>
        <!-- Listado de niveles educativos -->
        @if ($nivel->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead class="my-table-thead">
              <tr>
                <th>Código</th>
                <th>Nombre</th>
                {{-- <th>Profesor</th> --}}
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach($nivel as $niveles)
              <tr>
                <td>{{ $niveles->codigo }}</td>
                <td>{{ $niveles->nombre }}</td>
                {{-- <td>{{ $niveles->orientador_materia }}</td> --}}
                <td>
                  @if($niveles->estado === 1)
                    <span class="badge badge-success">ACTIVO</span>
                  @else
                    <span class="badge badge-warning">INACTIVO</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('nivel.show', $niveles->id) }}" class="btn btn-default btn-flat">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </a>
                  <a href="{{ route('nivel.edit', $niveles->id) }}" class="btn btn-default btn-flat">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                  </a>
                  <a href="" data-target="#modal-delete-{{ $niveles->id }}" data-toggle="modal" class="btn btn-danger">
                    <i class="fa fa-trash-alt" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
              <!-- Modal para dar de baja -->
              @include('nivel.modal')
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- Si no hay docentes -->
        @else
          <div class="text-center">
            <i class="fa fa-search fa-5x" aria-hidden="true"></i>
            <h4>No se encontraron Nivel Educativo</h4>
          </div>
        @endif
      </div>
      <!-- /.box-body -->
      <div class="card-footer">
        <div class="pull-right">
          <!-- Paginación -->
        {!! $nivel->render() !!}
        </div>
      </div>
      <!-- /.box-footer-->
    </div>
  </div>
</div>
<!-- /.box -->
@endsection