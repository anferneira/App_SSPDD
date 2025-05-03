@extends('Layouts.plantilla')

@section('titulo', 'Metas Ods')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>Metas de Objetivos de Desarrollo Sostenible
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarmetaodsmodal" title="nueva meta ods">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importarmetasodsmodal" title="cargar metas ods">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Metas Ods</li>
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
                    <table class="display" id="metasods" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">No</th>
                                <th class="text-center" width="50%">Nombre</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($metasods as $ods)
                                <tr class="text-center" id="mods-row-{{ $ods->id }}">
                                    <td class="text-center">
                                        {{ $i++ }}
                                    </td>
                                    <td class="text-start" width="65%">
                                        {{ $ods->nombre_mo }}
                                    </td>
                                    <td class="text-center">
                                        @if ($ods->estado_mo == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $ods->estado_mo }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $ods->estado_mo }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($ods->estado_mo == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $ods->id }}" data-toggle="modal" data-target="#vermetaodsmodal" title="ver meta ods">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $ods->id }}" data-toggle="modal" data-target="#editarmetaodsmodal" title="modificar meta ods">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $ods->id }}" title="desactivar meta ods">
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

    <div class="modal fade" id="agregarmetaodsmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nueva Meta Ods</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardarmetaods') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="codigo">Código <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" id="codigo" class="form-control"
                                placeholder="Ingrese el Código de la meta ods" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="name">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                placeholder="Ingrese el nombre de la meta ods" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="ods">Ods</label>
                            <select name="id_ods" id="id_ods" class="form-control" style="width: 100%">
                                <option value="" disabled>Seleccionar</option>
                                @foreach ($odss as $ods)
                                    <option value="{{ $ods->id }}">{{ $ods->codigo_ods.'. '.$ods->nombre_ods }}</option>
                                @endforeach
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

    <div class="modal fade" id="vermetaodsmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos de la Meta Ods</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Código: </strong><span id="vercodigo"></span></p>
                    <p><strong>Nombre: </strong><span id="vernombre"></span></p>
                    <p><strong>Ods: </strong><span id="verods"></span></p>
                    <p><strong>Estado: </strong><span id="verestado"></span></p>
                    <p><strong>Registro: </strong><span id="vercreado"></span></p>
                    <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarmetaodsmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos de la Meta Ods</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizarmetaods') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group m-2">
                            <label for="codigo">Código <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" id="codigo_editar" class="form-control"
                                placeholder="Ingrese el Código de la meta ods" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="name">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" id="nombre_editar" class="form-control"
                                placeholder="Ingrese el nombre de la meta ods" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="id_ods">Ods</label>
                            <select name="id_ods" id="id_ods_editar" class="form-control" style="width: 100%">
                                <option value="" disabled>Seleccionar</option>
                                @foreach ($odss as $ods)
                                    <option value="{{ $ods->id }}">{{ $ods->codigo_ods.'. '.$ods->nombre_ods }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group m-2">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado_editar" class="form-control" style="width: 100%">
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

    <div class="modal fade" id="importarmetasodsmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Metas Ods (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvmetasodss') }}" method="POST" enctype="multipart/form-data">
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
            $('#metasods').DataTable({
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
            var MetaOdsId = $(this).data('id');
            var url = "{{ route('vermetaods', ['id' => ':id']) }}";
            url = url.replace(':id', MetaOdsId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#vercodigo').text(data.codigo_mo); 
                    $('#vernombre').text(data.nombre_mo);
                    $('#verods').text(data.ods.nombre_ods);
                    $('#verestado').text(data.estado_mo).removeClass().addClass('badge').addClass(data.estado_mo === 'Activo' ? 'bg-success' : 'bg-danger');
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
                    $('#vermetaodsmodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var MetaOdsId = $(this).data('id');
            var url = "{{ route('editarmetaods', ['id' => ':id']) }}";
            url = url.replace(':id', MetaOdsId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#codigo_editar').val(data.codigo_mo);
                    $('#nombre_editar').val(data.nombre_mo);
                    $('#id_ods_editar').val(data.id_ods).trigger('change');
                    $('#estado_editar').val(data.estado_mo);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
        $(document).on('click', '.eliminar', function() {
            var MetaOdsId = $(this).data('id');
            var url = "{{ route('eliminarmetaods', ['id' => ':id']) }}";
            url = url.replace(':id', MetaOdsId);
            Swal.fire({
                title: "Esta seguro de desactivar la meta Ods?",
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
                                    text: "La meta Ods ha sido desactivada.",
                                    icon: "success"
                                });
                                $('#mods-row-' + MetaOdsId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#mods-row-' + MetaOdsId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#metasodss').DataTable().row('#mods-row-' + MetaOdsId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "La meta Ods no ha sido desactivada.",
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