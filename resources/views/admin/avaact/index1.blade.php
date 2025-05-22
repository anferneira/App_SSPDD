@extends('Layouts.plantilla')

@section('titulo', 'Avances Actividades')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>
                        Indicadores de Producto
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importaravancemodal" title="cargar avances de actividades">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Avances Actividades</li>
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
                        <div class="col-sm-6">
                            <div class="form-group m-2">
                                <label for="id_d" class="position-relative" style="top: -25px;">Dependencia</label>
                                <select name="id_d" id="id_d" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="0" selected>Todos</option>
                                    @foreach ($dependencias as $d)
                                        <option value="{{ $d->id }}">{{ $d->nombre_d }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-2">
                                <label for="rezago" class="position-relative" style="top: -25px;">Mostrar Rezagos / Ejecutado 100% / Sin Ejecutar / Sin Programar / Desempeño</label>
                                <select name="rezago" id="rezago" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="1" selected disabled>Seleccione una opción</option>
                                    <option value="0">Mostrar todos los indicadores</option>
                                    <option value="2024_2">Ejecutado 100% 2024</option>
                                    <option value="2025_2">Ejecutado 100% 2025</option>
                                    <option value="2026_2">Ejecutado 100% 2026</option>
                                    <option value="2027_2">Ejecutado 100% 2027</option>
                                    <option value="2024_0">Rezago 2024</option>
                                    <option value="2025_0">Rezago 2025</option>
                                    <option value="2026_0">Rezago 2026</option>
                                    <option value="2027_0">Rezago 2027</option>
                                    <option value="2024_3">Sin ejecutar 2024</option>
                                    <option value="2025_3">Sin ejecutar 2025</option>
                                    <option value="2026_3">Sin ejecutar 2026</option>
                                    <option value="2027_3">Sin ejecutar 2027</option>
                                    <option value="2024_1">Sin programar 2024</option>
                                    <option value="2025_1">Sin programar 2025</option>
                                    <option value="2026_1">Sin programar 2026</option>
                                    <option value="2027_1">Sin programar 2027</option>
                                    <option value="2024_4">Desempeño Crítico 2024</option>
                                    <option value="2025_4">Desempeño Crítico 2025</option>
                                    <option value="2026_4">Desempeño Crítico 2026</option>
                                    <option value="2027_4">Desempeño Crítico 2027</option>
                                    <option value="2024_5">Desempeño Bajo 2024</option>
                                    <option value="2025_5">Desempeño Bajo 2025</option>
                                    <option value="2026_5">Desempeño Bajo 2026</option>
                                    <option value="2027_5">Desempeño Bajo 2027</option>
                                    <option value="2024_6">Desempeño Medio 2024</option>
                                    <option value="2025_6">Desempeño Medio 2025</option>
                                    <option value="2026_6">Desempeño Medio 2026</option>
                                    <option value="2027_6">Desempeño Medio 2027</option>
                                    <option value="2024_7">Desempeño Satisfactorio 2024</option>
                                    <option value="2025_7">Desempeño Satisfactorio 2025</option>
                                    <option value="2026_7">Desempeño Satisfactorio 2026</option>
                                    <option value="2027_7">Desempeño Satisfactorio 2027</option>
                                    <option value="2024_8">Desempeño Sobresaliente 2024</option>
                                    <option value="2025_8">Desempeño Sobresaliente 2025</option>
                                    <option value="2026_8">Desempeño Sobresaliente 2026</option>
                                    <option value="2027_8">Desempeño Sobresaliente 2027</option>
                                    <option value="2024_9">Desempeño Sobre Ejecutado 2024</option>
                                    <option value="2025_9">Desempeño Sobre Ejecutado 2025</option>
                                    <option value="2026_9">Desempeño Sobre Ejecutado 2026</option>
                                    <option value="2027_9">Desempeño Sobre Ejecutado 2027</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group m-2">
                                <label for="id_e" class="position-relative" style="top: -25px;">Estratégia de Desarrollo</label>
                                <select name="id_e" id="id_e" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="0" selected>Todos</option>
                                    @foreach ($estrategias as $e)
                                        <option value="{{ $e->id }}">{{ $e->codigo_e.'. '.$e->nombre_e }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-2">
                                <label for="id_dim" class="position-relative" style="top: -25px;">Dimensión de Desarrollo</label>
                                <select name="id_dim" id="id_dim" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="0" selected>Todos</option>
                                    @foreach ($dimensions as $dim)
                                        <option value="{{ $dim->id }}">{{ $dim->codigo_d.'. '.$dim->nombre_d }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-2">
                                <label for="id_a" class="position-relative" style="top: -25px;">Apuesta de Desarrollo</label>
                                <select name="id_a" id="id_a" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="0" selected>Todos</option>
                                    @foreach ($apuestas as $a)
                                        <option value="{{ $a->id }}">{{ $a->codigo_a.'. '.$a->nombre_a }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <table class="display" id="avances" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center" style="display: none;">#</th>
                                <th class="text-center">Código</th>
                                <th class="text-center" width="20%">Nombre</th>
                                <th class="text-center">% Avance 2024</th>
                                <th class="text-center">% Avance 2025</th>
                                <th class="text-center">% Avance 2026</th>
                                <th class="text-center">% Avance 2027</th>
                                <th class="text-center">% Cuatrenio</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($ips as $ip)
                                <tr class="text-center" id="ava-row-{{ $ip->id }}">
                                    <td class="text-center" style="display: none;">
                                        {{ $ip->id }}
                                    </td>
                                    <td class="text-center">
                                        {{ $ip->codigo_ip }}
                                    </td>
                                    <td class="text-start" width="20%">
                                        {{ $ip->nombre_ip }}
                                    </td>
                                    <td class="text-center">
                                        @if ($ip->porcentaje2024 == "No programado")
                                            {{ $ip->porcentaje2024 }}
                                        @else
                                            {{ $ip->porcentaje2024.' %' }}
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                    style="width: {{ $ip->porcentaje2024 }}%;" 
                                                    aria-valuenow="{{ $ip->porcentaje2024 }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100">
                                                </div>
                                            </div>    
                                        @endif
                                        @if ($ip->desemp2024 === "Crítico")
                                            <b class="badge bg-danger"><span>{{ $ip->desemp2024 }}</span></b>
                                        @else
                                            @if ($ip->desemp2024 === "Bajo")
                                                <b class="badge bg-orange"><span>{{ $ip->desemp2024 }}</span></b>
                                            @else
                                                @if ($ip->desemp2024 === "Medio")
                                                    <b class="badge bg-warning"><span>{{ $ip->desemp2024 }}</span></b>
                                                @else
                                                    @if ($ip->desemp2024 === "Satisfactorio")
                                                        <b class="badge bg-success"><span>{{ $ip->desemp2024 }}</span></b>
                                                    @else
                                                        @if ($ip->desemp2024 === "Sobresaliente")
                                                            <b class="badge bg-primary"><span>{{ $ip->desemp2024 }}</span></b>
                                                        @else
                                                            @if ($ip->desemp2024 === "Sobre Ejecutado")
                                                                <b class="badge" style="background-color: #6f42c1; color: white;"><span>{{ $ip->desemp2024 }}</span></b>
                                                            @else
                                                                <span>{{ $ip->desemp2024 }}</span>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($ip->porcentaje2025 == "No programado")
                                            {{ $ip->porcentaje2025 }}
                                        @else
                                            {{ $ip->porcentaje2025.' %' }}
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                    style="width: {{ $ip->porcentaje2025 }}%;" 
                                                    aria-valuenow="{{ $ip->porcentaje2025 }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100">
                                                </div>
                                            </div>    
                                        @endif
                                        @if ($ip->desemp2025 === "Crítico")
                                            <b class="badge bg-danger"><span>{{ $ip->desemp2025 }}</span></b>
                                        @else
                                            @if ($ip->desemp2025 === "Bajo")
                                                <b class="badge bg-orange"><span>{{ $ip->desemp2025 }}</span></b>
                                            @else
                                                @if ($ip->desemp2025 === "Medio")
                                                    <b class="badge bg-warning"><span>{{ $ip->desemp2025 }}</span></b>
                                                @else
                                                    @if ($ip->desemp2025 === "Satisfactorio")
                                                        <b class="badge bg-success"><span>{{ $ip->desemp2025 }}</span></b>
                                                    @else
                                                        @if ($ip->desemp2025 === "Sobresaliente")
                                                            <b class="badge bg-primary"><span>{{ $ip->desemp2025 }}</span></b>
                                                        @else
                                                            @if ($ip->desemp2025 === "Sobre Ejecutado")
                                                                <b class="badge" style="background-color: #6f42c1; color: white;"><span>{{ $ip->desemp2025 }}</span></b>
                                                            @else
                                                                <span>{{ $ip->desemp2025 }}</span>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($ip->porcentaje2026 == "No programado")
                                            {{ $ip->porcentaje2026 }}
                                        @else
                                            {{ $ip->porcentaje2026.' %' }}
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                    style="width: {{ $ip->porcentaje2026 }}%;" 
                                                    aria-valuenow="{{ $ip->porcentaje2026 }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100">
                                                </div>
                                            </div>    
                                        @endif
                                        @if ($ip->desemp2026 === "Crítico")
                                            <b class="badge bg-danger"><span>{{ $ip->desemp2026 }}</span></b>
                                        @else
                                            @if ($ip->desemp2026 === "Bajo")
                                                <b class="badge bg-orange"><span>{{ $ip->desemp2026 }}</span></b>
                                            @else
                                                @if ($ip->desemp2026 === "Medio")
                                                    <b class="badge bg-warning"><span>{{ $ip->desemp2026 }}</span></b>
                                                @else
                                                    @if ($ip->desemp2026 === "Satisfactorio")
                                                        <b class="badge bg-success"><span>{{ $ip->desemp2026 }}</span></b>
                                                    @else
                                                        @if ($ip->desemp2026 === "Sobresaliente")
                                                            <b class="badge bg-primary"><span>{{ $ip->desemp2026 }}</span></b>
                                                        @else
                                                            @if ($ip->desemp2026 === "Sobre Ejecutado")
                                                                <b class="badge" style="background-color: #6f42c1; color: white;"><span>{{ $ip->desemp2026 }}</span></b>
                                                            @else
                                                                <span>{{ $ip->desemp2026 }}</span>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($ip->porcentaje2027 == "No programado")
                                            {{ $ip->porcentaje2027 }}
                                        @else
                                            {{ $ip->porcentaje2027.' %' }}
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                    style="width: {{ $ip->porcentaje2027 }}%;" 
                                                    aria-valuenow="{{ $ip->porcentaje2027 }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100">
                                                </div>
                                            </div>    
                                        @endif
                                        @if ($ip->desemp2027 === "Crítico")
                                            <b class="badge bg-danger"><span>{{ $ip->desemp2027 }}</span></b>
                                        @else
                                            @if ($ip->desemp2027 === "Bajo")
                                                <b class="badge bg-orange"><span>{{ $ip->desemp2027 }}</span></b>
                                            @else
                                                @if ($ip->desemp2027 === "Medio")
                                                    <b class="badge bg-warning"><span>{{ $ip->desemp2027 }}</span></b>
                                                @else
                                                    @if ($ip->desemp2027 === "Satisfactorio")
                                                        <b class="badge bg-success"><span>{{ $ip->desemp2027 }}</span></b>
                                                    @else
                                                        @if ($ip->desemp2027 === "Sobresaliente")
                                                            <b class="badge bg-primary"><span>{{ $ip->desemp2027 }}</span></b>
                                                        @else
                                                            @if ($ip->desemp2027 === "Sobre Ejecutado")
                                                                <b class="badge" style="background-color: #6f42c1; color: white;"><span>{{ $ip->desemp2027 }}</span></b>
                                                            @else
                                                                <span>{{ $ip->desemp2027 }}</span>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $ip->porcentajecuatrenio.' %' }}
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                 style="width: {{ $ip->porcentajecuatrenio }}%;" 
                                                 aria-valuenow="{{ $ip->porcentajecuatrenio }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                        @if ($ip->desempcuatrenio === "Crítico")
                                            <b class="badge bg-danger"><span>{{ $ip->desempcuatrenio }}</span></b>
                                        @else
                                            @if ($ip->desempcuatrenio === "Bajo")
                                                <b class="badge bg-orange"><span>{{ $ip->desempcuatrenio }}</span></b>
                                            @else
                                                @if ($ip->desempcuatrenio === "Medio")
                                                    <b class="badge bg-warning"><span>{{ $ip->desempcuatrenio }}</span></b>
                                                @else
                                                    @if ($ip->desempcuatrenio === "Satisfactorio")
                                                        <b class="badge bg-success"><span>{{ $ip->desempcuatrenio }}</span></b>
                                                    @else
                                                        @if ($ip->desempcuatrenio === "Sobresaliente")
                                                            <b class="badge bg-primary"><span>{{ $ip->desempcuatrenio }}</span></b>
                                                        @else
                                                            @if ($ip->desempcuatrenio === "Sobre Ejecutado")
                                                                <b class="badge" style="background-color: #6f42c1; color: white;"><span>{{ $ip->desempcuatrenio }}</span></b>
                                                            @else
                                                                <span>{{ $ip->desempcuatrenio }}</span>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($ip->estado_ip == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $ip->estado_ip }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $ip->estado_ip }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($ip->estado_ip == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <a href="{{ route('ver_ind1', $ip->id) }}" class="ver btn btn-sm btn-info" title="ver actividades">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="importaravancemodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Cargar Avances Actividades (Archivo CSV)</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('csvavaacts') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <!-- Botón personalizado -->
                                <button class="btn btn-primary" id="customFileBtn" type="button">Seleccionar Archivo CSV</button>
                                
                                <!-- Muestra el nombre del archivo seleccionado -->
                                <span id="fileName" class="ml-2">No se ha seleccionado ningún archivo</span>
                        
                                <!-- Input de archivo oculto -->
                                <input 
                                    type="file"
                                    id="archivo_csv" 
                                    name="archivo" 
                                    accept=".csv" 
                                    style="display: none;" 
                                    required>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-success" type="submit">Importar Datos</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Muestra el selector de archivos al hacer clic en el botón
        document.getElementById('customFileBtn').addEventListener('click', function () {
            document.getElementById('archivo_csv').click(); // Simula el clic en el input de archivo oculto
        });

        // Muestra el nombre del archivo seleccionado
        document.getElementById('archivo_csv').addEventListener('change', function () {
            const fileName = this.files[0] ? this.files[0].name : 'No se ha seleccionado ningún archivo';
            document.getElementById('fileName').textContent = fileName;
        });
        $(document).ready(function() {
            // Inicializar DataTable
            $('#avances').DataTable({
                paging: true, // Activar paginación
                searching: true, // Activar barra de búsqueda
                ordering: true, // Activar ordenación de columnas
                pagingType: 'full_numbers', // Pagina completa: << < 1 2 3 > >>
                language: {
                    paginate: {
                        first: '<<',       // Primer página
                        previous: '<',     // Página anterior
                        next: '>',         // Página siguiente
                        last: '>>'         // Última página
                    },
                    url: "../plugins/datatables/idioma.json", // Traducción al español
                },
                columnDefs: [
                    { className: "text-center", orderable: false, targets: "_all" },
                    {
                        targets: 0,        // Primera columna (índice 0)
                        visible: false,    // Oculta columna
                        searchable: false
                    },
                    {
                        targets: "_all",        // A todas las columnas
                        className: "text-center align-middle"
                    }
                ]
            });
        });


        // Mostrar indicadores en rezagos, ejecutado 100%, sin programar y por dependencia
        function actualizarTablaRezago(sel) {
            const baseRutaRezago = "{{ route('rezago_ind_dep', ['id' => '__ID__']) }}";
            const baseRutaVer = "{{ route('ver_ind1', ['id' => '__ID__']) }}";
            var rez = document.getElementById('rezago').value;
            var id_dep = document.getElementById('id_d').value;
            var id_est = $('#id_e').val();
            var id_dim = $('#id_dim').val();
            var id_apu = $('#id_a').val();
            const ruta_eda = "{{ route('ind_est_dim_apu', ['id' => '__ID__']) }}";
            var id_datos = id_dep + "-" + id_est + "-" + id_dim + "-" + id_apu + "-" + sel;
            var urlRez = ruta_eda.replace('__ID__', id_datos);
            $.ajax({
                url: urlRez,
                type: 'get',
                success: function(data) {
                    // Limpiar todos los selects primero
                    const limpiarDimensiones = () => {
                        $('#id_dim').empty().append('<option value="0">Todos</option>');
                    };
                    const limpiarApuestas = () => {
                        $('#id_a').empty().append('<option value="0">Todos</option>');
                    };

                    // Helpers para cargar opciones
                    const cargarDimensiones = (dimensiones) => {
                        dimensiones.forEach(dim => {
                            $('#id_dim').append('<option value="' + dim.dimension_id + '">' + dim.dimension_codigo + '. ' + dim.dimension_nombre + '</option>');
                            if (id_dim == dim.dimension_id) {
                                $('#id_dim').val(dim.dimension_id).trigger('change');
                            }
                        });
                    };
                    const cargarApuestas = (dimensiones) => {
                        dimensiones.forEach(dim => {
                            dim.apuestas.forEach(ap => {
                                $('#id_a').append('<option value="' + ap.apuesta_id + '">' + ap.apuesta_codigo + '. ' + ap.apuesta_nombre + '</option>');
                                if (id_apu == ap.apuesta_id) {
                                    $('#id_a').val(ap.apuesta_id).trigger('change');
                                }
                            });
                        });
                    };
                    // CASO 1: Estrategia seleccionada
                    if (sel === 'id_e') {
                        limpiarDimensiones();
                        limpiarApuestas();
                        cargarDimensiones(data.dimensiones);
                        cargarApuestas(data.dimensiones);
                    }
                    else {
                        // CASO 2: Dimensión seleccionada
                        if (sel === 'id_dim') {
                            evitarEventoEstrategia = true;
                            $('#id_e').val(data.estrategia_id).trigger('change');
                            limpiarApuestas();
                            cargarApuestas(data.dimensiones);
                        }
                        else {
                            // CASO 3: Apuesta seleccionada
                            if (sel === 'id_a') {
                                evitarEventoEstrategia = true;
                                $('#id_e').val(data.estrategia_id).trigger('change');
                                evitarEventoDimension = true;
                                $('#id_dim').val(data.dimensiones[0].dimension_id).trigger('change');
                            }
                        }
                    }
                }
            });
            evitarEventoEstrategia = false;
            evitarEventoDimension = false;
            evitarEventoApuesta = false;
            if (sel === 'id_e' && id_est != '0') {
                id_dim = '0';
                id_apu = '0';
            }
            else {
                if (sel === 'id_dim' && id_dim != '0') {
                    id_est = '0';
                    id_apu = '0';
                }
                else {
                    if (sel === 'id_a' && id_apu != '0') {
                        id_est = '0';
                        id_dim = '0';
                    }
                    else {
                        if (sel === 'id_a' && id_apu === '0') {
                            id_apu = '0';
                        }
                        else {
                            if (sel === 'id_dim' && id_dim === '0') {
                                id_dim = '0';
                                id_apu = '0';
                            }
                            else {
                                if (sel === 'id_e' && id_est === '0') {
                                    id_est = '0';
                                    id_dim = '0';
                                    id_apu = '0';
                                }
                            }
                        }
                    }
                }
            }
            id_datos = rez + "-" + id_dep + "-" + id_est + "-" + id_dim + "-" + id_apu + "-" + sel;
            urlRez = baseRutaRezago.replace('__ID__', id_datos);
            $.ajax({
                url: urlRez,
                type: 'get',
                success: function(data) {
                    let tabla = $('#avances').DataTable();
                    let sel_est = $('#id_e')
                    tabla.clear();
                    data.forEach(ip => {
                        var AccionUrl = baseRutaVer.replace('__ID__', ip.id);
                        var accion = '<td class="text-center">';
                        accion += '<a href="' + AccionUrl + '" class="ver btn btn-sm btn-info" title="ver actividades">';
                        accion += '<i class="fas fa-eye"></i></a></td>';
                        tabla.row.add([
                            ip.id,
                            ip.codigo_ip,
                            ip.nombre_ip,
                            renderPorcentaje(ip.porcentaje2024, ip.desemp2024),
                            renderPorcentaje(ip.porcentaje2025, ip.desemp2025),
                            renderPorcentaje(ip.porcentaje2026, ip.desemp2026),
                            renderPorcentaje(ip.porcentaje2027, ip.desemp2027),
                            renderPorcentaje(ip.porcentajecuatrenio, ip.desempcuatrenio),
                            renderEstado(ip.estado_ip),
                            accion,
                        ]);
                    });
                    tabla.draw();
                }
            });
        }

        function renderPorcentaje(porcentaje, desempeno) {
            let html = '';

            if (porcentaje === "No programado") {
                html += porcentaje;
            } else {
                html += `${porcentaje} %`;
                html += `
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                            style="width: ${porcentaje}%;" 
                            aria-valuenow="${porcentaje}" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                        </div>
                    </div>`;
            }

            const badge = {
                "Crítico": "bg-danger",
                "Bajo": "bg-orange",
                "Medio": "bg-warning",
                "Satisfactorio": "bg-success",
                "Sobresaliente": "bg-primary",
                "Sobre Ejecutado": "bg-purple"
            };

            if (badge[desempeno]) {
                let color = badge[desempeno];
                // Estilo especial para "Sobre Ejecutado"
                if (desempeno === "Sobre Ejecutado") {
                    html += `<b class="badge" style="background-color: #6f42c1; color: white;"><span>${desempeno}</span></b>`;
                } else {
                    html += `<b class="badge ${color}"><span>${desempeno}</span></b>`;
                }
            } else {
                html += `<span>${desempeno}</span>`;
            }

            return html;
        }

        function renderEstado(estado) {
            if (estado === 'Activo') {
                return `<b class="badge bg-success estado">${estado}</b>`;
            } else {
                return `<b class="badge bg-danger">${estado}</b>`;
            }
        }
        
        let evitarEventoEstrategia = false;
        let evitarEventoDimension = false;
        let evitarEventoApuesta = false;
        let sel_anterior = null;
        let sel_actual = null;

        $('#id_d').on('change', function () {
            const baseRuta = "{{ route('cargar_select_e_d_a_d', ['id' => '__ID__']) }}";
            var id_dep = document.getElementById('id_d').value;
            var urlDep = baseRuta.replace('__ID__', id_dep);
            $.ajax({
                url: urlDep,
                type: 'get',
                success: function(data) {
                    evitarEventoEstrategia = true;
                    evitarEventoDimension = true;
                    evitarEventoApuesta = true;
                    $('#id_e').empty().append('<option value="0" selected>Todos</option>');
                    $('#id_dim').empty().append('<option value="0" selected>Todos</option>');
                    $('#id_a').empty().append('<option value="0" selected>Todos</option>');
                    data[0].forEach(est => {
                        $('#id_e').append(`<option value="${est.estrategias.id}">${est.estrategias.codigo_e}. ${est.estrategias.nombre_e}</option>`);
                    });
                    data[1].forEach(dim => {
                        $('#id_dim').append(`<option value="${dim.dimensiones.id}">${dim.dimensiones.codigo_d}. ${dim.dimensiones.nombre_d}</option>`);
                    });
                    data[2].forEach(apu => {
                        $('#id_a').append(`<option value="${apu.apuestas.id}">${apu.apuestas.codigo_a}. ${apu.apuestas.nombre_a}</option>`);
                    });
                    actualizarTablaRezago('id_e');
                }
            });
            //actualizarTablaRezago('id_e');
        });

        $('#id_e, #id_dim, #id_a').on('mousedown', function() {
            sel_anterior = document.activeElement; // El que tenía el foco antes del nuevo clic
        });
        
        $('#id_e, #id_dim, #id_a').on('change', function() {
            sel_actual = this.id;
            let evitarEvento = false;

            if (sel_actual === 'id_e') {
                evitarEvento = evitarEventoEstrategia;
            } else if (sel_actual === 'id_dim') {
                evitarEvento = evitarEventoDimension;
            } else if (sel_actual === 'id_a') {
                evitarEvento = evitarEventoApuesta;
            }

            if (!evitarEvento) {
                actualizarTablaRezago(sel_actual);
            } 
            else {
                // Desactivar la bandera solo para este select
                if (sel_actual === 'id_e') evitarEventoEstrategia = false;
                if (sel_actual === 'id_dim') evitarEventoDimension = false;
                if (sel_actual === 'id_a') evitarEventoApuesta = false;
            }
        });

        $('#rezago').on('change', function() {
            var id_e = document.getElementById('id_e').value;
            var id_dim = document.getElementById('id_dim').value;
            var id_a = document.getElementById('id_a').value;
            if (sel_actual === null || sel_actual === 'id_e') {
                actualizarTablaRezago('id_e');
            }
            else {
                if (sel_actual === 'id_dim') {
                    actualizarTablaRezago('id_dim');
                }
                else {
                    if (sel_actual === 'id_a') {
                        actualizarTablaRezago('id_a');
                    }
                }
            }
        });
    </script>    
@endsection