@extends('Layouts.plantilla')

@section('titulo', 'Metas Ods - Indicadores de Producto')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>Metas Ods - Indicadores de Producto
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregaripmomodal" title="nueva indicador">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importaripmomodal" title="cargar indicadores">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Metas Ods - Indicadores de Producto</li>
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
                    <table class="display" id="ipmos" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">Código</th>
                                <th class="text-center" width="60%">Nombre</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($ipmos as $ipmo)
                                <tr class="text-center" id="ipmo-row-{{ $ipmo->id }}">
                                    <td class="text-center">
                                        {{ $ipmo->producto->codigo_ip }}
                                    </td>
                                    <td class="text-start" width="60%">
                                        {{ $ipmo->producto->nombre_ip }}
                                    </td>
                                    <td class="text-center">
                                        @if ($ipmo->estado_imo == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $ipmo->estado_imo }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $ipmo->estado_imo }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($ipmo->estado_imo == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $ipmo->id }}" data-toggle="modal" data-target="#veripmomodal" title="ver indicador">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $ipmo->id }}" data-toggle="modal" data-target="#editaripmomodal" title="modificar indicador">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $ipmo->id }}" title="desactivar indicador">
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

    <div class="modal fade" id="agregaripmomodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Asignar Nueva Meta ODS en Indicador de Producto</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardaripmo') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="id_ip">Indicador de Producto</label>
                            <select name="id_ip" id="id_ip" class="form-control" style="width: 100%">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($ips as $ip)
                                    <option value="{{ $ip->id }}">{{ $ip->codigo_ip.'. '.$ip->nombre_ip }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_ods">Ods</label>
                            <select name="id_ods" id="id_ods" class="form-control" style="width: 100%">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($odss as $ods)
                                    <option value="{{ $ods->id }}">{{ $ods->codigo_ods.'. '.$ods->nombre_ods }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_mo">Meta ODS</label>
                            <select name="id_mo" id="id_mo" class="form-control" style="width: 100%">
                                <option value="" disabled>Seleccionar</option>
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

    <div class="modal fade" id="veripmomodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos de la Meta ODS en el Indicador de Producto</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body" width="10px">
                    <p><strong>ODS: </strong><span id="verods"></span></p>
                    <p><strong>Meta ODS: </strong><span id="vermeto"></span></p>
                    <p><strong>Indicador de Producto: </strong><span id="verindip"></span></p>
                    <p><strong>Estado: </strong><span id="verestado" class="badge bg-danger"></span></p>
                    <p><strong>Registro: </strong><span id="vercreado"></span></p>
                    <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editaripmomodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos de la Meta ODS en el Indicador de Producto</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizaripmo') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group m-2">
                            <label for="id_ip">Indicador de Producto</label>
                            <select name="id_ip" id="id_ip_editar" class="form-control" style="width: 100%">
                                <option value="" disabled>Seleccionar</option>
                                @foreach ($ips as $ip)
                                    <option value="{{ $ip->id }}">{{ $ip->codigo_ip.'. '.$ip->nombre_ip }}</option>
                                @endforeach
                            </select>
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
                            <label for="id_mo">Meta ODS</label>
                            <select name="id_mo" id="id_mo_editar" class="form-control" style="width: 100%">
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

    <div class="modal fade" id="importaripmomodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Metas Ods - Indicadores de Productos (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvipmos') }}" method="POST" enctype="multipart/form-data">
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
            $('#ipmos').DataTable({
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
            var IPMOId = $(this).data('id');
            var url = "{{ route('veripmo', ['id' => ':id']) }}";
            url = url.replace(':id', IPMOId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    $('#verods').text(data.meta_ods.ods.codigo_ods + '. ' + data.meta_ods.ods.nombre_ods);
                    $('#vermeto').text(data.meta_ods.codigo_mo + '. ' + data.meta_ods.nombre_mo);
                    $('#verindip').text(data.producto.codigo_ip + '. ' + data.producto.nombre_ip);
                    $('#verestado').text(data.estado_imo).removeClass().addClass('badge').addClass(data.estado_imo === 'Activo' ? 'bg-success' : 'bg-danger');
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
                    $('#veripmomodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);         
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var IPMOId = $(this).data('id');
            var url = "{{ route('editaripmo', ['id' => ':id']) }}";
            url = url.replace(':id', IPMOId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#id_ip_editar').val(data.id_mr).trigger('change');
                    var url = "{{ route('mostrar_ods') }}";
                    $.ajax({
                        url: url,
                        type: 'get',
                        success: function(data1) {
                            var $odsSelect = $('#id_ods_editar');
                            $odsSelect.empty();
                            $odsSelect.append('<option value="" disabled>Seleccionar</option>');
                            data1.forEach(function(Ods) {
                                if (data.meta_ods.ods.id === Ods.id)
                                    $odsSelect.append('<option value="' + Ods.id + ' selected">' + Ods.codigo_ods + '. ' + Ods.nombre_ods + '</option>');
                                else
                                    $odsSelect.append('<option value="' + Ods.id + '">' + Ods.codigo_ods + '. ' + Ods.nombre_ods + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                        },
                    });
                    $('#id_mo_editar').val(data.id_mo).trigger('change');
                    $('#estado').val(data.estado_ip);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
        $(document).on('click', '.eliminar', function() {
            var IPMOId = $(this).data('id');
            var url = "{{ route('eliminaripmo', ['id' => ':id']) }}";
            url = url.replace(':id', IPMOId);
            Swal.fire({
                title: "Esta seguro de desactivar la Meta Ods en el Indicador de Producto?",
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
                                    text: "LA Meta Ods en el Indicador de Producto ha sido desactivada.",
                                    icon: "success"
                                });
                                $('#ipmo-row-' + IPMOId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#ipmo-row-' + IPMOId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#ipmos').DataTable().row('#ipmo-row-' + IPMOMOId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "Meta Ods en el Indicador de Producto no ha sido desactivada.",
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