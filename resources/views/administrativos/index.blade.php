@extends('layouts.general')

@section('titulo', 'SISBEGN | Administrativos')

@section('encabezado', 'Administrativos')

@section('subencabezado', 'Gestión')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-users"></i> Personal
</li>
<li class="breadcrumb-item active">
  Administrativos
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Lista de Administrativos</h3>
      </div>
      <div class="card-body my-card-body">
        <div class="row">
          <div class="col-sm-6">
            <a href="{{ route('administrativos.create') }}" class="btn btn-success"><i class="fa fa-user-plus" style="font-size:20px"></i> Nuevo Administrativo</a>
          </div>
        <div class="col-sm-6">
            <!-- Barra de búsqueda -->
            @include('administrativos.search')
          </div>
        </div>
        <!-- Listado de administrativos -->
        @if ($administrativos->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead class="my-table-thead">
              <tr>
                <th>ID</th>
                <th>CÉDULA</th>
                <th>NOMBRE</th>
                <th>CARGO</th>
                <th>ESTADO</th>
                <th>ACCIONES</th>
              </tr>
            </thead>
            <tbody>
              @foreach($administrativos as $admin)
              {{-- @if($admin->estado!=0) --}}
              <tr>
                <td>{{ $admin->id }}</td>
                <td>{{ $admin->cedula }}</td>
                <td class="tdNombre">{{ $admin->nombre }} {{$admin->apellido}}</td>
                <td>{{ $admin->cargo }}</td>
                <td>
                  @if($admin->estado === 1)
                    <span class="badge badge-success">ACTIVO</span>
                  @else
                    <span class="badge badge-warning">INACTIVO</span>
                  @endif
                </td>
                <td>
                  {{-- <a href="#" class="btn btn-default btn-flat" 
                    data-toggle="modal" 
                    data-target="#seedegrees"
                    data-orientador="{{ json_encode($admin->administrativos[0]->grados) }}"
                    data-profesor="{{ json_encode($admin->administrativos[0]->materias) }}"
                    data-grados="{{ json_encode($grados) }}">
                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                  </a> --}}

                  <a href="{{ route('administrativos.edit', $admin->id) }}" class="btn btn-default btn-flat">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                  </a>

                  <a href="" data-target="#modal-delete-{{ $admin->id }}" data-toggle="modal" class="btn btn-danger">
                    <i class="fa fa-trash-alt" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
              <!-- Modal para dar de baja -->
              @include('administrativos.modal')
              {{-- @endif --}}
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- Si no hay docentes -->
        @else
          <div class="text-center">
            <i class="fa fa-search fa-5x" aria-hidden="true"></i>
            <h4>No se encontraron administrativos</h4>
          </div>
        @endif
      </div>
      <!-- /.box-body -->
      <div class="card-footer">
        <div class="pull-right">
          <!-- Paginación -->
          {!! $administrativos->render() !!}
        </div>
      </div>
      {!! Form::close() !!}
      <!-- /.box-footer-->
    </div>
    <!-- Modal -->
    {{-- <div  id="seedegrees" class="modal fade left" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content bg-modal-color">
          <div class="modal-header">
            <h4 class="modal-title" style="color: #efebd2">DETALLE DE ASIGNACIONES</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            
            <div id="panel_orientador" class="card my-card-color">
              <div class="card-header my-card-header">
                <h5 class="card-title" style="color: #166756">Grados asignados para Dirigente</h5>
              </div>
              <div class="card-body my-card-body-modal"> 
                <ul>
                </ul>
              </div>
            </div>

            <div id="panel_profesor" class="card my-card-color" style="margin-bottom: 0">
              <div class="card-header my-card-header">
                <h5 class="card-title" style="color: #166756">Grados que imparte clases</h5>
              </div>
              <div class="card-body my-card-body"> 
                <table class="table table-sm table-bordered" style="background-color: #cfd1d4">
                  <thead class="my-table-thead">
                    <tr>
                      <th>CÓDIGO</th>
                      <th>MATERIA</th>
                      <th>GRADO</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div> --}}
    @endsection

    @section('scripts')
    <script type="text/javascript">

      /* $('#seedegrees').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var orientador = button.data('orientador');
        var profesor = button.data('profesor');
        var grados = button.data('grados');


        var modal = $(this);
        modal.find('#panel_orientador ul').empty();
        orientador.forEach(element => {
          modal.find('#panel_orientador ul').append('<li>' + element.codigo +'</li>');
        });

        // console.log(grados);
        modal.find('#panel_profesor table tbody').empty();
        profesor.forEach(element2 => {
          if (grados[element2.pivot.grado_id]) {
            modal.find('#panel_profesor table tbody').append('<tr><td>' + element2.codigo + '</td><td>' + element2.nombre + '</td><td>' + grados[element2.pivot.grado_id] + '</td></tr>');
          }
        });
      }) */

    </script>
  </div>
</div>
<!-- /.box -->
@endsection