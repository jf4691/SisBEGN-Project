<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('titulo', 'SISBEGN')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}"> --}}
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <!-- Agregar estilos -->
  @yield('estilos')
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- Mis estilos -->
  <link rel="stylesheet" href="{{ asset('css/mis-estilos.css') }}">
  <!-- Favicon -->
  <link rel="favicon" href="{{ asset('img/sistema/favicon.png') }}" />
  <link rel="shortcut icon" href="{{ asset('img/sistema/favicon.ico') }}" />
  <link rel="stylesheet" href="https://bootswatch.com/4/cerulean/bootstrap.min.css">
</head>
<body class="hold-transition login-page login-fondo">

<div class="login-box">
  <div class="login-logo">
    <a href="#"><b></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card my-login-card1">
    <div class="card-body login-card-body my-login-card">
      <div class="row">
        <div class="col-md-12">
          <img src="{{ asset('img/sistema/logo3.png') }}" class="my-img-login" alt="logo_colegio">
        </div>
        
      </div>
      
      <p class="login-box-msg iniciar-sesion-color"><b>@yield('login-msg', 'Texto')</b></p>
      @yield('formulario')
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>


<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

<!-- Agregar scripts -->
@yield('scripts')
</body>
</html>
