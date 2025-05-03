@extends('Layouts.plantilla')

@section('titulo', 'Avances Estratégicos')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Avances Estratégicos
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregaravancemodal" title="nuevo avance">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importaravancemodal" title="cargar avances">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Avances Estratégicos</li>
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
                    <table class="display" id="avances" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">No</th>
                                <th class="text-center" width="60%">Nombre</th>
                                <th class="text-center">Periodo</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($avances as $avance)
                                <tr class="text-center" id="ava-row-{{ $avance->id }}">
                                    <td class="text-center">
                                        {{ $i++ }}
                                    </td>
                                    <td class="text-start" with="60%">
                                        {{ $avance->indproducto->codigo_ip.'. '.$avance->indproducto->nombre_ip }}
                                    </td>
                                    <td class="text-start" with="60%">
                                        {{ $avance->anio_ae.'_'.$avance->trimestre_ae }}
                                    </td>
                                    <td class="text-center">
                                        @if ($avance->estado_ae == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $avance->estado_ae }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $avance->estado_ae }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($avance->estado_ae == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $avance->id }}" data-toggle="modal" data-target="#veravancemodal" title="ver avance">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $avance->id }}" data-toggle="modal" data-target="#editaravancemodal" title="modificar avance">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $avance->id }}" title="desactivar avance">
                                            <i class="fas fa-user-minus"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="agregaravancemodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Avance Estratégico</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardaravaest') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="id_dep">Dependencia Responsable <b class="text-danger"> * </b></label>
                            <select name="id_dep" id="id_dep" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($dependencias as $d)
                                    <option value="{{ $d->id }}">{{ $d->nombre_d }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_ip">Indicador <b class="text-danger"> * </b></label>
                            <select name="id_ip" id="id_ip" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="anio">Año <b class="text-danger"> * </b></label>
                            <select name="anio" id="anio" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                            </select>
                        </div>

                        <div class="form-group m-2">
                            <label for="trimestre">Trimestre <b class="text-danger"> * </b></label>
                            <select name="trimestre" id="trimestre" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="avance">Avance del Periodo <b class="text-danger"> * </b></label>
                                    <input type="text" name="avance" id="avance" class="form-control"
                                        placeholder="Ingrese el avance del periodo" required value="0">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="programado">Programado del Periodo <b class="text-danger"> * </b></label>
                                    <input type="text" name="programado" id="programado" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-2">
                            <span id="ver_rezago">
                                <b class="badge"></b>
                            </span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="veravancemodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos del Avance Estratégico</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Indicador: </strong><span id="verindicador"></span></p>
                    <p><strong>Dependencia: </strong><span id="verdependencia"></span></p>
                    <p><strong>Periodo: </strong><span id="verperiodo"></span></p>
                    <p><strong>Programado: </strong><span id="verprog"></span></p>
                    <p><strong>Avance: </strong><span id="veravance"></span></p>
                    <p><strong>Rezago: </strong><span id="verrezago" class="badge"></span></p>
                    <p><strong>% Año: </strong><span id="verporcanio"></span></p>
                    <p><strong>% Cuatrenio: </strong><span id="verporccuat"></span></p>
                    <p><strong>Estado: </strong><span id="verestado" class="badge bg-danger"></span></p>
                    <p><strong>Registro: </strong><span id="vercreado"></span></p>
                    <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editaravancemodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos del Avance Estratégico</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizaravaest') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group m-2">
                            <label for="id_dep">Dependencia Responsable <b class="text-danger"> * </b></label>
                            <select name="id_dep" id="id_dep_editar" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($dependencias as $d)
                                    <option value="{{ $d->id }}">{{ $d->nombre_d }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_ip">Indicador <b class="text-danger"> * </b></label>
                            <select name="id_ip" id="id_ip_editar" class="form-control">
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="anio">Año <b class="text-danger"> * </b></label>
                            <select name="anio" id="anio_editar" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                            </select>
                        </div>

                        <div class="form-group m-2">
                            <label for="trimestre">Trimestre <b class="text-danger"> * </b></label>
                            <select name="trimestre" id="trimestre_editar" class="form-control">
                                <option value="" disabled>Seleccionar</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="avance">Avance del Periodo <b class="text-danger"> * </b></label>
                                    <input type="text" name="avance" id="avance_editar" class="form-control"
                                        placeholder="Ingrese el avance del periodo" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="programado">Programado del Periodo <b class="text-danger"> * </b></label>
                                    <input type="text" name="programado" id="programado_editar" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-2">
                            <span id="ver_rezago_editar">
                                <b class="badge"></b>
                            </span>
                        </div>
                        <div class="form-group m-2">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="form-control" style="width: 100%">
                                <option value="" disabled>Seleccionar</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importaravancemodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Avances Estratégicos (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvavaests') }}" method="POST" enctype="multipart/form-data">
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
        document.getElementById('avance').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('avance_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
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
                    { orderable: false, targets: 3 } // Desactivar ordenación en la columna de acciones
                ]
            });
        });
        $('#id_dep').on('change', function () {
            var id_dep = $(this).val();
            var url = "{{ route('ind_dep', ['id' => ':id']) }}".replace(':id', id_dep);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var $indSelect = $('#id_ip');
                    $indSelect.empty();
                    $indSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Indicador) {
                        $indSelect.append('<option value="' + Indicador.id + '">' + Indicador.codigo_ip + '</option>');
                    });
                }
            });
        });
        $('#id_dep_editar').on('load', function () {
            var id_dep = $(this).val();
            var url = "{{ route('ind_dep', ['id' => ':id']) }}".replace(':id', id_dep);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var $indSelect = $('#id_ip_editar');
                    $indSelect.empty();
                    $indSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Indicador) {
                        $indSelect.append('<option value="' + Indicador.id + '">' + Indicador.codigo_ip + '</option>');
                    });
                }
            });
        });
        $('#trimestre').on('input', function () {
            const id_ip = document.getElementById('id_ip').value;
            const avance = document.getElementById('avance').value;
            const anio = document.getElementById('anio').value;
            const trimestre = document.getElementById('trimestre').value;
            const badge = $('#ver_rezago .badge');
            var datos = id_ip + "_" + avance + "_" + anio + "_" + trimestre + "_" + 0;
            var url = "{{ route('rezago', ['id' => ':id']) }}".replace(':id', datos);
            if (avance === '' || avance === 0) {
                badge.text('').removeClass().addClass('badge');
            }
            else {
                $.ajax({
                    url: url,
                    type: 'get',
                    success: function(data) {
                        badge.text('').removeClass().addClass('badge');
                        // Verifica si el periodo ya fue programado
                        if (typeof data === 'string') {
                            // El mensaje del servidor indica que el periodo ya fue programado
                            badge.text(data).removeClass().addClass('badge badge-info');
                            const prog = $('#programado');
                            prog.val('');
                        }
                        else if (Array.isArray(data)) {
                            // Procesar datos del periodo
                            data.forEach(function(datos) {
                                const prog = $('#programado');
                                var programado = datos.valor_programado.replace(',', '.');
                                prog.val(programado);
                                if (datos.valor_programado == 0)
                                    badge.text('No programado').removeClass().addClass('badge badge-danger');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            }
        });
        $('#trimestre_editar').on('input', function () {
            const id_ip = document.getElementById('id_ip').value;
            const avance = document.getElementById('avance').value;
            const anio = document.getElementById('anio').value;
            const trimestre = document.getElementById('trimestre').value;
            const badge = $('#ver_rezago_editar .badge');
            var datos = id_ip + "_" + avance + "_" + anio + "_" + trimestre + "_" + 1;
            var url = "{{ route('rezago', ['id' => ':id']) }}".replace(':id', datos);
            if (avance === '' || avance === 0) {
                badge.text('').removeClass().addClass('badge');
            }
            else {
                $.ajax({
                    url: url,
                    type: 'get',
                    success: function(data) {
                        badge.text('').removeClass().addClass('badge');
                        // Verifica si el periodo ya fue programado
                        if (typeof data === 'string') {
                            // El mensaje del servidor indica que el periodo ya fue programado
                            badge.text(data).removeClass().addClass('badge badge-info');
                            const prog = $('#programado_editar');
                            prog.val('');
                        }
                        else if (Array.isArray(data)) {
                            // Procesar datos del periodo
                            data.forEach(function(datos) {
                                const prog = $('#programado_editar');
                                var programado = datos.valor_programado.replace(',', '.');
                                prog.val(programado);
                                if (datos.valor_programado == 0)
                                    badge.text('No programado').removeClass().addClass('badge badge-danger');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            }
        });
        $('#avance').on('input', function () {
            const id_ip = document.getElementById('id_ip').value;
            const avance = document.getElementById('avance').value;
            const anio = document.getElementById('anio').value;
            const trimestre = document.getElementById('trimestre').value;
            var datos = id_ip + "_" + avance + "_" + anio + "_" + trimestre + "_" + 0;
            var rezago = 0;
            var mensaje = 0;
            const badge = $('#ver_rezago .badge');
            var url = "{{ route('rezago', ['id' => ':id']) }}".replace(':id', datos);
            if (avance === '' || avance === 0) {
                badge.text('').removeClass().addClass('badge');
            }
            else {
                $.ajax({
                    url: url,
                    type: 'get',
                    success: function(data) {
                        // Verifica si el periodo ya fue programado
                        if (typeof data === 'string') {
                            // El mensaje del servidor indica que el periodo ya fue programado
                            badge.text(data).removeClass().addClass('badge badge-info');
                        }
                        else if (Array.isArray(data)) {
                            // Procesar datos del periodo
                            data.forEach(function(datos) {
                                var programado = parseFloat(datos.valor_programado.replace(',', '.'));
                                if (programado > 0) {
                                    rezago = parseFloat(avance) / programado;
                                    if (rezago === 1) {
                                        badge.text('Ha cumplido').removeClass().addClass('badge badge-success');
                                    }
                                    else {
                                        if (rezago > 1) {
                                            badge.text('Rezago Superior del ' + (rezago * 100 - 100).toFixed(2) + '%').removeClass().addClass('badge badge-warning');
                                        }
                                        else {
                                            badge.text('Rezago Inferior del ' + (100 - (rezago * 100)).toFixed(2) + '%').removeClass().addClass('badge badge-danger');
                                        }
                                    }
                                }
                                else {
                                    badge.text('No programado').removeClass().addClass('badge badge-danger');;
                                }
                                
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        
                    }
                });
            }
        });
        $('#avance_editar').on('input', function () {
            const id_ip = document.getElementById('id_ip_editar').value;
            const avance = document.getElementById('avance_editar').value;
            const anio = document.getElementById('anio_editar').value;
            const trimestre = document.getElementById('trimestre_editar').value;
            var datos = id_ip + "_" + avance + "_" + anio + "_" + trimestre + "_" + 1;
            var rezago = 0;
            var mensaje = 0;
            const badge = $('#ver_rezago_editar .badge');
            var url = "{{ route('rezago', ['id' => ':id']) }}".replace(':id', datos);
            if (avance === '' || avance === 0) {
                badge.text('').removeClass().addClass('badge');
            }
            else {
                $.ajax({
                    url: url,
                    type: 'get',
                    success: function(data) {
                        // Verifica si el periodo ya fue programado
                        if (Array.isArray(data)) {
                            // Procesar datos del periodo
                            data.forEach(function(datos) {
                                var programado = parseFloat(datos.valor_programado.replace(',', '.'));
                                if (programado > 0) {
                                    rezago = parseFloat(avance) / programado;
                                    if (rezago === 1) {
                                        badge.text('Ha cumplido').removeClass().addClass('badge badge-success');
                                    }
                                    else {
                                        if (rezago > 1) {
                                            badge.text('Rezago Superior del ' + (rezago * 100 - 100).toFixed(2) + '%').removeClass().addClass('badge badge-warning');
                                        }
                                        else {
                                            badge.text('Rezago Inferior del ' + (100 - (rezago * 100)).toFixed(2) + '%').removeClass().addClass('badge badge-danger');
                                        }
                                    }
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        
                    }
                });
            }
        });
        $(document).on('click', '.ver', function() {
            var AvanceId = $(this).data('id');
            var url = "{{ route('veravaest', ['id' => ':id']) }}";
            url = url.replace(':id', AvanceId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    $('#verindicador').text(data.indproducto.codigo_ip + '. ' + data.indproducto.nombre_ip);
                    $('#verdependencia').text(data.indproducto.dependencia.nombre_d);
                    $('#verperiodo').text(data.anio_ae + '_' + data.trimestre_ae);
                    $('#verprog').text(data.programado);
                    $('#veravance').text(data.avance_ae);
                    rezago = parseFloat(data.avance_ae) / parseFloat(data.programado);
                    if (rezago === 1) {
                        $('#verrezago').text('Ha cumplido').removeClass().addClass('badge badge-success');
                    }
                    else {
                        if (rezago > 1) {
                            $('#verrezago').text('Rezago Superior del ' + (rezago * 100 - 100).toFixed(2) + '%').removeClass().addClass('badge badge-warning');
                        }
                        else {
                            if (rezago < 1) {
                                $('#verrezago').text('Rezago Inferior del ' + (100 - (rezago * 100)).toFixed(2) + '%').removeClass().addClass('badge badge-danger');
                            }
                            else {
                                $('#verrezago').text('No programado').removeClass().addClass('badge badge-danger');;
                            }
                        }
                    }
                    $('#verporcanio').text(((data.programado * 100) / data.programado_anio).toFixed(2) + '%' + ' (' + data.programado_anio + ')');
                    $('#verporccuat').text(((data.programado * 100) / data.programado_cuatrenio).toFixed(5) + '%' + ' (' + data.programado_cuatrenio + ')');
                    $('#verestado').text(data.estado_ae).removeClass().addClass('badge').addClass(data.estado_ae === 'Activo' ? 'bg-success' : 'bg-danger');
                    var fechacreado = new Date(data.created_at);
                    var opciones = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: 'numeric',
                        hour12: 'true',
                        minute: 'numeric',
                        second: 'numeric',
                    };
                    var fecharegistro = fechacreado.toLocaleDateString('es-Es', opciones);
                    $('#vercreado').text(fecharegistro);
                    var fechaactualizado = new Date(data.updated_at);
                    var opciones = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: 'numeric',
                        hour12: 'true',
                        minute: 'numeric',
                        second: 'numeric',
                    };
                    var fechaactualizado = fechaactualizado.toLocaleDateString('es-Es', opciones);
                    $('#veractualizado').text(fechaactualizado);
                    $('#veravancemodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var AvanceId = $(this).data('id');
            var url = "{{ route('editaravaest', ['id' => ':id']) }}";
            url = url.replace(':id', AvanceId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    var $indSelect = $('#id_ip_editar');
                    $indSelect.empty();
                    $indSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.ips.forEach(function(Indicador) {
                        $indSelect.append('<option value="' + Indicador.id + '">' + Indicador.codigo_ip + '</option>');
                    });
                    $('#id').val(data.id);
                    $('#avance_editar').val(data.avance_ae);
                    $('#programado_editar').val(data.programado);
                    $('#id_dep_editar').val(data.indproducto.dependencia.id).trigger('change');
                    $('#id_ip_editar').val(data.id_ip).trigger('change');
                    $('#anio_editar').val(data.anio_ae).trigger('change');
                    $('#trimestre_editar').val(data.trimestre_ae).trigger('change');
                    $('#estado').val(data.estado_ae);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
        $(document).on('click', '.eliminar', function() {
            var AvanceId = $(this).data('id');
            var url = "{{ route('eliminaravaest', ['id' => ':id']) }}";
            url = url.replace(':id', AvanceId);
            Swal.fire({
                title: "Esta seguro de desactivar el Avance Estratégico?",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText : "Cerrar",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Desactivar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax( {
                        url: url,
                        type: 'post',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire({
                                    title: "¡Registro Desactivado!",
                                    text: "El Avance Estratégico ha sido desactivado.",
                                    icon: "success"
                                });
                                $('#ava-row-' + AvanceId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#ava-row-' + AvanceId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#avances').DataTable().row('#ava-row-' + AvanceId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "El Avance Estratégico no ha sido desactivado.",
                                    icon: "error"
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>    
@endsection