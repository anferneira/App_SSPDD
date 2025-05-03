@extends('Layouts.plantilla')

@section('titulo', 'Dependencias - Dimensiones')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dependencias - Dimensiones
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregardepdimmodal" title="nueva dependencia - dimensiones">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importardepdimmodal" title="cargar dependencias dimensiones">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Dependencias - Dimensiones</li>
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
                    <table class="display" id="depdims" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">No</th>
                                <th class="text-center" width="30%">Dependencia</th>
                                <th class="text-center" width="30%">Dimensión</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($depdims as $dd)
                                <tr class="text-center" id="depdim-row-{{ $dd->id }}">
                                    <td class="text-center">
                                        {{ $i++ }}
                                    </td>
                                    <td class="text-start" width="30%">
                                        {{ $dd->dependenciass->nombre_d }}
                                    </td>
                                    <td class="text-start" width="30%">
                                        {{ $dd->dimensiones->codigo_d.'. '.$dd->dimensiones->nombre_d }}
                                    </td>
                                    <td class="text-center">
                                        @if ($dd->estado_dd == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $dd->estado_dd }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $dd->estado_dd }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($dd->estado_dd == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $dd->id }}" data-toggle="modal" data-target="#verdepdimmodal" title="ver dependencia dimensiones">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $dd->id }}" data-toggle="modal" data-target="#editardepdimmodal" title="modificar dependencia dimensión">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $dd->id }}" title="desactivar dependencia dimensión">
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

    <div class="modal fade" id="agregardepdimmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar Nueva Dimensión a Dependencia</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardardepdim') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="id_d">Dependencia</label>
                            <select name="id_d" id="id_d" class="form-control" style="width: 100%">
                                <option value="-1" disabled select>Seleccionar</option>
                                @foreach ($dependencias as $d)
                                    <option value="{{ $d->id }}">{{ $d->nombre_d }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_dimension">Dimensión</label>
                            <select name="id_dimension" id="id_dimension" class="form-control" style="width: 100%">
                                <option value="0" disabled selected>Seleccionar</option>
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

    <div class="modal fade" id="verdepdimmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos del la Dependencia y Dimensión</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Dependencia: </strong><span id="verdependencia"></span></p>
                    <p><strong>Dimensión: </strong><span id="verdimension"></span></p>
                    <p><strong>Estado: </strong><span id="verestado"></span></p>
                    <p><strong>Registro: </strong><span id="vercreado"></span></p>
                    <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editardepdimmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Dimensión en Dependencia</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizardepdim') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
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

    <div class="modal fade" id="importardepdimmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Dimensiones - Dependencias (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvdepdims') }}" method="POST" enctype="multipart/form-data">
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
            $('#depdims').DataTable({
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
            var DepDimId = $(this).data('id');
            var url = "{{ route('verdepdim', ['id' => ':id']) }}";
            url = url.replace(':id', DepDimId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#verdependencia').text(data.dependenciass.nombre_d); 
                    $('#verdimension').text(data.dimensiones.codigo_d + '. ' + data.dimensiones.nombre_d);
                    $('#verestado').text(data.estado_dd).removeClass().addClass('badge').addClass(data.estado_dd === 'Activo' ? 'bg-success' : 'bg-danger');
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
                    $('#verdepdimmodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var DepDimId = $(this).data('id');
            var url = "{{ route('editardepdim', ['id' => ':id']) }}";
            url = url.replace(':id', DepDimId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#id_d_editar').val(data.id_dep);
                    $('#id_dimension_editar').val(data.id_dim);
                    $('#estado').val(data.estado_dd);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
        $(document).on('click', '.eliminar', function() {
            var DepDimId = $(this).data('id');
            var url = "{{ route('eliminardepdim', ['id' => ':id']) }}";
            url = url.replace(':id', DepDimId);
            Swal.fire({
                title: "Esta seguro de desactivar la Dimensión en la Dependencia?",
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
                                    text: "La Dimensión en la Dependencia ha sido desactivada.",
                                    icon: "success"
                                });
                                $('#depdim-row-' + DepDimId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#depdim-row-' + DepDimId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#depdims').DataTable().row('#depdim-row-' + DepDimId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "La Dimensión en la Dependencia no ha sido desactivada.",
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