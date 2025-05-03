@extends('Layouts.plantilla')

@section('titulo', 'HV Indicadores')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Indicadores
                        <a href="{{ route('cargarhvi') }}" class="btn btn-primary">
                            HV Indicadores
                        </a>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Lista de Indicadores</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title text-left">Consultas</h3>
                    <a href="" class="btn btn-info ml-auto text-right" id="id_filtros">
                        Borrar Filtros
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group m-2">
                                <label for="id_e" class="position-relative" style="top: -25px;">Estrategias de Desarrollo</label>
                                <select name="id_e" id="id_e" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="" disabled selected>Seleccionar</option>
                                    @foreach ($estrategias as $e)
                                        <option value="{{ $e->id }}">{{ $e->codigo_e.'. '.$e->nombre_e }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group m-2">
                                <label for="id_dim" class="position-relative" style="top: -25px;">Dimensiones de Desarrollo</label>
                                <select name="id_dim" id="id_dim" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="" disabled selected>Seleccionar</option>
                                    @foreach ($dimensiones as $d)
                                        <option value="{{ $d->id }}">{{ $d->codigo_d.'. '.$d->nombre_d }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group m-2">
                                <label for="id_a" class="position-relative" style="top: -25px;">Apuestas de Desarrollo</label>
                                <select name="id_a" id="id_a" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="" disabled selected>Seleccionar</option>
                                    @foreach ($apuestas as $a)
                                        <option value="{{ $a->id }}">{{ $a->codigo_a.'. '.(strlen($a->nombre_a) > 120 ? substr($a->nombre_a, 0, 120).'...' : $a->nombre_a) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group m-2">
                                <label for="id_dep" class="position-relative" style="top: -25px;">Dependencia Responsable</label>
                                <select name="id_dep" id="id_dep" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="" disabled selected>Seleccionar</option>
                                    @foreach ($dependencias as $d)
                                        <option value="{{ $d->id }}">{{ $d->nombre_d }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <table class="display" id="ips">
                            <thead class="text-center">
                                <tr class="text-center">
                                    <th class="text-center">Código</th>
                                    <th class="text-center">Descripción del Indicador</th>
                                </tr>
                            </thead>
    
                            <tbody class="text-justify">
                                @foreach ($ips as $ip)
                                    <tr class="text-center" id="ip-row-{{ $ip->id }}">
                                        <td class="text-center">
                                            {{ $ip->codigo_ip }}
                                        </td>
                                        <td class="text-justify">
                                            {{ $ip->descripcion_ip }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>    
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Inicializar DataTable

            $('#ips').DataTable({
                debug: true,
                paging: true, // Activar paginación
                searching: true, // Activar barra de búsqueda
                ordering: false, // Activar ordenación de columnas
                pagingType: 'full_numbers', // Pagina completa: << < 1 2 3 > >>
                language: {
                    paginate: {
                        first: '<<',       // Primer página
                        previous: '<',     // Página anterior
                        next: '>',         // Página siguiente
                        last: '>>'         // Última página
                    },
                    url: "../plugins/datatables/idioma.json", // Traducción al español
                }
            });
        });

        // Función para actualizar la tabla de indicadores
        function actualizarTabla(data) {
            var table = $('#ips').DataTable(); // Obtén la instancia actual de DataTable
            table.clear();
            data.forEach(function(item) {
                table.row.add([
                    item.codigo,      // El código del indicador
                    item.descripcion  // La descripción del indicador
                ]);
            });
            table.draw();
        }

        // Cuando se cambie el valor de la estrategia
        $('#id_e').on('change', function () {
            var id_e = $(this).val();
            tomarRutasEstrategia(id_e);
        });

        // Cuando se cambie el valor de la dimensión
        $('#id_dim').on('change', function () {
            var id_dim = $(this).val();
            tomarRutasDimension(id_dim);
        });

        // Cuando se cambie el valor de la apuesta
        $('#id_a').on('change', function () {
            var id_a = $(this).val();
            tomarRutasApuesta(id_a);
        });

        // Cuando se cambie el valor de la dependencia
        $('#id_dep').on('change', function () {
            var id_d = $(this).val();
            tomarRutasDependencia(id_d);
        });

        // Cuando se borra los filtros de los select y mostrar tabla con todos los indicadores
        $('#id_filtros').on('click', function () {
            var borrar = 1;
            var url = "{{ route('borrarFiltros', ['id' => ':id']) }}".replace(':id', borrar);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var $estSelect = $('#id_e');
                    $estSelect.empty();
                    $estSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Estrategia) {
                        $estSelect.append('<option value="' + Estrategia.id + '">' + Estrategia.codigo_e + '. ' + Estrategia.nombre_e + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
            borrar = 2;
            url = "{{ route('borrarFiltros', ['id' => ':id']) }}".replace(':id', borrar);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var $dimSelect = $('#id_dim');
                    $dimSelect.empty();
                    $dimSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Dimension) {
                        $dimSelect.append('<option value="' + Dimension.id + '">' + Dimension.codigo_d + '. ' + Dimension.nombre_d + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
            borrar = 3;
            url = "{{ route('borrarFiltros', ['id' => ':id']) }}".replace(':id', borrar);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var $apuSelect = $('#id_a');
                    $apuSelect.empty();
                    $apuSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Apuesta) {
                        $apuSelect.append('<option value="' + Apuesta.id + '">' + Apuesta.codigo_a + '. ' + Apuesta.nombre_a + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
            borrar = 4;
            url = "{{ route('borrarFiltros', ['id' => ':id']) }}".replace(':id', borrar);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var $depSelect = $('#id_dep');
                    $depSelect.empty();
                    $depSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Dependencia) {
                        $depSelect.append('<option value="' + Dependencia.id + '">' + Dependencia.nombre_d + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
            borrar = 5;
            url = "{{ route('borrarFiltros', ['id' => ':id']) }}".replace(':id', borrar);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });

        // Función para tomar rutas cuando seleccione valor de estrategia
        function tomarRutasEstrategia(id_e) {
            var urlEstrategia = "{{ route('porest', ['id' => ':id']) }}".replace(':id', id_e);
            var urlDimension = "{{ route('actdim1', ['id' => ':id']) }}".replace(':id', id_e);
            var urlApuesta = "{{ route('actapu1', ['id' => ':id']) }}".replace(':id', id_e);
            var urlDependencia = "{{ route('actdp1', ['id' => ':id']) }}".replace(':id', id_e);
            actualizarSelectsEstrategia(urlEstrategia, urlDimension, urlApuesta, urlDependencia);
        }

        // Función para tomar rutas cuando seleccione valor de dimension
        function tomarRutasDimension(id_dim) {
            var urlEstrategia = "{{ route('actest1', ['id' => ':id']) }}".replace(':id', id_dim);
            var urlDimension = "{{ route('pordim', ['id' => ':id']) }}".replace(':id', id_dim);
            var urlApuesta = "{{ route('actapu2', ['id' => ':id']) }}".replace(':id', id_dim);
            var urlDependencia = "{{ route('actdp2', ['id' => ':id']) }}".replace(':id', id_dim);
            actualizarSelectsDimension(urlEstrategia, urlDimension, urlApuesta, urlDependencia);
        }

        // Función para tomar rutas cuando seleccione valor de apuesta
        function tomarRutasApuesta(id_a) {
            var urlEstrategia = "{{ route('actest2', ['id' => ':id']) }}".replace(':id', id_a);
            var urlDimension = "{{ route('actdim2', ['id' => ':id']) }}".replace(':id', id_a);
            var urlApuesta = "{{ route('porapu', ['id' => ':id']) }}".replace(':id', id_a);
            var urlDependencia = "{{ route('actdp3', ['id' => ':id']) }}".replace(':id', id_a);
            actualizarSelectsApuesta(urlEstrategia, urlDimension, urlApuesta, urlDependencia);
        }

        // Función para tomar rutas cuando seleccione valor de dependencia
        function tomarRutasDependencia(id_d) {
            var urlEstrategia = "{{ route('actest3', ['id' => ':id']) }}".replace(':id', id_d);
            var urlDimension = "{{ route('actdim3', ['id' => ':id']) }}".replace(':id', id_d);
            var urlApuesta = "{{ route('actapu3', ['id' => ':id']) }}".replace(':id', id_d);
            var urlDependencia = "{{ route('pordep', ['id' => ':id']) }}".replace(':id', id_d);
            actualizarSelectsDependencia(urlEstrategia, urlDimension, urlApuesta, urlDependencia);
        }

        // Traer datos por estrategia
        function actualizarSelectsEstrategia(urlEstrategia, urlDimension, urlApuesta, urlDependencia) { 
            // Mostrar tabla por estrategia
            $.ajax({
                url: urlEstrategia,
                type: 'get',
                success: function(data) {
                    actualizarTabla(data);
                }
            });

            // Actualizar select dimensión
            $.ajax({
                url: urlDimension,
                type: 'get',
                success: function(data) {
                    var $dimSelect = $('#id_dim');
                    $dimSelect.empty();
                    $dimSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Dimension) {
                        $dimSelect.append('<option value="' + Dimension.id + '">' + Dimension.codigo_d + '. ' + Dimension.nombre_d + '</option>');
                    });
                }
            });

            // Actualizar select apuesta
            $.ajax({
                url: urlApuesta,
                type: 'get',
                success: function(data) {
                    var $apuSelect = $('#id_a');
                    $apuSelect.empty();
                    $apuSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Apuesta) {
                        $apuSelect.append('<option value="' + Apuesta.id + '">' + Apuesta.codigo_a + '. ' + Apuesta.nombre_a + '</option>');
                    });
                }
            });

            // Actualizar select dependencia
            $.ajax({
                url: urlDependencia,
                type: 'get',
                success: function(data) {
                    var $depSelect = $('#id_dep');
                    $depSelect.empty();
                    $depSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Dependencia) {
                        $depSelect.append('<option value="' + Dependencia.id + '">' + Dependencia.nombre_d + '</option>');
                    });
                }
            });
        }

        // Traer datos por dimensión
        function actualizarSelectsDimension(urlEstrategia, urlDimension, urlApuesta, urlDependencia) { 
            // Mostrar tabla por dimensión
            $.ajax({
                url: urlDimension,
                type: 'get',
                success: function(data) {
                    actualizarTabla(data);
                }
            });

            // Actualizar select estrategia
            $.ajax({
                url: urlEstrategia,
                type: 'get',
                success: function(data) {
                    var $estSelect = $('#id_e');
                    $estSelect.empty();
                    $estSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Estrategia) {
                        $estSelect.append('<option value="' + Estrategia.id + '">' + Estrategia.codigo_e + '. ' + Estrategia.nombre_e + '</option>');
                    });
                }
            });

            // Actualizar select apuesta
            $.ajax({
                url: urlApuesta,
                type: 'get',
                success: function(data) {
                    var $apuSelect = $('#id_a');
                    $apuSelect.empty();
                    $apuSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Apuesta) {
                        $apuSelect.append('<option value="' + Apuesta.id + '">' + Apuesta.codigo_a + '. ' + Apuesta.nombre_a + '</option>');
                    });
                }
            });

            // Actualizar select dependencia
            $.ajax({
                url: urlDependencia,
                type: 'get',
                success: function(data) {
                    var $depSelect = $('#id_dep');
                    $depSelect.empty();
                    $depSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Dependencia) {
                        $depSelect.append('<option value="' + Dependencia.id + '">' + Dependencia.nombre_d + '</option>');
                    });
                }
            });
        }

        // Traer datos por apuesta
        function actualizarSelectsApuesta(urlEstrategia, urlDimension, urlApuesta, urlDependencia) { 
            // Mostrar tabla por apuesta
            $.ajax({
                url: urlApuesta,
                type: 'get',
                success: function(data) {
                    actualizarTabla(data);
                }
            });

            // Actualizar select dimensión
            $.ajax({
                url: urlDimension,
                type: 'get',
                success: function(data) {
                    var $dimSelect = $('#id_dim');
                    $dimSelect.empty();
                    $dimSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Dimension) {
                        $dimSelect.append('<option value="' + Dimension.id + '">' + Dimension.codigo_d + '. ' + Dimension.nombre_d + '</option>');
                    });
                }
            });

            // Actualizar select estrategia
            $.ajax({
                url: urlEstrategia,
                type: 'get',
                success: function(data) {
                    var $estSelect = $('#id_e');
                    $estSelect.empty();
                    $estSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Estrategia) {
                        $estSelect.append('<option value="' + Estrategia.id + '">' + Estrategia.codigo_e + '. ' + Estrategia.nombre_e + '</option>');
                    });
                }
            });

            // Actualizar select dependencia
            $.ajax({
                url: urlDependencia,
                type: 'get',
                success: function(data) {
                    var $depSelect = $('#id_dep');
                    $depSelect.empty();
                    $depSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Dependencia) {
                        $depSelect.append('<option value="' + Dependencia.id + '">' + Dependencia.nombre_d + '</option>');
                    });
                }
            });
        }

        // Traer datos por dependencia
        function actualizarSelectsDependencia(urlEstrategia, urlDimension, urlApuesta, urlDependencia) { 
            // Mostrar tabla por dependencia
            $.ajax({
                url: urlDependencia,
                type: 'get',
                success: function(data) {
                    actualizarTabla(data);
                }
            });

            // Actualizar select dimensión
            $.ajax({
                url: urlDimension,
                type: 'get',
                success: function(data) {
                    var $dimSelect = $('#id_dim');
                    $dimSelect.empty();
                    $dimSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Dimension) {
                        $dimSelect.append('<option value="' + Dimension.id + '">' + Dimension.codigo_d + '. ' + Dimension.nombre_d + '</option>');
                    });
                }
            });

            // Actualizar select apuesta
            $.ajax({
                url: urlApuesta,
                type: 'get',
                success: function(data) {
                    var $apuSelect = $('#id_a');
                    $apuSelect.empty();
                    $apuSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Apuesta) {
                        $apuSelect.append('<option value="' + Apuesta.id + '">' + Apuesta.codigo_a + '. ' + Apuesta.nombre_a + '</option>');
                    });
                }
            });

            // Actualizar select estrategia
            $.ajax({
                url: urlEstrategia,
                type: 'get',
                success: function(data) {
                    var $estSelect = $('#id_e');
                    $estSelect.empty();
                    $estSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Estrategia) {
                        $estSelect.append('<option value="' + Estrategia.id + '">' + Estrategia.codigo_e + '. ' + Estrategia.nombre_e + '</option>');
                    });
                }
            });
        }

        /*$('#id_e').on('change', function () {
            var id_e = $(this).val();
            var url = "{{ route('porest', ['id' => ':id']) }}";
            url = url.replace(':id', id_e);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var table = $('#ips').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    table = $('#ips').DataTable();
                    data.forEach (function (item) {
                        table.row.add([
                            item.codigo,      // El código del indicador
                            item.descripcion    // El nombre del indicador
                        ]);
                    });
                    table.draw();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $('#id_dim').on('change', function () {
            var id_d = $(this).val();
            var url = "{{ route('pordim', ['id' => ':id']) }}";
            url = url.replace(':id', id_d);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var table = $('#ips').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    table = $('#ips').DataTable();
                    data.forEach (function (item) {
                        table.row.add([
                            item.codigo,      // El código del indicador
                            item.descripcion    // El nombre del indicador
                        ]);
                    });
                    table.draw();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $('#id_a').on('change', function () {
            var id_a = $(this).val();
            var url = "{{ route('porapu', ['id' => ':id']) }}";
            url = url.replace(':id', id_a);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var table = $('#ips').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    table = $('#ips').DataTable();
                    data.forEach (function (item) {
                        table.row.add([
                            item.codigo,      // El código del indicador
                            item.descripcion    // El nombre del indicador
                        ]);
                    });
                    table.draw();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $('#id_dep').on('change', function () {
            var id_d = $(this).val();
            var url = "{{ route('pordep', ['id' => ':id']) }}";
            url = url.replace(':id', id_d);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var table = $('#ips').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    table = $('#ips').DataTable();
                    data.forEach (function (item) {
                        table.row.add([
                            item.codigo,      // El código del indicador
                            item.descripcion    // El nombre del indicador
                        ]);
                    });
                    table.draw();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });*/
    </script>    
@endsection