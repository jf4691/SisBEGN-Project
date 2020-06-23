@extends('layouts.general')

@section('titulo', 'SISBEGN | Niveles Educativos')

@section('encabezado', 'Nivel Educativo')

@section('subencabezado', 'Detalle')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-cog"></i> Configuración
</li>
<li class="breadcrumb-item">
  <a href="{{ route('nivel.index') }}">Niveles Educativos</a>
</li>
<li class="breadcrumb-item active">
  Detalle del Nivel Educativo
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">{{ $nivel->nombre }}</h3>
      </div>
      <div class="card-body my-card-body">
        <div class="row">
          <div class="col-sm-6">
            <h4 style="color: #051798;">Detalle</h4>
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-quitar-margen">
                <tr>
                  <td class="tdNombre"><strong>Nombre:</strong> {{ $nivel->nombre }}</td>
                </tr>
                <tr>
                  <td class="tdNombre"><strong>Código:</strong> {{ $nivel->codigo }}</td>
                </tr>
                @if ($nivel->orientador_materia == 1)
                <tr>
                  <td class="tdNombre"><strong>Profesor dirigente imparte todas las materias</strong></td>
                </tr>
                @endif
                <tr>
                  <td class="tdNombre"><strong>Registro:</strong> {{ \Carbon\Carbon::parse($nivel->created_at)->format('d/m/Y - H:i:s') }}</td>
                </tr>
                <tr>
                  <td class="tdNombre"><strong>Última modificación:</strong> {{ \Carbon\Carbon::parse($nivel->updated_at)->format('d/m/Y - H:i:s') }}</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="col-sm-6">
            <h4 style="color: #051798;">Materias</h4>
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-quitar-margen">
                <thead class="my-table-thead">
                  <tr>
                    <th>CÓDIGO</th>
                    <th>NOMBRE</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($nivel->materias as $materia)
                  <tr>
                    <td>{{ $materia->codigo }}</td>
                    <td>{{ $materia->nombre }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="card-footer">
      </div>
      <!-- /.box-footer-->
    </div>
  </div>
</div>
<!-- /.box -->
@endsection