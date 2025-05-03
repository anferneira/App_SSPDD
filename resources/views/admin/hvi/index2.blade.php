@extends('Layouts.plantilla')

@section('titulo', 'HV Indicadores')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Hoja de Vida de Indicadores
                        <a href="{{ route('cargarlistas') }}" class="btn btn-primary">
                            Lista de Indicadores
                        </a>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">HV Indicadores</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Consultas</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group m-2">
                                <label for="id_ip" class="position-relative" style="top: -25px;">Indicador</label>
                                <select name="id_ip" id="id_ip" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="" disabled selected>Seleccionar</option>
                                    @foreach ($ips as $i)
                                        <option value="{{ $i->id }}">{{ $i->codigo_ip }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group m-2">
                                <label for="id_mga" class="position-relative" style="top: -25px;">Indicador MGA</label>
                                <label for="id_mga" id="mga" class="position-relative h3" style="top: -25px;"></label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group m-2">
                                <label for="frec" class="position-relative" style="top: -25px;">Frecuencia de Medición</label>
                                <label for="frec" id="frec" class="position-relative h3" style="top: -25px;"></label>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group m-2">
                                <label for="id_anio" class="position-relative" style="top: -25px;">Año</label>
                                <select name="id_anio" id="id_anio" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="0" selected>Todos</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group m-2">
                                <label for="id_trimestre" class="position-relative" style="top: -25px;">Trimestre</label>
                                <select name="id_trimestre" id="id_trimestre" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="0" selected>Todos</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>      
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row container-fluid">
                        <div class="table-responsive">
                            <table class="table w-100" id="ips">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th class="text-center">Estrategia de Desarollo</th>
                                        <th class="text-center">Dependencia Responsable</th>
                                        <th class="text-center">Tipo de Indicador</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    <tr class="text-center">
                                        <td id="est" class="text-center"></th>
                                        <td id="dep" class="text-center"></th>
                                        <td id="tip" class="text-center"></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row container-fluid">
                        <div class="table-responsive">
                            <table class="table w-100" id="ips">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th class="text-center">Dimensión de Desarrollo</th>
                                        <th class="text-center">Apuesta de Desarrollo</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    <tr class="text-center">
                                        <td id="dim" class="text-center"></th>
                                        <td id="apu" class="text-center"></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row container-fluid">
                        <div class="table-responsive">
                            <table class="table w-100" id="ips">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th class="text-center">Nombre del Indicador</th>
                                        <th class="text-center">Descripción del Indicador</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    <tr class="text-center">
                                        <td id="nom" class="text-center"></th>
                                        <td id="desc" class="text-center"></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row container-fluid">
                        <div class="table-responsive">
                            <table class="table w-100" id="ips">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th class="text-center">Medido a Través de</th>
                                        <th class="text-center">Programación Cuatrenio</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    <tr class="text-center">
                                        <td id="med" class="text-center"></th>
                                        <td id="cuat" class="text-center"></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row container-fluid">
                        <div class="table-responsive">
                            <table class="table w-100" id="acts">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th class="text-center">Código</th>
                                        <th class="text-center" width="80%">Actividad</th>
                                        <th class="text-center">Valor Programado</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    
                                </tbody>
                            </table>
                        </div>
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

            $('#acts').DataTable({
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

        $('#id_ip').on('change', function () {
            var IndId = $(this).val();
            var url = "{{ route('verindicador', ['id' => ':id']) }}";
            url = url.replace(':id', IndId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#mga').text(data.mga.codigo_mga);
                    $('#frec').text(data.frecuencia_ip);
                    $('#est').text(data.apuesta.dimension.estrategia_dimension.codigo_e + '. ' + data.apuesta.dimension.estrategia_dimension.nombre_e);
                    $('#dep').text(data.dependencia.nombre_d);
                    $('#tip').text(data.orientar.nombre_o);
                    $('#dim').text(data.apuesta.dimension.codigo_d + '. ' + data.apuesta.dimension.nombre_d);
                    $('#apu').text(data.apuesta.codigo_a + '. ' + data.apuesta.nombre_a);
                    $('#nom').text(data.nombre_ip);
                    $('#desc').text(data.descripcion_ip);
                    $('#med').text(data.medida.medido_mp);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
            var IndActId = $(this).val();
            var url = "{{ route('veractividades', ['id' => ':id']) }}";
            url = url.replace(':id', IndActId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var table = $('#acts').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    var cu = 0;
                    // Procesar los datos
                    data.forEach(function(item) {
                        // Convertir el valor de 'aporte_a' a número, asegurándose de manejar casos no válidos
                        var aporte = parseFloat((item.aporte_a).replace(',', '.'));
                        if (cu == 0) {
                            var cuatrenio = parseFloat((item.meta_a).replace(',', '.'));
                            $('#cuat').text(cuatrenio.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                            cu = 1;
                        }
                        var aporteFormateado = aporte.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        // Agregar filas a la tabla
                        table.row.add([
                            item.codigo_a,
                            item.nombre_a,
                            aporteFormateado
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
            /*var IndId = $(this).val();
            var url = "{{ route('cuatrenio1', ['id' => ':id']) }}";
            url = url.replace(':id', IndId);
            console.log(url);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    //$('#cuat').text(parseFloat(data[0].cuatrenio).toFixed(2)); // Muestra el valor directamente
                    $('#cuat').text(data[0].cuatrenio); // Muestra el valor directamente
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });*/
        });

        $('#id_anio').on('change', function () {
            var AnioId = $(this).val();
            var IndId = document.getElementById('id_ip').value;
            var TriId = document.getElementById('id_trimestre').value;
            var url = "{{ route('veractividades_anio', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var table = $('#acts').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    data.forEach(function(item) {
                        table.row.add([
                            item.codigo_a,
                            item.nombre_a,
                            item.aporte_a
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

        $('#id_trimestre').on('change', function () {
            var AnioId = document.getElementById('id_anio').value;
            var IndId = document.getElementById('id_ip').value;
            var TriId = $(this).val();
            var url = "{{ route('veractividades_anio', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var table = $('#acts').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    data.forEach(function(item) {
                        table.row.add([
                            item.codigo_a,
                            item.nombre_a,
                            item.aporte_a
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



        // Función para actualizar la tabla de indicadores
        /*function actualizarTabla(data) {
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

        // Función para actualizar los selects dependiendo de la estrategia seleccionada
        function actualizarSelectsEstrategia(id_e) {
            var urlEstrategia = "{{ route('porest', ['id' => ':id']) }}".replace(':id', id_e);
            var urlDimension = "{{ route('actdim1', ['id' => ':id']) }}".replace(':id', id_e);
            var urlApuesta = "{{ route('actapu1', ['id' => ':id']) }}".replace(':id', id_e);
            var urlDependencia = "{{ route('actdp1', ['id' => ':id']) }}".replace(':id', id_e);
            
            // Actualizar los selects de acuerdo a la estrategia
            $.ajax({
                url: urlEstrategia,
                type: 'get',
                success: function(data) {
                    actualizarTabla(data);
                }
            });

            $.ajax({
                url: urlDimension,
                type: 'get',
                success: function(data) {
                    var $dimSelect = $('#id_dim');
                    $dimSelect.empty();
                    $dimSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    $dimSelect.append('<option value="0">Mostrar Todo</option>');
                    data.forEach(function(dimension) {
                        $dimSelect.append('<option value="' + dimension.id + '">' + dimension.codigo_d + '. ' + dimension.nombre_d + '</option>');
                    });
                }
            });
            
            $.ajax({
                url: urlApuesta,
                type: 'get',
                success: function(data) {
                    var $apuSelect = $('#id_a');
                    $apuSelect.empty();
                    $apuSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    $apuSelect.append('<option value="0">Mostrar Todo</option>');
                    data.forEach(function(apuesta) {
                        $apuSelect.append('<option value="' + apuesta.id + '">' + apuesta.codigo_a + '. ' + apuesta.nombre_a + '</option>');
                    });
                }
            });
            console.log(urlDependencia);
            $.ajax({
                url: urlDependencia,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    var $depSelect = $('#id_dep');
                    $depSelect.empty();
                    $depSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    $depSelect.append('<option value="0">Mostrar Todo</option>');
                    data.forEach(function(dependencia) {
                        $depSelect.append('<option value="' + dependencia.id + '">' + dependencia.nombre_d + '</option>');
                    });
                }
            });
        }

        // Cuando se cambie el valor de la estrategia
        $('#id_e').on('change', function () {
            var id_e = $(this).val();
            actualizarSelectsEstrategia(id_e);
        });

        // Función para actualizar los selects dependiendo de la estrategia seleccionada
        function actualizarSelectsDimension(id_d) {
            var urlDimension = "{{ route('pordim', ['id' => ':id']) }}".replace(':id', id_d);
            var urlEstrategia = "{{ route('actest1', ['id' => ':id']) }}".replace(':id', id_d);
            var urlApuesta = "{{ route('actapu2', ['id' => ':id']) }}".replace(':id', id_d);
            var urlDependencia = "{{ route('actdp2', ['id' => ':id']) }}".replace(':id', id_d);
            
            // Actualizar los selects de acuerdo a la estrategia
            $.ajax({
                url: urlDimension,
                type: 'get',
                success: function(data) {
                    actualizarTabla(data);
                }
            });

            $.ajax({
                url: urlEstrategia,
                type: 'get',
                success: function(data) {
                    var $estSelect = $('#id_e');
                    $estSelect.empty();
                    $estSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    $estSelect.append('<option value="0">Mostrar Todo</option>');
                    data.forEach(function(estrategia) {
                        $estSelect.append('<option value="' + estrategia.id + '">' + estrategia.codigo_e + '. ' + estrategia.nombre_e + '</option>');
                    });
                }
            });
            
            $.ajax({
                url: urlApuesta,
                type: 'get',
                success: function(data) {
                    var $apuSelect = $('#id_a');
                    $apuSelect.empty();
                    $apuSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    $apuSelect.append('<option value="0">Mostrar Todo</option>');
                    data.forEach(function(apuesta) {
                        $apuSelect.append('<option value="' + apuesta.id + '">' + apuesta.codigo_a + '. ' + apuesta.nombre_a + '</option>');
                    });
                }
            });
            console.log(urlDependencia);
            $.ajax({
                url: urlDependencia,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    var $depSelect = $('#id_dep');
                    $depSelect.empty();
                    $depSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    $depSelect.append('<option value="0">Mostrar Todo</option>');
                    data.forEach(function(dependencia) {
                        $depSelect.append('<option value="' + dependencia.id + '">' + dependencia.nombre + '</option>');
                    });
                }
            });
        }

        // Cuando se cambie el valor de la dimensión
        $('#id_dim').on('change', function () {
            var id_dim = $(this).val();
            actualizarSelectsDimension(id_dim);
        });

        // Cuando se cambie el valor de la apuesta
        $('#id_a').on('change', function () {
            var id_a = $(this).val();
            var url = "{{ route('porapu', ['id' => ':id']) }}".replace(':id', id_a);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    actualizarTabla(data);
                }
            });
        });

        // Cuando se cambie el valor de la dependencia
        $('#id_dep').on('change', function () {
            var id_d = $(this).val();
            var url = "{{ route('pordep', ['id' => ':id']) }}".replace(':id', id_d);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    actualizarTabla(data);
                }
            });
        });
        
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