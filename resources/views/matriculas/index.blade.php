@extends('layouts.general')

@section('titulo', 'SISBEGN | Matrículas')

@section('estilos')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('encabezado', 'Matrículas')

@section('subencabezado', 'Gestión')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-clipboard"></i> Matrículas
</li>
@endsection

@section('contenido')
<style>
  .badge-new {
    background-color: #2176ca;
    color: #ffffff;
  }
  .badge-new[href]:hover,
  .badge-new[href]:focus {
    background-color: #2ae62a;
  }
  .badge-encurso {
    background-color: #44a792;
    color: #ffffff;
  }
  .badge-encurso[href]:hover,
  .badge-encurso[href]:focus {
    background-color: #44a792;
  }
  

</style>
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff" style="color: #ffffff">Lista de Matrículas</h3>
      </div>
      <div class="card-body my-card-body">
        <div class="row search-margen">
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <a href="{{ route('matriculas.create') }}" class="btn btn-success"><i class="fa fa-id-card" style="font-size: 1em"></i> Nueva Matrícula</a>
          </div>
          <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <div class="float-right">
              <!-- Barra de búsqueda -->
              @include('matriculas.search')
            </div>
          </div>
        </div>
        <!-- Listado de matrículas -->
        @if ($matriculas->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead class="my-table-thead">
              <tr>
                <th>ID</th>
                <th>CÉDULA</th>
                <th>NOMBRE ESTUDIANTE</th>
                <th>GRADO</th>
                <th>PERÍODO ACADÉMICO</th>
                {{-- <th>FECHA MATRÍCULA</th>
                <th>FECHA DE RETIRO</th> --}}
                <th>REGISTRO</th>
                <th>ESTADO</th>
                <th>ACCIONES</th>
              </tr>
            </thead>
            <tbody>
              @foreach($matriculas as $matricula)
              <tr>
                <td>{{ $matricula->id }}</td>
                <td>{{ $matricula->cedula }}</td>
                <td class="tdNombre">{{ $matricula->apellido }} {{ $matricula->nombre }}</td>
                <td>{{ $matricula->codigo }}</td>
                <td>{{ $matricula->numero }}</td>
                {{-- <td>{{ \Carbon\Carbon::parse($matricula->created_at)->format('d/m/Y') }}</td>
                @if ($matricula->desercion == null)
                  <td></td>
                @else
                  <td>{{ \Carbon\Carbon::parse($matricula->desercion)->format('d/m/Y') }}</td>
                @endif --}}
                <td> 
                  @if($matricula->condicion === 1)
                    <span class="badge badge-new">MATRICULADO</span>
                  @else
                    <span class="badge badge-dark">RETIRADO</span>
                  @endif
                </td>
                <td>
                  @switch($matricula->estado_alumno)
                    @case('promovido')
                      <span class="badge badge-success">PROMOVIDO</span>
                      @break
                    @case('reprobado')
                      <span class="badge badge-danger">REPROBADO</span>
                      @break
                    @default
                      <span class="badge badge-encurso">EN CURSO <i class="fa fa-spinner fa-spin"></i></span>
                      @break
                  @endswitch
                </td>
                <td>
                  @if ($matricula->editable == 1)
                  <a href="{{ route('matriculas.edit', $matricula->id) }}" class="btn btn-default btn-flat" title="Editar">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                  </a>
                  <a href="" data-target="#modal-delete-{{ $matricula->id }}" data-toggle="modal" class="btn btn-danger" title="Eliminar">
                    <i class="fa fa-trash-alt" aria-hidden="true"></i>
                  </a>
                  @endif
                </td>
              </tr>
              <!-- Modal para eliminar matrícula -->
              @include('matriculas.modal')
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- Si no hay matrículas -->
        @else
          <div class="text-center">
            <i class="fa fa-search fa-5x" aria-hidden="true"></i>
            <h4>No se encontraron matrículas</h4>
          </div>
        @endif
      </div>
      <!-- /.box-body -->
      <div class="card-footer">
        <div class="pull-right">
          <!-- Paginación -->
          {!! $matriculas->render() !!}
        </div>
      </div>
      <!-- /.box-footer-->
    </div>
  </div>
</div>
<!-- /.box -->
@endsection

@section('scripts')
<!-- Select2 -->
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>
@endsection