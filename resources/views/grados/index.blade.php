@extends('layouts.general')

@section('titulo', 'SISBEGN | Grados')

@section('estilos')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('encabezado', 'Grados')

@section('subencabezado', 'Gestión')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-users"></i> Gestión Académica
</li>
<li class="breadcrumb-item active">
  Grados
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
<!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Lista de Grados</h3>
      </div>
      <div class="card-body my-card-body">
        <div class="row search-margen">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <a href="{{ route('grados.create') }}" class="btn btn-success"><i class="fa fa-list" style="font-size:20px"></i> Nuevo Grado</a>
          </div>
          <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <div class="float-right">
              <!-- Barra de búsqueda -->
              @include('grados.search')
            </div>
          </div>
        </div>
        <!-- Listado de grados -->
        @if ($grados->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead class="my-table-thead">
              <tr>
                <th>ID</th>
                <th>CÓDIGO</th>
                <th>NIVEL</th>
                <th>SECCIÓN</th>
                <th>PERÍODO</th>
                <th>PROFESOR DIRIGENTE</th>
                <th>ESTADO</th>
                <th>ACCIONES</th>
              </tr>
            </thead>
            <tbody>
              @foreach($grados as $grado)
              <tr>
                <td>{{ $grado->id }}</td>
                <td>{{ $grado->codigo }}</td>
                <td>{{ $grado->nombre }}</td>
                <td>{{ $grado->seccion }}</td>
                <td>{{ $grado->numero }}</td>
                <td class="tdNombre">{{ $grado->nombreDocente }} {{ $grado->apellidoDocente }}</td>
                <td>
                  @if($grado->estado === 1)
                    <span class="badge badge-success">ACTIVO</span>
                  @else
                    <span class="badge badge-warning">INACTIVO</span>
                  @endif
                </td>
                <td>
                  @if(Auth::user()->admin())
                    <button class="btn btn-default btn-flat"
                      data-toggle="modal" 
                      data-target="#enable_notes" 
                      data-registro="{{$grado->registros}}"
                      data-action="{{route('grados.update', $grado->id)}}">
                      <i class="fa fa-key" aria-hidden="true"></i>
                    </button>
                  @endif
                  <a href="{{ route('grados.edit', $grado->id) }}" class="btn btn-default btn-flat">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                  </a>

                  {{-- @if($grado->activo === 0) --}}
                  <a href="" data-target="#modal-delete-{{ $grado->id }}" data-toggle="modal" class="btn btn-danger">
                    <i class="fa fa-trash-alt" aria-hidden="true"></i>
                  </a>
                  {{-- @endif --}}
                </td>
              </tr>
              <!-- Modal para dar de baja -->
              @include('grados.modal')
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- Si no hay grados-->
        @else
          <div class="text-center">
            <i class="fa fa-search fa-5x" aria-hidden="true"></i>
            <h4>No se encontraron docentes</h4>
          </div>
        @endif
      </div>
      <!-- /.box-body -->
      <div class="card-footer">
        <div class="pull-right">
          <!-- Paginación -->
          {!! $grados->render() !!}
        </div>
      </div>
      {!! Form::close() !!}
      <!-- /.box-footer-->
    </div>
    {{-- Modal para habilitar las notas --}}
    <div id="enable_notes" class="modal fade left" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h6 style="font-size: 1.3em; color: #4a4a4a"><b>HABILITAR PARCIALES</b></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="#" method="post" id="up_registro">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <div class="modal-body" style="font-size: 12pt; color: #4a4a4a">

              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" id="parcial_1" name="enablenotes" value="parcial_1">
                <label class="custom-control-label" for="parcial_1">Parcial 1</label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" id="parcial_2" name="enablenotes" value="parcial_2">
                <label class="custom-control-label" for="parcial_2">Parcial 2</label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" id="supletorio" name="enablenotes" value="supletorio">
                <label class="custom-control-label" for="supletorio">Nota Supletorio</label>
              </div>
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" id="ninguno" name="enablenotes" value="ninguno">
                <label class="custom-control-label" for="ninguno">Ninguno</label>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-success">Activar</button>
            </div>
          </form>
        </div>
      </div>
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
  });
  $('#enable_notes').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var tmp_reg = button.data('registro');
    var action = button.data('action');

    var modal = $(this);

    modal.find('#up_registro').attr('action', action);

    switch (tmp_reg) {
      case 'parcial_1':
        modal.find('.modal-body #parcial_1').prop('checked', true);
        break;
      case 'parcial_2':
        modal.find('.modal-body #parcial_2').prop('checked', true);
        break;
      case 'supletorio':
        modal.find('.modal-body #supletorio').prop('checked', true);
        break;
      default:
        modal.find('.modal-body #ninguno').prop('checked', true);
        break;
    };
  })
</script>
@endsection