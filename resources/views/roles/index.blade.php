@extends('layouts.general')

@section('titulo', 'SISBEGN | Roles de usuario')

@section('encabezado', 'Roles de usuario')

@section('subencabezado', 'Gestión')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-shield"></i> Seguridad
</li>
<li class="breadcrumb-item active">
  Roles de usuario
</li>
@endsection

@section('contenido')
<!-- Box Primary -->
<div class="card card-primary">
  <div class="card-header color-template">
    <h3 class="card-title"  style="color: #ffffff">Lista de Roles de Usuario</h3>
  </div>
  <div class="card-body my-card-body">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" hidden>
        <a href="{{ route('roles.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo Rol</a>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="">
      	  <!-- Barra de búsqueda -->
          @include('roles.search')
        </div>
      </div>
    </div>
  	<!-- Listado de roles de usuario -->
  	@if ($roles->count() > 0)
  	<div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead class="my-table-thead">
          <tr>
            {{-- <th>ID</th> --}}
            {{-- <th>Código</th> --}}
            <th>NOMBRE ROL</th>
            {{-- <th>ACCIONES</th> --}}
          </tr>
        </thead>
        <tbody>
          @foreach($roles as $rol)
          <tr>
            {{-- <td>{{ $rol->id }}</td> --}}
            {{-- <td>{{ $rol->codigo }}</td> --}}
            <td>{{ $rol->nombre }}</td>
            {{-- <td>
              <a href="{{ route('roles.edit', $rol->id) }}" class="btn btn-default btn-flat">
                <i class="fa fa-edit" aria-hidden="true"></i>
              </a>
              <a href="" data-target="#modal-delete-{{ $rol->id }}" data-toggle="modal" class="btn btn-danger">
                <i class="fa fa-trash-alt" aria-hidden="true"></i>
              </a>
            </td> --}}
          </tr>
          <!-- Modal para dar de baja -->
          @include('roles.modal')
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- Si no hay roles de usuario -->
    @else
      <div class="text-center">
        <i class="fa fa-search fa-5x" aria-hidden="true"></i>
        <h4>No se encontraron roles de usuario</h4>
      </div>
    @endif
  </div>
  <!-- /.box-body -->
  <div class="card-footer">
    <div class="pull-right">
    	<!-- Paginación -->
      {!! $roles->render() !!}
    </div>
  </div>
  <!-- /.box-footer-->
</div>
<!-- /.box -->
@endsection