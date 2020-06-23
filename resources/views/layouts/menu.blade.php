@if (Auth::user()->admin())
    <li class="nav-header headerColorMenu">ADMINISTRACIÓN</li>
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link active color-sidebar-menu">
            <i class="nav-icon"><img src="{{asset('img/icons/shield.png')}}" alt="seguridad" class="style-icon-menu"></i>
            <p>Seguridad</p>
            
            <i class="right fas fa-angle-left"></i>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link color-submenu my-color-submenu">
                    <i class="nav-icon" style="margin-left:8%"><img src="{{asset('img/icons/users.png')}}" alt="seguridad" class="style-icon-menu"></i>
                    <p class="pull-right-container color-subtext">Usuarios</p>
                    <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon" style="margin-left:15%"><img src="{{asset('img/icons/add-user.png')}}" alt="seguridad" class="style-icon-menu"></i>
                            <p class="style-submenu">Registrar Usuario</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.inactiveUsers') }}" class="nav-link">
                            <i class="nav-icon" style="margin-left:15%"><img src="{{asset('img/icons/inactive-users.png')}}" alt="seguridad" class="style-icon-menu"></i>
                            <p class="style-submenu">Usuarios Inactivos</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link color-submenu">
                    <i class="nav-icon" style="margin-left:8%"><img src="{{asset('img/icons/rol1.png')}}" alt="seguridad" class="style-icon-menu"></i>
                    <p class="color-subtext">Roles de usuario</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-item has-treeview">
        <a href="#" class="nav-link active color-sidebar-menu">
            <i class="nav-icon"><img src="{{asset('img/icons/cog2.png')}}" alt="seguridad" class="style-icon-menu"></i>
            <p>Configuración</p>
            <i class="right fas fa-angle-left"></i>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('anios.index') }}" class="nav-link">
                    <i class="nav-icon" style="margin-left:8%"><img src="{{asset('img/icons/periodo.png')}}" alt="seguridad" class="style-icon-menu"></i>
                    <p class="style-submenu">Períodos Académicos</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('materias.index') }}" class="nav-link">
                    <i class="nav-icon" style="margin-left:8%"><img src="{{asset('img/icons/materias1.png')}}" alt="seguridad" class="style-icon-menu"></i>
                    <p class="style-submenu">Materias</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('nivel.index') }}" class="nav-link">
                    <i class="nav-icon" style="margin-left:8%"><img src="{{asset('img/icons/niveles.png')}}" alt="seguridad" class="style-icon-menu"></i>
                    <p class="style-submenu">Niveles</p>
                </a>
            </li>
        </ul>
    </li>

    <li class="nav-header headerColorMenu">PERSONAL</li>
    <li class="nav-item has-treeview">
        <li class="nav-item">
            <a href="{{ route('administrativos.index') }}" class="nav-link active color-sidebar-menu">
                <i class="nav-icon"><img src="{{asset('img/icons/administrativos1.png')}}" alt="seguridad" class="style-icon-menu"></i>
                <p>Administrativos</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('docentes.index') }}" class="nav-link active color-sidebar-menu">
                <i class="nav-icon"><img src="{{asset('img/icons/docentes1.png')}}" alt="seguridad" class="style-icon-menu"></i>
                <p>Docentes</p>
            </a>
        </li>
    </li>
@endif

@if (Auth::user()->admin() || Auth::user()->secre())
    <li class="nav-header headerColorMenu">GESTIÓN ACADÉMICA</li>
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link active color-sidebar-menu">
            <i class="nav-icon"><img src="{{asset('img/icons/estudiantes.png')}}" alt="seguridad" class="style-icon-menu"></i>
            <p>Estudiantes</p>
            <i class="right fas fa-angle-left"></i>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('alumnos.index') }}" class="nav-link">
                    <i class="nav-icon" style="margin-left:8%"><img src="{{asset('img/icons/add-student.png')}}" alt="seguridad" class="style-icon-menu"></i>
                    <p class="style-submenu">Registrar Estudiante</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('alumnos.inactiveStudents') }}" class="nav-link">
                    <i class="nav-icon" style="margin-left:8%"><img src="{{asset('img/icons/inactive-users.png')}}" alt="seguridad" class="style-icon-menu"></i>
                    <p class="style-submenu">Estudiantes Inactivos</p>
                </a>
            </li>
        </ul>
        <li class="nav-item">
            <a href="{{ route('grados.index') }}" class="nav-link active color-sidebar-menu">
                <i class="nav-icon"><img src="{{asset('img/icons/asignacion1.png')}}" alt="seguridad" class="style-icon-menu"></i>
                <p>Grados/Asignaciones</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('matriculas.index') }}" class="nav-link active color-sidebar-menu">
                <i class="nav-icon"><img src="{{asset('img/icons/matricula.png')}}" alt="seguridad" class="style-icon-menu"></i>
                <p>Matrículas</p>
            </a>
        </li>
    </li>

    <li class="nav-header headerColorMenu">REPORTES</li>
    <li class="nav-item">
        <a href="{{ route('notas.index') }}" class="nav-link active color-sidebar-menu">
            <i class="nav-icon"><img src="{{asset('img/icons/reportes.png')}}" alt="seguridad" class="style-icon-menu"></i>
            <p>Reportes de notas</p>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a href="{{ route('reportes') }}" class="nav-link active color-sidebar-menu">
            <i class="nav-icon"><img src="{{asset('img/icons/reportes1.png')}}" alt="seguridad" class="style-icon-menu"></i>
            <p>Otros reportes</p>
        </a>
    </li> --}}
@endif

@if (Auth::user()->secre())
    <li class="nav-header headerColorMenu">CONFIGURACIÓN</li>
    <li class="nav-item has-treeview">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link active color-sidebar-menu">
                <i class="nav-icon"><img src="{{asset('img/icons/perfil.png')}}" alt="seguridad" class="style-icon-menu"></i>
                <p>Perfil</p>
            </a>
        </li>
    </li>
@endif

@if (Auth::user()->docen())
    <li class="nav-header headerColorMenu">GESTIÓN DE NOTAS</li>
    <li class="nav-item has-treeview">
        <li class="nav-item">
          <a href="{{ route('notas.index') }}" class="nav-link active color-sidebar-menu">
            <i class="nav-icon"><img src="{{asset('img/icons/register-nota.png')}}" alt="seguridad" class="style-icon-menu"></i> 
            <p>Notas</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link active color-sidebar-menu">
            <i class="nav-icon"><img src="{{asset('img/icons/perfil.png')}}" alt="seguridad" class="style-icon-menu"></i> 
            <p>Perfil</p>
          </a>
        </li>
    </li>
@endif
{{-- Alumno --}}
@if (Auth::user()->estud())
    <li class="nav-header headerColorMenu">MÓDULO</li>
    <li class="nav-item has-treeview">
        <li class="nav-item">
          <a href="{{ route('notas.index') }}" class="nav-link active color-sidebar-menu">
            <i class="nav-icon"><img src="{{asset('img/icons/ver-notas.png')}}" alt="seguridad" class="style-icon-menu"></i> 
            <p>Calificaciones</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link active color-sidebar-menu">
            <i class="nav-icon"><img src="{{asset('img/icons/perfil.png')}}" alt="seguridad" class="style-icon-menu"></i>
            <p>Perfil</p>
          </a>
        </li>
    </li>
@endif