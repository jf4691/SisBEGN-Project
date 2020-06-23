@extends('layouts.login')

@section('titulo', 'SISBEGN | Iniciar sesión')

@section('login-msg', 'Actualizar contraseña')

@section('formulario')
{!! Form::open(['route' => ['actualizar-password', Auth::user()->id], 'autocomplete' => 'off', 'method' => 'PUT', 'files' => true]) !!}
  
    <div class="bg-body div-color">
        <h5 class="bienvenido-text">BIENVENIDO/A</h5>
        <p class="bienvenido-content">
            Usted esta iniciando sesión por primera vez en el sistema, por su seguridad antes de acceder 
            debe cambiar la contraseña que se le ha otorgado por defecto.</p>
    </div>
    <!-- Password -->
    <div class="input-group mb-3{{ $errors->has('password') ? ' has-error' : '' }}">
        <input id="password" type="password" class="my-style-input-changepass form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Nueva contraseña" name="password"/>
        {{-- {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Nueva contraseña']) !!} --}}
        <div class="input-group-append">
            <div class="input-group-text my-style-input-changepass">
              <span class="fas fa-lock" style="color: #524332"></span>
            </div>
        </div>
        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">{{ $errors->first('password') }}</span>
        @endif
    </div>
    <!-- Confirmar password -->
    <div class="input-group mb-3">
        {!! Form::password('password_confirmation', ['class' => 'form-control my-style-input-changepass', 'placeholder' => 'Confirmar nueva contraseña']) !!}
        <div class="input-group-append">
            <div class="input-group-text my-style-input-changepass">
              <span class="fas fa-lock" style="color: #524332"></span>
            </div>
        </div>
    </div>
    
    <div class="text-right">
        <button type="submit" class="btn my-btn-login"><i class="fa fa-key"></i> Cambiar</button>
    </div>
    
{!! Form::close() !!}
@endsection
