@extends('Layouts.plantilla')

@section('titulo', 'Actividades')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Actividades
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregaractmodal" title="nueva actividad">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importaractmodal" title="cargar actividades">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Actividades</li>
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
                    <table class="display" id="acts" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">No</th>
                                <th class="text-center" width="60%">Nombre</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($acts as $act)
                                <tr class="text-center" id="ip-row-{{ $act->id }}">
                                    <td class="text-center">
                                        {{ $i++ }}
                                    </td>
                                    <td class="text-start" width="60%">
                                        {{ $act->codigo_a.'. '.$act->nombre_a }}
                                    </td>
                                    <td class="text-center">
                                        @if ($act->estado_a == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $act->estado_a }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $act->estado_a }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($act->estado_a == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $act->id }}" data-toggle="modal" data-target="#veractmodal" title="ver actividad">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $act->id }}" data-toggle="modal" data-target="#editaractmodal" title="modificar actividad">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $act->id }}" title="desactivar actividad">
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

    <div class="modal fade" id="agregaractmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nueva Actividad</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardaract') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="codigo">Código <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" class="form-control"
                                placeholder="Ingrese el código de la actividad" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="nombre">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" class="form-control"
                                placeholder="Ingrese el nombre de la actividad" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="id_ip">Indicador de Producto <b class="text-danger"> * </b></label>
                            <select name="id_ip" id="id_ip" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($ips as $ip)
                                    <option value="{{ $ip->id }}">{{ $ip->codigo_ip }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group m-2">
                            <label for="anio">Año <b class="text-danger"> * </b></label>
                            <select name="anio" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="2024" disabled>2024</option>
                                <option value="2025" disabled>2025</option>
                                <option value="2026" disabled>2026</option>
                                <option value="2027" disabled>2027</option>
                            </select>
                        </div>

                        <div class="form-group m-2">
                            <label for="trimestre">Trimestre <b class="text-danger"> * </b></label>
                            <select name="trimestre" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="1" disabled>1</option>
                                <option value="2" disabled>2</option>
                                <option value="3" disabled>3</option>
                                <option value="4" disabled>4</option>
                            </select>
                        </div>

                        <div class="form-group m-2">
                            <label for="meta">Meta 2027 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta" class="form-control"
                                placeholder="Ingrese la meta de la actividad" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="aporte">Aporte <b class="text-danger"> * </b></label>
                            <input type="text" name="aporte" class="form-control"
                                placeholder="Ingrese el aporte a la actividad" requiped>
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

    <div class="modal fade" id="veractmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos de la Actividad</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body" width="10px">
                    <p><strong>Código: </strong><span id="vercodigo"></span></p>
                    <p><strong>Actividad: </strong><span id="vernombre"></span></p>
                    <p><strong>Indicador de Producto: </strong><span id="verindip"></span></p>
                    <p><strong>Periodo: </strong><span id="verperiodo"></span></p>
                    <p><strong>Meta: </strong><span id="vermeta"></span></p>
                    <p><strong>Aporte: </strong><span id="veraporte"></span></p>
                    <p><strong>Estado: </strong><span id="verestado" class="badge bg-danger"></span></p>
                    <p><strong>Registro: </strong><span id="vercreado"></span></p>
                    <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editaractmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos de la Actividad</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizaract') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group m-2">
                            <label for="codigo">Código <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" id="codigo" class="form-control"
                                placeholder="Ingrese el código de la actividad" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="nombre">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                placeholder="Ingrese el nombre de la actividad" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="id_ip">Indicador de Producto <b class="text-danger"> * </b></label>
                            <select name="id_ip" id="id_ip_editar" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($ips as $ip)
                                    <option value="{{ $ip->id }}">{{ $ip->codigo_ip }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group m-2">
                            <label for="anio">Año <b class="text-danger"> * </b></label>
                            <select name="anio" id="anio_editar" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="2024" disabled>2024</option>
                                <option value="2025" disabled>2025</option>
                                <option value="2026" disabled>2026</option>
                                <option value="2027" disabled>2027</option>
                            </select>
                        </div>

                        <div class="form-group m-2">
                            <label for="trimestre">Año <b class="text-danger"> * </b></label>
                            <select name="trimestre" id="trimestre_editar" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="1" disabled>1</option>
                                <option value="2" disabled>2</option>
                                <option value="3" disabled>3</option>
                                <option value="4" disabled>4</option>
                            </select>
                        </div>

                        <div class="form-group m-2">
                            <label for="meta">Meta 2027 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta" id="meta" class="form-control"
                                placeholder="Ingrese la meta de la actividad" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="aporte">Aporte <b class="text-danger"> * </b></label>
                            <input type="text" name="aporte" id="aporte" class="form-control"
                                placeholder="Ingrese el aporte a la actividad" requiped>
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

    <div class="modal fade" id="importaractmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Actividades (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvacts') }}" method="POST" enctype="multipart/form-data">
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
                                requiped>
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
            $('#acts').DataTable({
                order: [],
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
            var ActId = $(this).data('id');
            var url = "{{ route('veract', ['id' => ':id']) }}";
            url = url.replace(':id', ActId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    $('#vercodigo').text(data.codigo_a);
                    $('#vernombre').text(data.nombre_a);
                    $('#verindip').text(data.producto.codigo_ip + '. ' + data.producto.nombre_ip);
                    $('#verperiodo').text(data.anio_a + '_' + data.trimestre_a);
                    $('#vermeta').text(data.meta_a);
                    $('#veraporte').text(data.aporte_a);
                    $('#verestado').text(data.estado_a).removeClass().addClass('badge').addClass(data.estado_a === 'Activo' ? 'bg-success' : 'bg-danger');
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
                    $('#veractmodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var ActId = $(this).data('id');
            var url = "{{ route('editaract', ['id' => ':id']) }}";
            url = url.replace(':id', ActId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#codigo').val(data.codigo_a);
                    $('#nombre').val(data.nombre_a);
                    $('#id_ip_editar').val(data.id_ip).trigger('change');
                    $('#aporte').val(data.aporte_a);
                    $('#meta').val(data.meta_a);
                    $('#anio_editar').val(data.anio_a).trigger('change');
                    $('#trimestre_editar').val(data.trimestre_a).trigger('change');
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
            var ActId = $(this).data('id');
            var url = "{{ route('eliminaract', ['id' => ':id']) }}";
            url = url.replace(':id', ActId);
            Swal.fire({
                title: "Esta seguro de desactivar la Actividad?",
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
                                    text: "La Actividad ha sido desactivada.",
                                    icon: "success"
                                });
                                $('#act-row-' + ActId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#act-row-' + ActId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#acts').DataTable().row('#act-row-' + ActId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "La Actividad no ha sido desactivada.",
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