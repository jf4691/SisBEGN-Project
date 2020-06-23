@extends('layouts.general')

@section('titulo', 'SISBEGN | Inicio')

@section('encabezado', 'Perfil')

@section('subencabezado', 'Perfil')

@section('breadcrumb')
<li class="breadcrumb-item active">
  <i class="fa fa-home"></i> Inicio
</li>
@endsection

@section('contenido')
<div class="row">
  <div class="col-md-4">

    <!-- Profile Image -->
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{ asset('img/users/' . Auth::user()->imagen) }}" alt="User profile picture">
            </div>

            <h3 class="profile-username text-center" style="color: #808080">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</h3>

            <p class="text-rol text-center">{{ Auth::user()->rol->nombre }}</p>

            <a href="#" data-target="#modal-imagen" data-toggle="modal" class="btn btn-success btn-block">
              Cambiar imagen de perfil
            </a>
            <a href="#" data-target="#modal-password" data-toggle="modal" class="btn btn-success btn-block">
              Cambiar contraseña
            </a>
            @include('partials.imagen-perfil')
            @include('partials.password-perfil')
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
@endsection