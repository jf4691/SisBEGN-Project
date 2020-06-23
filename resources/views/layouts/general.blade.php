<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Título -->
    <title>@yield('titulo', 'SISBEGN')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"> {{--
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}"> --}}
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <!-- Agregar estilos -->
    @yield('estilos')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Mis estilos -->
    <link rel="stylesheet" href="{{ asset('css/mis-estilos.css') }}">
    <!-- Favicon -->
    <link rel="favicon" href="{{ asset('img/sistema/favicon.png') }}" />
    <link rel="shortcut icon" href="{{ asset('img/sistema/favicon.ico') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">


    {{-- <link rel="stylesheet" href="https://bootswatch.com/4/journal/bootstrap.min.css"> --}}

    <style>
        body {
            font-size: 11pt;
            font-family: 'Nunito', sans-serif, Arial;





        }
        
        th {
            text-align: center;
            /* border: 1px solid #c7c7c1 !important; */
        }
        
        .tdNombre {
            text-align: justify !important;
        }
        
        td {
            text-align: center;
            /* border: 1px solid #c7c7c4 !important; */
        }
    </style>

</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->

<body class="hold-transition sidebar-mini layout-boxed">
    <?php
    // Nombre corto de usuario autentificado.
    $nombre = explode(' ', Auth::user()->nombre);
    $apellido = explode(' ', Auth::user()->apellido);
    $anio = \Carbon\Carbon::now()->format('Y');
    ?>
        <!-- Site wrapper -->
        <div class="wrapper">

            <!-- Navbar -->
            <nav class="main-header my-header-color navbar navbar-expand navbar-simiWhite">
              <!-- Left navbar links -->
              <ul class="navbar-nav">
                  <li class="nav-item">
                      <a class="nav-link pushmenu-color" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                  </li>
              </ul>

              <!-- Right navbar links -->
              

              <ul class="navbar-nav ml-auto">
                  <!-- Messages Dropdown Menu -->
                  <li class="nav-item dropdown">
                      <div class="dropdown">
                          <button class="btn btn-link dropdown-toggle my-dropdown-menu" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <img src="{{ asset('img/users/'.auth()->user()->imagen) }}" class="profile-user-img img-sm  img-circle " alt="User Image" />
                              <span class="hidden-xs text-dropdownlogin-color" style="font-size: 11pt;">
                                {{ $nombre[0] }} {{ $apellido[0] }}
                                
                              </span>
                              
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item" href="{{ route('home') }}">Perfil</a>
                              <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                              </form>
                          </div>
                      </div>
                  </li> 
              </ul>
            </nav>
            <!-- =============================================== -->

            <!-- Main Sidebar Container -->
        <aside class="main-sidebar my-sidebar-color elevation-4">
          <!-- Brand Logo -->
          <a href="/home" class="brand-link my-user-panel my-header-color">
              <img src="{{asset('img/sistema/logo3.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
              <span class="brand-text font-logo-color">SisBEGN</span>
          </a>

          <!-- Sidebar -->
          @include('layouts.sidebar')
          <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper my-content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="text-encabezado">
                  @yield('encabezado', 'Encabezado')
                  <small class="text-subencabezado">@yield('subencabezado')</small>
                </h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  @yield('breadcrumb')
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>
    
        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            @include('flash::message')
            @yield('contenido')
          </div>
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer no-print" style="max-height: 100px;text-align: center">
          <!-- To the right -->
          <div class="float-right d-none d-sm-inline">
          </div>
          <!-- Default to the left -->
          <strong>Copyright &copy; {{$anio}} <a href="#"> Fer+10</a>.</strong> Todos los derechos reservados.
      </footer>
  </div>
  <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
        <!-- Agregar scripts -->
        @yield('scripts')
</body>

</html>