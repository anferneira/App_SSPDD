<!DOCTYPE html>

<!-- Especifica el idioma que tiene configurado la aplicación laravel (Español)-->
<html lang="{{ config('app.locale') }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Título de la aplicación | Título de la página seleccionada -->
        <title>{{ config('app.name') }} | @yield('titulo')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Icono de la aplicación en la pestaña del título -->
        <link rel="icon" href="{{ asset('imagen/escudo.png') }}">
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css') }}">
        <!-- DataTables -->
        <link href="https://nightly.datatables.net/css/dataTables.dataTables.css" rel="stylesheet" type="text/css" />
        <!-- Select2 -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
        <!-- Toastr CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">

        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        
                    </li>
                </ul>

                <div id="info"></div>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <span class="d-none d-md-inline">{{ $nombre }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <!-- User image -->
                            <div class="dropdown-header text-center bg-primary">
                                <p>
                                    {{ $nombre }} <br>
                                    <b class="badge bg-warning"> {{ $rol }} </b><br>
                                    {{ $dependencia }} <br>
                                </p>
                            </div>
                            <!-- Menu Footer-->
                            <div class="dropdown-footer bg-primary">
                                <a href="{{ route('logout') }}"
                                    class="btn btn-danger">Cerrar sesión</a>
                            </div>

                        </div>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="brand-link">
                    <img src="{{ asset('imagen/escudo.png') }}" alt="Logo" width="70px" style="margin-top: -30px; margin-left: -4px">
                    <span class="text-bolder display-4">{{ config('app.name') }}</span>
                </a>
                <!-- Sidebar -->
                <div class="sidebar">
                
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link active">
                                <i class="nav-icon fas fa-house-user"></i>
                                <p>
                                    Inicio
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active" data-bs-toggle="collapse" data-bs-target="#menu1" aria-expanded="false" aria-controls="menu1">
                                <i class="nav-icon fas fa-database"></i>
                                <p>
                                    Administración
                                    <i class="right fas fa-angle-left text-white"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('listarusuarios') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Usuarios
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('listargrupobs') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Grupos Poblacionales
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('listarprovincias') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Provincias
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link active"  data-bs-toggle="collapse" data-bs-target="#menu1" aria-expanded="false" aria-controls="menu1">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Municipios
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('listarmunicipios') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Municipios
                                            </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('listarpromuns') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Asignar Proyectos
                                            </p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link active"  data-bs-toggle="collapse" data-bs-target="#menu1" aria-expanded="false" aria-controls="menu1">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Dependencias
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('listardependencias') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Dependencias
                                            </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('listardepests') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Asignar Estrategias
                                            </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('listardepdims') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Asignar Dimensiones
                                            </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('listardepapus') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Asignar Apuestas
                                            </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('listarsectores') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Sectoriales
                                            </p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>    
                                <li class="nav-item">
                                    <a href="{{ route('listarprogramas') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Programas
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('listarestrategias') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Estrategias
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('listardimensiones') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Dimensiones
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('listarapuestas') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Apuestas
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link active"  data-bs-toggle="collapse" data-bs-target="#menu1" aria-expanded="false" aria-controls="menu1">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        ODS
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('listarodss') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                ODS
                                            </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('listarmetasodss') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Metas
                                            </p>
                                            </a>
                                        </li>    
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('listaredpms') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Estrategias EDPM
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('listarlogros') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Logros Unidos
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link active"  data-bs-toggle="collapse" data-bs-target="#menu1" aria-expanded="false" aria-controls="menu1">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Pobreza
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('listardimpobs') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Dimensiones
                                            </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('listarvarpobs') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Variables
                                            </p>
                                            </a>
                                        </li>        
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link active"  data-bs-toggle="collapse" data-bs-target="#menu1" aria-expanded="false" aria-controls="menu1">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Medidas
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('listarmedress') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Resultado
                                            </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('listarmedprods') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Producto
                                            </p>
                                            </a>
                                        </li>    
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link active"  data-bs-toggle="collapse" data-bs-target="#menu1" aria-expanded="false" aria-controls="menu1">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Indicadores
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('listarmgas') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                MGA
                                            </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('listarirs') }}" class="nav-link active">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Resultado
                                            </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link active"  data-bs-toggle="collapse" data-bs-target="#menu1" aria-expanded="false" aria-controls="menu1">
                                            <i class="nav-icon fa fa-minus"></i>
                                            <p>
                                                Producto
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                            </a>
                                            <ul class="nav nav-treeview">
                                                <li class="nav-item">
                                                    <a href="{{ route('listarips') }}" class="nav-link active">
                                                    <i class="nav-icon fa fa-circle"></i>
                                                    <p>
                                                        Producto
                                                    </p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="{{ route('listaripmos') }}" class="nav-link active">
                                                    <i class="nav-icon fa fa-circle"></i>
                                                    <p>
                                                        Asignar Metas ODS
                                                    </p>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>    
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active"  data-bs-toggle="collapse" data-bs-target="#menu1" aria-expanded="false" aria-controls="menu1">
                            <i class="nav-icon fa fa-calendar-check"></i>
                            <p>
                                Programación
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('listaracts') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Actividades
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('listarproests') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Estratégico
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('listarprofins') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Financiero
                                    </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active"  data-bs-toggle="collapse" data-bs-target="#menu1" aria-expanded="false" aria-controls="menu1">
                            <i class="nav-icon fa fa-calendar-check"></i>
                            <p>
                                Avance
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('listaravaacts') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Estratégico - Actividades
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('listaravaests') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Estratégico
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('listaravafins') }}" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Financiero
                                    </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link active"  data-bs-toggle="collapse" data-bs-target="#menu1" aria-expanded="false" aria-controls="menu1">
                            <i class="nav-icon fas fa-chart-simple"></i>
                            <p>
                                Seguimiento
                                <i class="right fas fa-angle-left"></i>
                            </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href=" {{ route('cargarlistas') }} " class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        HV Indicadores
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        SPDD 2024 - 2027
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Financiero
                                    </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link active">
                                    <i class="nav-icon fa fa-caret-right"></i>
                                    <p>
                                        Plan Abrigo
                                    </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        @yield('contenido')
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            
            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                    Todos los Derechos Reservados
                    </div>
                    <!-- Default to the left -->
                    <strong>Copyright &copy; 
                    @if (date('Y') == 2024)
                        2024.
                    @else
                        2024 - {{ date('Y') }}.
                    @endif 
                    <a href="https://www.boyaca.gov.co" target="_blank">Gobernación de Boyacá</a> - Ing Andrés Neira.</strong>
            </footer>
        </div>

        <!-- Sección de scripts -->
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!--<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>-->
        <!-- DataTables -->
        <script src="https://nightly.datatables.net/js/dataTables.js"></script>
        <!-- Ajax -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- DataTable -->
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
        <!-- Bootstrap 4.6 -->
        <!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('/dist/js/adminlte.min.js') }}"></script>
        <!-- Font-Awesome Icons -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Select2 -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        @yield('scripts')
        <script>
            let inactivityTime = 5 * 60 * 1000; // 5 minutos en milisegundos
            let timeout;
        
            function resetTimer() {
                clearTimeout(timeout);
                timeout = setTimeout(logoutUser, inactivityTime);
        
                // Guardar la última página en localStorage si no es login
                if (!window.location.href.includes("login")) {
                    localStorage.setItem('lastVisitedPage', window.location.href);
                }
            }
        
            function logoutUser() {
                window.location.href = "{{ route('logout') }}";
            }
        
            // Redirigir a la última página después del login
            window.onload = function() {
                let lastPage = localStorage.getItem('lastVisitedPage');
        
                if (lastPage && window.location.href.includes("login")) {
                    localStorage.removeItem('lastVisitedPage'); // Evita bucle infinito
        
                    setTimeout(() => {
                        window.location.href = lastPage;
                    }, 500);
                }
        
                resetTimer();
            };
        
            // Eventos que reinician el temporizador
            document.addEventListener("mousemove", resetTimer);
            document.addEventListener("keypress", resetTimer);
            document.addEventListener("scroll", resetTimer);
            document.addEventListener("click", resetTimer);

            async function mostrarInfo() {
                const infoDiv = document.getElementById('info');

                try {
                    const pais = 'Colombia';

                    // Obtener fecha y hora actual con formato personalizado
                    const ahora = new Date();
                    const opciones = {
                    weekday: 'long',    // día de la semana
                    day: '2-digit',
                    month: 'long',      // mes completo
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                    };

                    const fechaHora = ahora.toLocaleString('es-ES', opciones)
                    .replace(',', '.') // Cambiar la coma por punto
                    .replace(' a. m.', ' am') // Ajustar formato AM/PM
                    .replace(' p. m.', ' pm');

                    // Capitalizar primera letra del día
                    const fechaHoraCapitalizada = fechaHora.charAt(0).toUpperCase() + fechaHora.slice(1);

                    // Mostrar en el div
                    infoDiv.innerHTML = `🌍 País: <strong>${pais}</strong><br>📅 Fecha: <strong>${fechaHoraCapitalizada}</strong>`;
                } catch (error) {
                    infoDiv.innerHTML = 'Error al obtener la información.';
                    console.error(error);
                }
            }

            mostrarInfo();
            setInterval(mostrarInfo, 1000); // actualizar cada segundo
        </script>
               
    </body>
</html>