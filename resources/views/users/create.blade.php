@extends('layouts.general')

@section('titulo', 'SISBEGN | Usuarios')

@section('encabezado', 'Usuarios')

@section('subencabezado', 'Registro')

@section('breadcrumb')
<li class="breadcrumb-item">
  <i class="fa fa-shield"></i> Seguridad
</li>
<li class="breadcrumb-item active">
  <a href="{{ route('users.index') }}">Usuarios</a>
</li>
<li class="breadcrumb-item active">
  Registrar Usuario
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-12">
    <!-- Box Primary -->
    <div class="card card-primary">
      <div class="card-header color-template">
        <h3 class="card-title"  style="color: #ffffff">Registrar Usuario</h3>
      </div>
      <!-- Formulario -->
      {!! Form::open(['route' => 'users.store', 'autocomplete' => 'off', 'method' => 'POST', 'files' => true, 'class' => 'form-horizontal']) !!}
        <div class="card-body my-card-body">
          <!-- Nombre -->
          <div class="form-group row{{ $errors->has('nombre') ? ' has-error' : '' }}">
            {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('nombre', old('nombre'), ['class' => 'form-control', 'placeholder' => 'Nombre del usuario', 'required']) !!}
              @if ($errors->has('nombre'))
              <span class="text-danger">{{ $errors->first('nombre') }}</span>
              @endif
            </div>
          </div>
          <!-- Apellido -->
          <div class="form-group row{{ $errors->has('apellido') ? ' has-error' : '' }}">
            {!! Form::label('apellido', 'Apellido', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('apellido', old('apellido'), ['class' => 'form-control', 'placeholder' => 'Apellido del usuario', 'required']) !!}
              @if ($errors->has('apellido'))
              <span class="text-danger">{{ $errors->first('apellido') }}</span>
              @endif
            </div>
          </div>
          <!-- Email -->
          <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', 'Correo electrónico', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Correo electrónico', 'required']) !!}
              @if ($errors->has('email'))
              <span class="text-danger">{{ $errors->first('email') }}</span>
              @endif
            </div>
          </div>
          
          <!-- Password -->
          <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::label('password', 'Contraseña', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" value="123456" placeholder="Contraseña" required readonly>
                {{-- {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña', 'required']) !!} --}}
                @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary" onClick="cGenerate();">
                    Generar contraseña
                  </button>
                </span>
              </div>
            </div>
          </div>
          
          <!-- cedula -->
          <div class="form-group row{{ $errors->has('cedula') ? ' has-error' : '' }}">
            {!! Form::label('cedula', 'Cédula', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::text('cedula', old('cedula'), ['class' => 'form-control', 'placeholder' => 'Número de Cedula Identidad', 'required', 'maxlength' => '10']) !!}
              @if ($errors->has('cedula'))
              <span class="text-danger" role="alert">{{ $errors->first('cedula') }}</span>
              @endif
            </div>
          </div>
          <!-- Rol de usuario -->
          @if(Auth::user()->admin())
          <div class="form-group row{{ $errors->has('rol_id') ? ' has-error' : '' }}">
            {!! Form::label('rol_id', 'Rol de usuario', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('rol_id', $roles, old('rol_id'), ['class' => 'form-control', 'placeholder' => '-- Seleccione un rol de usuario --', 'required']) !!}
              @if ($errors->has('rol_id'))
              <span class="text-danger">{{ $errors->first('rol_id') }}</span>
              @endif
            </div>
          </div>
          @else
          <div class="form-group row{{ $errors->has('rol_id') ? ' has-error' : '' }}" hidden>
            {!! Form::label('rol_id', 'Rol de usuario', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::select('rol_id', $roles, old('rol_id'), ['class' => 'form-control', 'required']) !!}
              @if ($errors->has('rol_id'))
              <span class="text-danger">{{ $errors->first('rol_id') }}</span>
              @endif
            </div>
          </div>
          @endif
          <!-- Imagen -->
          <div class="form-group row{{ $errors->has('imagen') ? ' has-error' : '' }}">
            {!! Form::label('imagen', 'Imagen', ['class' => 'col-sm-4 col-form-label', 'style' => 'text-align:right']) !!}
            <div class="col-sm-5">
              {!! Form::file('imagen', ['class' => 'input-alinear']) !!}
              @if ($errors->has('imagen'))
              <span class="text-danger">{{ $errors->first('imagen') }}</span>
              @endif
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="card-footer">
          <div class="float-right">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
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
<!-- InputMask -->
<script src="{{ asset('js/jquery.inputmask.js') }}"></script>
<script type="text/javascript">
  $(function () {
    $('[data-mask]').inputmask()
  });
  function randomPassword(length) {
    var chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
  }

  function cGenerate() {
    $('#password').attr('type', 'text');
    $('#password').val(randomPassword(6));
  }
</script>
@endsection