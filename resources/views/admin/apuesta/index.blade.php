@extends('Layouts.plantilla')

@section('titulo', 'Apuestas')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Apuestas
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarapuestamodal" title="nueva apuesta">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importarapuestamodal" title="cargar apuestas">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Apuestas</li>
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
                    <table class="display" id="apuestas" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">Código</th>
                                <th class="text-center" width="60%">Nombre</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($apuestas as $apuesta)
                                <tr class="text-center" id="apu-row-{{ $apuesta->id }}">
                                    <td class="text-center">
                                        {{ $apuesta->codigo_a }}
                                    </td>
                                    <td class="text-start" with="60%">
                                        {{ $apuesta->nombre_a }}
                                    </td>
                                    <td class="text-center">
                                        @if ($apuesta->estado_a == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $apuesta->estado_a }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $apuesta->estado_a }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($apuesta->estado_a == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $apuesta->id }}" data-toggle="modal" data-target="#verapuestamodal" title="ver dimension">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $apuesta->id }}" data-toggle="modal" data-target="#editarapuestamodal" title="modificar dimension">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $apuesta->id }}" title="desactivar apuesta">
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

    <div class="modal fade" id="agregarapuestamodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nueva Apuesta</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardarapuesta') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="codigo">Código <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" class="form-control"
                                placeholder="Ingrese el código de la dimensión" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="nombre">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" class="form-control"
                                placeholder="Ingrese el nombre de la dimensión" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="objetivo">Objetivo</label>
                            <input type="text" name="objetivo" id="objetivo" class="form-control"
                                placeholder="Ingrese el objetivo de la apuesta" required>
                        </div>
                        
                        <div class="form-group m-2">
                            <label for="id_dimension">Dimensión <b class="text-danger"> * </b></label>
                            <select name="id_dimension" id="id_dimension" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($dimensiones as $d)
                                    <option value="{{ $d->id }}">{{ $d->codigo_d.'. '.$d->nombre_d }}</option>
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

    <div class="modal fade" id="verapuestamodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos de la Apuesta</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Código: </strong><span id="vercodigo"></span></p>
                    <p><strong>Nombre: </strong><span id="vernombre"></span></p>
                    <p><strong>Objetivo: </strong><span id="verobjetivo"></span></p>
                    <p><strong>Estrategia: </strong><span id="verestrategia"></span></p>
                    <p><strong>Dimensión: </strong><span id="verdimension"></span></p>
                    <p><strong>Estado: </strong><span id="verestado" class="badge bg-danger"></span></p>
                    <p><strong>Registro: </strong><span id="vercreado"></span></p>
                    <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarapuestamodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos de la Apuesta</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizarapuesta') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group m-2">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control"
                                placeholder="Ingrese el código de la apuesta" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                placeholder="Ingrese el nombre de la apuesta" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="objetivo">Objetivo</label>
                            <input type="text" name="objetivo" id="objetivo_editar" class="form-control"
                                placeholder="Ingrese el objetivo de la apuesta" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="id_dimension">Dimensión</label>
                            <select name="id_dimension" id="id_dimension_editar" class="form-control" style="width: 100%">
                                <option value="" disabled>Seleccionar</option>
                                @foreach ($dimensiones as $d)
                                    <option value="{{ $d->id }}">{{ $d->codigo_d.'. '.$d->nombre_d }}</option>
                                @endforeach
                            </select>
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

    <div class="modal fade" id="importarapuestamodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Apuestas (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvapuestas') }}" method="POST" enctype="multipart/form-data">
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
            $('#apuestas').DataTable({
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
            var ApuestaId = $(this).data('id');
            var url = "{{ route('verapuesta', ['id' => ':id']) }}";
            url = url.replace(':id', ApuestaId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#vercodigo').text(data.codigo_a);
                    $('#vernombre').text(data.nombre_a);
                    $('#verobjetivo').text(data.objetivo_a);
                    $('#verestrategia').text(data.dimension.estrategia_dimension.codigo_e + '. ' + data.dimension.estrategia_dimension.nombre_e);
                    $('#verdimension').text(data.dimension.codigo_d + '. ' + data.dimension.nombre_d);
                    $('#verestado').text(data.estado_a).removeClass().addClass('badge').addClass(data.estado_a === 'Activo' ? 'bg-success' : 'bg-danger');;
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
                    $('#verapuestamodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var ApuestaId = $(this).data('id');
            var url = "{{ route('editarapuesta', ['id' => ':id']) }}";
            url = url.replace(':id', ApuestaId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#codigo').val(data.codigo_a);
                    $('#nombre').val(data.nombre_a);
                    $('#objetivo_editar').val(data.objetivo_a);
                    $('#id_a_editar').val(data.id_d).trigger('change');
                    $('#estado').val(data.estado_a);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
        $(document).on('click', '.eliminar', function() {
            var ApuestaId = $(this).data('id');
            var url = "{{ route('eliminarapuesta', ['id' => ':id']) }}";
            url = url.replace(':id', ApuestaId);
            Swal.fire({
                title: "Esta seguro de desactivar la Apuesta?",
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
                                    text: "La apuesta ha sido desactivada.",
                                    icon: "success"
                                });
                                $('#apu-row-' + ApuestaId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#apu-row-' + ApuestaId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#apuestas').DataTable().row('#apu-row-' + ApuestaId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "La apuesta no ha sido desactivada.",
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