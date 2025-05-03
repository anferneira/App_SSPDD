@extends('Layouts.plantilla')

@section('titulo', 'Proyectos - Municipios')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Proyectos - Municipios
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarpromunmodal" title="nuevo proyecto - municipio">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importarpromunmodal" title="cargar proyectos - municipios">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Proyectos - Municipios</li>
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
                    <table class="display" id="promuns" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">No</th>
                                <th class="text-center" width="80%">Proyecto</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center" hidden>proyecto</th>
                                <th class="text-center" width="40%">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($promuns as $pm)
                                <tr class="text-center" id="promun-row-{{ $pm->id }}">
                                    <td class="text-center">
                                        {{ $i++ }}
                                    </td>
                                    <td class="text-start">
                                        {{ $pm->proyecto_pm }}
                                    </td>
                                    <td class="text-center">
                                        @if ($pm->estado_pm == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $pm->estado_pm }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $pm->estado_pm }}
                                            </b>
                                        @endif
                                    </td>
                                    <td class="text-start" hidden>
                                        {{ $pm->proyecto_convergencia->codigo_pc }}
                                    </td>
                                    @php
                                        if ($pm->estado_pm == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $pm->id }}" data-toggle="modal" data-target="#verpromunmodal" title="ver proyecto - municipio">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $pm->id }}" data-toggle="modal" data-target="#editarpromunmodal" title="modificar proyecto - municipio">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $pm->id }}" title="desactivar proyecto - municipio">
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

    <div class="modal fade" id="agregarpromunmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar Nuevo Proyecto al Municipio</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardarpromun') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="id_li">Línea de Inversión</label>
                            <select name="id_li" id="id_li" class="form-control" style="width: 100%">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($lineas as $l)
                                    <option value="{{ $l->id }}">{{ $l->proyecto_li }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_pc">Proyecto PIRES / PILES / PICES</label>
                            <select name="id_pc" id="id_pc" class="form-control" style="width: 100%">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($proyecto_convergencias as $pc)
                                    <option value="{{ $pc->id }}">{{ $pc->codigo_pc.' - '.$pc->proyecto_pc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_m">Municipio</label>
                            <select name="id_m" id="id_m" class="form-control" style="width: 100%">
                                <option value="0" disabled selected>Seleccionar</option>
                                @foreach ($municipios as $m)
                                    <option value="{{ $m->id }}">{{ $m->nombre_m }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="nombre">Nombre del Proyecto <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                placeholder="Ingrese el nombre del proyecto" required>
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

    <div class="modal fade" id="verpromunmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos del Proyecto en el Municipio</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Linea de Inversión: </strong><span id="verlininv"></span></p>
                    <p><strong>Proyecto PIRES / PILES / PICES: </strong><span id="verproppp"></span></p>
                    <p><strong>Municipio: </strong><span id="vermun"></span></p>
                    <p><strong>Nombre del Proyecto: </strong><span id="vernom"></span></p>
                    <p><strong>Estado: </strong><span id="verestado"></span></p>
                    <p><strong>Registro: </strong><span id="vercreado"></span></p>
                    <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarpromunmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos del Proyecto en el Municipio</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizarpromun') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group m-2">
                            <label for="id_li">Línea de Inversión</label>
                            <select name="id_li" id="id_li_editar" class="form-control" style="width: 100%">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($lineas as $l)
                                    <option value="{{ $l->id }}">{{ $l->proyecto_li }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_pc">Proyecto PIRES / PILES / PICES</label>
                            <select name="id_pc" id="id_pc_editar" class="form-control" style="width: 100%">
                                <option value="0" disabled selected>Seleccionar</option>
                                @foreach ($proyecto_convergencias as $pc)
                                    <option value="{{ $pc->id }}">{{ $pc->codigo_pc.' - '.$pc->proyecto_pc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_m">Municipio</label>
                            <select name="id_m" id="id_m_editar" class="form-control" style="width: 100%">
                                <option value="0" disabled selected>Seleccionar</option>
                                @foreach ($municipios as $m)
                                    <option value="{{ $m->id }}">{{ $m->nombre_m }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="nombre">Nombre del Proyecto <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" id="nombre_editar" class="form-control"
                                placeholder="Ingrese el nombre del proyecto" required>
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

    <div class="modal fade" id="importarpromunmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Proyectos - Municipios (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvpromuns') }}" method="POST" enctype="multipart/form-data">
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
        $(document).ready(function() {
            // Inicializar DataTable
            $('#promuns').DataTable({
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
        $(document).on('click', '.ver', function() {
            var ProMunId = $(this).data('id');
            var url = "{{ route('verpromun', ['id' => ':id']) }}";
            url = url.replace(':id', ProMunId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#verlininv').text(data.linea_inversion.proyecto_li); 
                    $('#verproppp').text(data.proyecto_convergencia.codigo_pc + ' - ' + data.proyecto_convergencia.proyecto_pc);
                    $('#vermun').text(data.municipio.nombre_m);
                    $('#vernom').text(data.proyecto_pm); 
                    $('#verestado').text(data.estado_pm).removeClass().addClass('badge').addClass(data.estado_pm === 'Activo' ? 'bg-success' : 'bg-danger');
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
                    $('#verpromunmodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var ProMunId = $(this).data('id');
            var url = "{{ route('editarpromun', ['id' => ':id']) }}";
            url = url.replace(':id', ProMunId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#id_li_editar').val(data.id_li);
                    $('#id_pc_editar').val(data.id_pc);
                    $('#id_m_editar').val(data.id_m);
                    $('#nombre_editar').val(data.proyecto_pm);
                    $('#estado').val(data.estado_pm);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
        $(document).on('click', '.eliminar', function() {
            var ProMunId = $(this).data('id');
            var url = "{{ route('eliminarpromun', ['id' => ':id']) }}";
            url = url.replace(':id', ProMunId);
            Swal.fire({
                title: "Esta seguro de desactivar la Estrategia en la Dependencia?",
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
                                    text: "El Proyecto en el Municipio ha sido desactivado.",
                                    icon: "success"
                                });
                                $('#promun-row-' + ProMunId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#promun-row-' + ProMunId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#promuns').DataTable().row('#promun-row-' + ProMunId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "El Proyecto en el Municipio no ha sido desactivado.",
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