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
            // Verificar si hay un mensaje almacenado en localStorage
            /*let message = localStorage.getItem("toastr_message");
            if (message) {
                toastr.success(message);
                // Eliminar el mensaje para que no se vuelva a mostrar
                localStorage.removeItem("toastr_message");
            }*/
        });

        // Cuando se cambie el valor de la dependencia
        /*$('#id_d').on('change', function () {
            var id_d = $(this).val();
            var rez = $('#rezago').prop('checked');
            var urlDependencia = " route('dep_indi', ['id' => ':id']) ".replace(':id', id_d);
            $.ajax({
                url: urlDependencia,
                type: 'get',
                success: function(data) {
                    var table = $('#avances').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();

                    data.forEach(function(item) {
                        // Construcción del estado con la clase de color correcta
                        var estado = "<td class='text-center'>";
                        estado += item.estado_ip === 'Activo' 
                            ? "<b class='badge bg-success estado'>" + item.estado_ip + "</b></td>"
                            : "<b class='badge bg-danger'>" + item.estado_ip + "</b></td>";

                        // Construcción de la acción con el botón de ver
                        var AccionUrl = "{{ route('ver_ind1', ['id' => ':id']) }}".replace(':id', item.id);
                        var accion = '<td class="text-center">';
                        accion += '<a href="' + AccionUrl + '" class="ver btn btn-sm btn-info" title="ver actividades">';
                        accion += '<i class="fas fa-eye"></i></a></td>';
                        

                        // Función para generar celdas con barras de progreso
                        function generateProgressCellDesemp(percentage, desemp) {
                            let des = '';                            
                            if (percentage === "No programado") {
                                return `<td class="text-center">${percentage}</td>`;
                            }

                            if (desemp === "Crítico") {
                                des += `<b class="badge bg-danger"><span>${desemp}</span></b>`;
                            }
                            else {
                                if (desemp === "Bajo") {
                                    des += `<b class="badge bg-orange"><span>${desemp}</span></b>`;
                                }
                                else {
                                    if (desemp === "Medio") {
                                        des += `<b class="badge bg-warning"><span>${desemp}</span></b>`;
                                    }
                                    else {
                                        if (desemp === "Satisfactorio") {
                                            des += `<b class="badge bg-success"><span>${desemp}</span></b>`;
                                        }
                                        else {
                                            if (desemp === "Sobresaliente") {
                                                des += `<b class="badge bg-primary"><span>${desemp}</span></b>`;
                                            }
                                            else {
                                                if (desemp === "Sobre Ejecutado") {
                                                    des += `<b class="badge" style="background-color: #6f42c1; color: white;"><span>${desemp}</span></b>`;
                                                }
                                                else
                                                    des += desemp;
                                            }
                                        }
                                    }
                                }
                            }
                            return `
                                <td class="text-center">
                                    ${percentage} %
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                            style="width: ${percentage}%;" 
                                            aria-valuenow="${percentage}" 
                                            aria-valuemin="0" 
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                    ${des}
                                </td>
                            `;
                        }

                        // Agregar la fila a la tabla
                        table.row.add([
                            item.codigo_ip,   // Código del indicador
                            item.nombre_ip,   // Nombre del indicador
                            generateProgressCellDesemp(item.porcentaje2024, item.desemp2024), // % Avance 2024 con barra
                            generateProgressCellDesemp(item.porcentaje2025, item.desemp2025), // % Avance 2025 con barra
                            generateProgressCellDesemp(item.porcentaje2026, item.desemp2026), // % Avance 2026 con barra
                            generateProgressCellDesemp(item.porcentaje2027, item.desemp2027), // % Avance 2027 con barra
                            generateProgressCellDesemp(item.porcentajecuatrenio, item.desempcuatrenio),      // % Cuatrenio con barra
                            estado,           // Estado con la clase adecuada
                            accion,           // Botón de acción
                        ]);
                    });

                    table.draw();
                }
            });
        });*/

        // Mostrar indicadores en rezagos, ejecutado 100%, sin programar y por dependencia
        function actualizarTablaRezago() {
            const baseRutaRezago = "{{ route('rezago_ind_dep', ['id' => '__ID__']) }}";
            const baseRutaVer = "{{ route('ver_ind1', ['id' => '__ID__']) }}";
            var rez = document.getElementById('rezago').value;
            var id_dep = document.getElementById('id_d').value;
            var id = rez + "-" + id_dep;
            var urlRez = baseRutaRezago.replace('__ID__', id);
            $.ajax({
                url: urlRez,
                type: 'get',
                success: function(data) {
                    let tabla = $('#avances').DataTable();
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

        // Escuchadores de cambio para ambos selects
        $('#rezago').on('change', actualizarTablaRezago);
        $('#id_d').on('change', actualizarTablaRezago);
    </script>    
@endsection