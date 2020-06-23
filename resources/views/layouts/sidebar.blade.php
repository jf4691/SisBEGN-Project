<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel my-user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('img/users/'.auth()->user()->imagen) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block font-logo">{{ $nombre[0] }} {{ $apellido[0] }}</a>
            <a href="#"><i class="fas fa-circle color-online"></i><small class="font-logo1"> Online</small></a>
            <a href="#"><small class="font-logo1">{{ Auth::user()->rol->nombre }}</small></a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @include('layouts.menu')
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>