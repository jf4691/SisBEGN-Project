@extends('layouts.general')

@section('titulo', 'SISBEGN | Períodos Académicos')

@section('encabezado', 'Períodos Académicos')

@section('subencabezado', 'Gestión')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-users"></i> Configuración
</li>
<li class="breadcrumb-item active">
  Períodos Académicos
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Lista de Períodos Académicos</h3>
      </div>
      <div class="card-body my-card-body">
        <div class="row">
          <div class="col-sm-6">
            <a href="{{ route('anios.create') }}" class="btn btn-success"><i class="far fa-calendar-alt" style="font-size:20px"></i> Nuevo Período</a>
          </div>
        <div class="col-sm-6">
            <!-- Barra de búsqueda -->
            @include('anios.search')
          </div>
        </div>
        <!-- Listado de docentes -->
        @if ($anios->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead class="my-table-thead">
              <tr>
                <th>ID</th>
                <th>PERÍODO</th>
                <th>ACTIVO</th>
                <th>EDITABLE</th>
                <th>ESTADO</th>
                <th>ACCIONES</th>
              </tr>
            </thead>
            <tbody>
              @foreach($anios as $anio)
              <tr>
                <td>{{ $anio->id }} </td>
                <td>{{ $anio->numero }} </td>
                <td>
                  <input type="checkbox" disabled @if ($anio->activo == 1) checked @endif>
                </td>
                <td>
                  <input type="checkbox" disabled @if ($anio->editable == 1) checked @endif>
                </td>
                <td>
                  @if($anio->activo === 1)
                    <span class="badge badge-success">ACTIVO</span>
                  @else
                    <span class="badge badge-warning">INACTIVO</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('anios.edit', $anio->id) }}" class="btn btn-default btn-flat">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                  </a>
                  {{-- <a href="" data-target="#modal-delete-{{ $anio->id }}" data-toggle="modal" class="btn btn-danger">
                    <i class="fa fa-trash-alt" aria-hidden="true"></i>
                  </a> --}}
                </td>
              </tr>
              <!-- Modal para dar de baja -->
              @include('anios.modal')
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- Si no hay docentes -->
        @else
          <div class="text-center">
            <i class="fa fa-search fa-5x" aria-hidden="true"></i>
            <h4>No se encontraron Años Escolares</h4>
          </div>
        @endif
      </div>
      <!-- /.box-body -->
      <div class="card-footer">
        <div class="pull-right">
          <!-- Paginación -->
          {!! $anios->render() !!}
        </div>
      </div>
      {!! Form::close() !!}
      <!-- /.box-footer-->
    </div>
  </div>
</div>
<!-- /.box -->
@endsection