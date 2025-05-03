@extends('Layouts.plantilla')

@section('titulo', 'Sectoriales')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sectoriales
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarsectorialmodal" title="nueva sectorial">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importarsectorialmodal" title="cargar sectoriales">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Sectoriales</li>
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
                    <table class="display" id="sectoriales" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">Código</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($sectoriales as $sec)
                                <tr class="text-center" id="sec-row-{{ $sec->id }}">
                                    <td class="text-center">
                                        {{ $sec->codigo_s }}
                                    </td>
                                    <td class="text-start">
                                        {{ $sec->nombre_s }}
                                    </td>
                                    <td class="text-center">
                                        @if ($sec->estado_s == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $sec->estado_s }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $sec->estado_s }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($sec->estado_s == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $sec->id }}" data-toggle="modal" data-target="#versectorialmodal" title="ver sectorial">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $sec->id }}" data-toggle="modal" data-target="#editarsectorialmodal" title="modificar sectorial">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $sec->id }}" title="desactivar sectorial">
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

    <div class="modal fade" id="agregarsectorialmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nueva Sectorial</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardarsector') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="codigo">Código <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" id="codigo" class="form-control"
                                placeholder="Ingrese el código de la sectorial" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="name">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                placeholder="Ingrese el nombre de la sectorial" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="id_d">Dependencia</label>
                            <select name="id_d" id="id_d" class="form-control" style="width: 100%">
                                <option value="" disabled>Seleccionar</option>
                                @foreach ($dependencias as $d)
                                    <option value="{{ $d->id }}">{{ $d->nombre_d }}</option>
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

    <div class="modal fade" id="versectorialmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos de la Sectorial</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Código: </strong><span id="vercodigo"></span></p>
                    <p><strong>Nombre: </strong><span id="vernombre"></span></p>
                    <p><strong>Dependencia: </strong><span id="verdependencia"></span></p>
                    <p><strong>Estado: </strong><span id="verestado" class="badge bg-danger"></span></p>
                    <p><strong>Registro: </strong><span id="vercreado"></span></p>
                    <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarsectorialmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos de la Sectorial</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizarsector') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group m-2">
                            <label for="name">Código <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" id="codigo_editar" class="form-control"
                                placeholder="Ingrese el código de la sectorial" required>
                        </div>
                        
                        <div class="form-group m-2">
                            <label for="name">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" id="nombre_editar" class="form-control"
                                placeholder="Ingrese el nombre de la sectorial" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="id_d">Dependencia</label>
                            <select name="id_d" id="id_d_editar" class="form-control" style="width: 100%">
                                <option value="" disabled>Seleccionar</option>
                                @foreach ($dependencias as $d)
                                    <option value="{{ $d->id }}">{{ $d->nombre_d }}</option>
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

    <div class="modal fade" id="importarsectorialmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Sectoriales (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvsectores') }}" method="POST" enctype="multipart/form-data">
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
            $('#sectoriales').DataTable({
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
            var SectorialId = $(this).data('id');
            var url = "{{ route('versector', ['id' => ':id']) }}";
            url = url.replace(':id', SectorialId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#vercodigo').text(data.codigo_s);
                    $('#vernombre').text(data.nombre_s);
                    $('#verdependencia').text(data.sectordependencia.nombre_d);
                    $('#verestado').text(data.estado_s).removeClass().addClass('badge').addClass(data.estado_s === 'Activo' ? 'bg-success' : 'bg-danger');
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
                    $('#versectorialmodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var SectorialId = $(this).data('id');
            var url = "{{ route('editarsector', ['id' => ':id']) }}";
            url = url.replace(':id', SectorialId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data, depen) {
                    $('#id').val(data.id);
                    $('#codigo_editar').val(data.codigo_s);
                    $('#nombre_editar').val(data.nombre_s);
                    $('#id_d_editar').val(data.id_d).trigger('change');
                    $('#estado').val(data.estado_s).trigger('change');
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
        $(document).on('click', '.eliminar', function() {
            var SectorialId = $(this).data('id');
            var url = "{{ route('eliminarsector', ['id' => ':id']) }}";
            url = url.replace(':id', SectorialId);
            Swal.fire({
                title: "Esta seguro de desactivar la Sectorial?",
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
                                    text: "La sectorial ha sido desactivada.",
                                    icon: "success"
                                });
                                $('#sec-row-' + SectorialId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#sec-row-' + SectorialId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#sectoriales').DataTable().row('#sec-row-' + SectorialId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "La Sectorial no ha sido desactivada.",
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