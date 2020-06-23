@extends('layouts.general')

@section('titulo', 'SISBEGN | Usuarios')

@section('encabezado', 'Usuarios')

@section('subencabezado', 'Gestión')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-shield"></i> Seguridad
</li>
<li class="breadcrumb-item active">
  Usuarios
</li>
@endsection

@section('contenido')
<style>
  
</style>
<!-- Box Primary -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Lista de Usuarios</h3>
      </div>
      <div class="card-body my-card-body">
        <div class="row">
          <div class="col-sm-6">
            <a href="{{ route('users.create') }}" class="btn btn-success"><i class="fa fa-user-plus" style="font-size:20px"></i> Nuevo Usuario</a>
          </div>
          <div class="col-sm-6">
            <!-- Barra de búsqueda -->
            @include('users.search')
          </div>
          <div class="col-sm-12">
            <div class="form-group bg-body my-bg-body color-template">
              <h5 class="text-filter-color"><strong>FILTRAR POR ROL:</strong></h5>
              @foreach ($roles as $rol)
              <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="roles_search" value="{{ $rol->id }}" id="rol_{{ $rol->id }}">
                  <label class="form-check-label text-color-check" for="rol_{{ $rol->id }}">
                      {{ $rol->nombre }}
                  </label>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <!-- Listado de usuarios -->
        @if ($users->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead class="my-table-thead">
              <tr>
                <th>ID</th>
                <th>CÉDULA</th>
                <th>NOMBRES</th>
                <th>ROL</th>
                <th>ESTADO</th>
                <th>ACCIONES</th>
              </tr>
            </thead>
            <tbody id="body_table">
              @foreach($users as $user)
              <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->cedula }}</td>
                <td class="tdNombre">{{ $user->nombre }} {{ $user->apellido }}</td>
                <td>{{ $user->rol->nombre }}</td>
                <td>
                  @if($user->estado === 1)
                    <span class="badge badge-success">ACTIVO</span>
                  @else
                    <span class="badge badge-warning">INACTIVO</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('users.show', $user->id) }}" class="btn btn-default btn-flat">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                  </a>
                  <a href="{{ route('users.edit', $user->id) }}" class="btn btn-default btn-flat">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                  </a>
                  @if ($user->rol_id === 1)
                  @else
                  <a href="" data-target="#modal-delete-{{ $user->id }}" data-toggle="modal" class="btn btn-danger">
                    <i class="fa fa-trash-alt" aria-hidden="true"></i>
                  </a>
                  @endif
                </td>
              </tr>
              <!-- Modal para dar de baja -->
              @include('users.modal')
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- Si no hay usuarios -->
        @else
          <div class="text-center">
            <i class="fa fa-search fa-5x" aria-hidden="true"></i>
            <h4>No se encontraron usuarios</h4>
          </div>
        @endif
      </div>
      <!-- /.box-body -->
      <div class="card-footer">
        <div class="pull-right">
          <!-- Paginación -->
          {!! $users->render() !!}
        </div>
      </div>
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $("input[name='roles_search']").click(function(){
      var roles_ids = [];
      $.each($("input[name='roles_search']:checked"), function(){
        roles_ids.push($(this).val());
      });

      $.ajax({
        type : 'GET',
        url : '{{ url("/api/getusers") }}',
        data:{'roles':roles_ids},
        success:function(data){
          $('#body_table').empty();
          $('#body_table').append(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            var errorMsg = 'Ajax request failed: ' + xhr.responseText;
            console.log('error');
        }
      });

    });
  });
</script>
@endsection