@extends('layouts.general')

@section('titulo', 'SISBEGN | Roles de usuario')

@section('encabezado', 'Roles de usuario')

@section('subencabezado', 'Registro')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-shield"></i> Seguridad
</li>
<li class="breadcrumb-item active">
  <a href="{{ route('roles.index') }}">Roles de usuario</a>
</li>
<li class="breadcrumb-item active">
  Registrar Rol de Usuario
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
    <!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Registrar Rol de Usuario</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => 'roles.store', 'autocomplete' => 'off', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">
          <!-- Código -->
          <div class="form-group row{{ $errors->has('codigo') ? ' has-error' : '' }}">
            {!! Form::label('codigo', 'Código', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('codigo', old('codigo'), ['class' => 'form-control', 'placeholder' => 'Ej: admin', 'required', 'id' => 'codigo']) !!}
              @if ($errors->has('codigo'))
                <span class="invalid-feedback" role="alert">{{ $errors->first('codigo') }}</span>
              @endif
            </div>
          </div>
          <!-- Nombre -->
          <div class="form-group row{{ $errors->has('nombre') ? ' has-error' : '' }}">
            {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              <input type="text" name="nombre" value="{{old('nombre')}}" id="nombre" class="form-control">
              {{-- <select name="nombre" id="nombre" class="form-control" required>
                <option value="">Seleccione un nombre</option>
                <option value="Secretaria" data-codigo="secre">Secretaria</option>
                <option value="Docente" data-codigo="docen">Docente</option>
                <option value="Estudiante" data-codigo="estud">Estudiante</option>
              </select> --}}
              
              @if ($errors->has('nombre'))
              <span class="text-danger">{{ $errors->first('nombre') }}</span>
              @endif
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
          </div>
        </div>
      {!! Form::close() !!}
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->
  </div>
</div>
@endsection

@section('scripts')
  <script type="text/javascript">
    /* document.getElementById('nombre').onchange = function() {
      
      var mOption = this.options[this.selectedIndex];
      
      var mData = mOption.dataset;
      
      var cod = document.getElementById('codigo');
      
      cod.value = mData.codigo;
    }; */
  </script>
@endsection