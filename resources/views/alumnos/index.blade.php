@extends('layouts.general')

@section('titulo', 'SISBEGN | Estudiantes')

@section('estilos')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('encabezado', 'Estudiantes')

@section('subencabezado', 'Gestión')

@section('breadcrumb')
<li class="breadcrumb-item active text-breadcrumb">
  <i class="fa fa-child"></i> Estudiantes 
</li>
@endsection

@section('contenido')
<style>
  .badge-new {
    background-color: #a93da9;
    color: #ffffff;
  }
  .badge-new[href]:hover,
  .badge-new[href]:focus {
    background-color: #2ae62a;
  }

  .badge-new2 {
    background-color: #3d79a9;
    color: #ffffff;
  }
  .badge-new2[href]:hover,
  .badge-new2[href]:focus {
    background-color: #2ae62a;
  }
  
</style>
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Lista de Estudiantes</h3>
      </div>
      <div class="card-body my-card-body">
        <div class="row search-margen">
          <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
            <a href="{{ route('alumnos.create') }}" class="btn btn-success float-left"><i class="fa fa-user-graduate" style="font-size:20px"></i> Nuevo Estudiante</a>
            {{-- <a href="#" data-toggle="modal" data-target="#importfile" class="btn btn-success"><i class="far fa-file-excel" style="font-size:20px"></i> Importar Excel</a> --}}
            <div class="row">
              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <div class="dropdown">
                  <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"><i class="far fa-file-excel" style="color: white;"></i> EXCEL</button>
                  
                  <ul class=" dropdown-menu">
                      <li id="import-to-excel" class="my-hover-link">
                          <a href="#" data-toggle="modal" data-target="#importfile" class="btn my-hover-link"> Importar Excel</a>
                      </li>
                      {{-- <li role="separator" class="divider"></li>
                      <li><a href="#" class="btn">Exportar</a></li> --}}
                  </ul>

                </div>
              </div>
            </div> 
          
          
          </div>
          <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
            <div class="float-right">
              <!-- Barra de búsqueda -->
              @include('alumnos.search')
            </div>
          </div>
        </div>
        <!-- Listado de alumnos -->
        @if ($alumnos->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead class="my-table-thead">
              <tr>
                <th>ID</th>
                <th>CÉDULA</th>
                <th>NOMBRE</th>
                <th>GÉNERO</th>
                <th>PERÍODO DE INGRESO</th>
                <th>ESTADO</th>
                <th>TIPO DE ESTUDIANTE</th>
                <th>ACCIONES</th>
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
                  @if($alumno->tipo === 1 && $alumno->activo === 1)
                    <span class="badge badge-new2">NUEVO</span>
                  @else
                    <span class="badge badge-new">REGULAR</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('alumnos.show', $alumno->id) }}" class="btn btn-default btn-flat" title="Ver detalle">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </a>
                  <a href="{{ route('alumnos.edit', $alumno->id) }}" class="btn btn-default btn-flat" title="Editar">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                  </a>
                  <a href="" data-target="#modal-delete-{{ $alumno->id }}" data-toggle="modal" class="btn btn-danger" title="Eliminar">
                    <i class="fa fa-trash-alt" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
              <!-- Modal para dar de baja -->
              @include('alumnos.modal')
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
    <!-- /.box -->
    <!-- Modal -->
    <div id="importfile" class="modal fade left" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content bg-info">
          <div class="modal-header">
            <h5 class="modal-title">Importar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('import.students') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <input type="file" name="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-success">Aceptar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
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