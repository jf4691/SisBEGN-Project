@extends('layouts.login')

@section('titulo', 'SISBEGN | Iniciar sesión')

@section('login-msg', 'Usuario denegado')

@section('formulario')

    <h4>Usted ya no tiene acceso al sistema</h4> <br>
    <a href="{{ route('login') }}"><i class="fa fa-arrow-left"></i> Volver</a>

@endsection