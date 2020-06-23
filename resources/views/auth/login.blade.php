@extends('layouts.login')

@section('titulo', 'SISBEGN | Iniciar sesión')

@section('login-msg', 'Iniciar Sesión')

@section('formulario')
<form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
  @csrf
  <div class="input-group mb-3">
    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} my-style-input" placeholder="Correo electrónico" name="email" value="{{ old('email') }}" required />
    <div class="input-group-append">
      <div class="input-group-text my-style-input">
        <span class="fas fa-envelope color-icons"></span>
      </div>
    </div>
    @if ($errors->has('email'))
      <span class="invalid-feedback" role="alert">{{ $errors->first('email') }}</span>
    @endif
  </div>

  <div class="input-group mb-3">
    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} my-style-input" placeholder="Contraseña" name="password" required />
    <div class="input-group-append">
      <div class="input-group-text my-style-input">
        <span class="fas fa-lock color-icons"></span>
      </div>
    </div>
    @if ($errors->has('password'))
      <span class="invalid-feedback" role="alert">{{ $errors->first('password') }}</span>
    @endif
  </div>

  <div class="row">
    <div class="col-7">
      <div class="icheck-primary">
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="style-recordarme" for="remember">
          Recordarme
        </label>
      </div>
    </div>
      <!-- /.col -->
    <div class="col-5">
      <button type="submit" class="btn my-btn-login float-right"><i class="fas fa-sign-in-alt"></i> Acceder</button>
    </div>
      <!-- /.col -->
  </div>
</form>
<br>
<div class="alert alert-info my-alert-color">
  <p class="mb-1 my-info-text">
    <i class="fa fa-circle"></i>
    <b class="my-info-text2">ESTUDIANTES: </b>En caso de olvidar su contraseña solicite a la secretaria restablecer su contraseña.
  </p>
  <p class="mb-1 my-info-text">
    <i class="fa fa-circle"></i>
    <b class="my-info-text2">DOCENTES/ADMINISTRATIVOS: </b>En caso de olvidar su contraseña solicite al administrador restablecer su contraseña.
  </p>
</div>


@endsection
