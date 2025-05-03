@extends('Layouts.plantilla')

@section('titulo', 'Indicadores de Resultado')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Indicadores de Resultado
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarirmodal" title="nueva indicador">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importarirmodal" title="cargar indicadores">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Indicadores de Resultado</li>
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
                    <table class="display" id="irs" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">Código</th>
                                <th class="text-center" width="60%">Nombre</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($irs as $ir)
                                <tr class="text-center" id="ir-row-{{ $ir->id }}">
                                    <td class="text-center">
                                        {{ $ir->codigo_ir }}
                                    </td>
                                    <td class="text-start" width="60%">
                                        {{ $ir->nombre_ir }}
                                    </td>
                                    <td class="text-center">
                                        @if ($ir->estado_ir == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $ir->estado_ir }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $ir->estado_ir }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($ir->estado_ir == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $ir->id }}" data-toggle="modal" data-target="#verirmodal" title="ver indicador">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $ir->id }}" data-toggle="modal" data-target="#editarirmodal" title="modificar indicador">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $ir->id }}" title="desactivar indicador">
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

    <div class="modal fade" id="agregarirmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Indicador de Resultado</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardarir') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="codigo">Código <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" class="form-control"
                                placeholder="Ingrese el código del indicador" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="nombre">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" class="form-control"
                                placeholder="Ingrese el nombre del indicador" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="linea">Línea <b class="text-danger"> * </b></label>
                            <input type="text" name="linea" class="form-control"
                                placeholder="Ingrese la línea base del indicador" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="fuente">Fuente / Año <b class="text-danger"> * </b></label>
                            <input type="text" name="fuente" class="form-control"
                                placeholder="Ingrese la fuente y el año del indicador" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="meta">Meta 2027 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta" class="form-control"
                                placeholder="Ingrese la meta del indicador" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="transformacion">Transformación PND <b class="text-danger"> * </b></label>
                            <input type="text" name="transformacion" class="form-control"
                                placeholder="Ingrese la transformación PND del indicador" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="id_mr">Medida <b class="text-danger"> * </b></label>
                            <select name="id_e" id="id_mr" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($medidas as $m)
                                    <option value="{{ $m->id }}">{{ $m->nombre_mr }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_mo">Meta ODS <b class="text-danger"> * </b></label>
                            <select name="id_mo" id="id_mo" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($metas as $me)
                                    <option value="{{ $me->id }}">{{ $me->codigo_mo.'. '.$me->nombre_mo }}</option>
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

    <div class="modal fade" id="verirmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos del Indicador de Resultado</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Código: </strong><span id="vercodigo"></span></p>
                    <p><strong>Nombre: </strong><span id="vernombre"></span></p>
                    <p><strong>Línea Base: </strong><span id="verlinea"></span></p>
                    <p><strong>Fuente / Año: </strong><span id="verfuente"></span></p>
                    <p><strong>Meta 2027: </strong><span id="vermeta"></span></p>
                    <p><strong>Tranformación PND: </strong><span id="vertransformacion"></span></p>
                    <p><strong>Medido a Través: </strong><span id="vermedido"></span></p>
                    <p><strong>ODS: </strong><span id="verods"></span></p>
                    <p><strong>Meta ODS: </strong><span id="vermetaods"></span></p>
                    <p><strong>Estado: </strong><span id="verestado" class="badge bg-danger"></span></p>
                    <p><strong>Registro: </strong><span id="vercreado"></span></p>
                    <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarirmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos del Indicador de Resultado</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizarir') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group m-2">
                            <label for="codigo">Código <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" id="codigo" class="form-control"
                                placeholder="Ingrese el código del indicador" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="nombre">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                placeholder="Ingrese el nombre del indicador" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="linea">Línea <b class="text-danger"> * </b></label>
                            <input type="text" name="linea" id="linea" class="form-control"
                                placeholder="Ingrese la línea base del indicador" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="fuente">Fuente / Año <b class="text-danger"> * </b></label>
                            <input type="text" name="fuente" id="fuente" class="form-control"
                                placeholder="Ingrese la fuente y el año del indicador" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="meta">Meta 2027 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta" id="meta" class="form-control"
                                placeholder="Ingrese la meta del indicador" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="transformacion">Transformación PND <b class="text-danger"> * </b></label>
                            <input type="text" name="transformacion" id="transformacion" class="form-control"
                                placeholder="Ingrese la transformación PND del indicador" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="id_mr">Medida <b class="text-danger"> * </b></label>
                            <select name="id_mr" id="id_mr_editar" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($medidas as $m)
                                    <option value="{{ $m->id }}">{{ $m->nombre_mr }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_mo">Meta ODS <b class="text-danger"> * </b></label>
                            <select name="id_mo" id="id_mo_editar" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($metas as $me)
                                    <option value="{{ $me->id }}">{{ $me->codigo_mo.'. '.$me->nombre_mo }}</option>
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

    <div class="modal fade" id="importarirmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Indicadores de Resultados (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvirs') }}" method="POST" enctype="multipart/form-data">
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
            $('#irs').DataTable({
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
            var IRId = $(this).data('id');
            var url = "{{ route('verir', ['id' => ':id']) }}";
            url = url.replace(':id', IRId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#vercodigo').text(data.codigo_ir);
                    $('#vernombre').text(data.nombre_ir);
                    $('#verlinea').text(data.linea_ir);
                    $('#verfuente').text(data.fuente_ir);
                    $('#vermeta').text(data.meta_ir);
                    $('#vertransformacion').text(data.transformacion_ir);
                    $('#vermedido').text(data.medidas.nombre_mr);
                    $('#verods').text(data.metas_ods.ods.codigo_ods + '. ' + data.metas_ods.ods.nombre_ods);
                    $('#vermetaods').text(data.metas_ods.codigo_mo + '. ' + data.metas_ods.nombre_mo);
                    $('#verestado').text(data.estado_ir).removeClass().addClass('badge').addClass(data.estado_ir === 'Activo' ? 'bg-success' : 'bg-danger');
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
                    $('#verirmodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var IRId = $(this).data('id');
            var url = "{{ route('editarir', ['id' => ':id']) }}";
            url = url.replace(':id', IRId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#codigo').val(data.codigo_ir);
                    $('#nombre').val(data.nombre_ir);
                    $('#linea').val(data.linea_ir);
                    $('#fuente').val(data.fuente_ir);
                    $('#meta').val(data.meta_ir);
                    $('#transformacion').val(data.transformacion_ir);
                    $('#id_mr_editar').val(data.id_mr).trigger('change');
                    $('#id_mo_editar').val(data.id_mo).trigger('change');
                    $('#estado').val(data.estado_ir);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
        $(document).on('click', '.eliminar', function() {
            var IRId = $(this).data('id');
            var url = "{{ route('eliminarir', ['id' => ':id']) }}";
            url = url.replace(':id', IRId);
            Swal.fire({
                title: "Esta seguro de desactivar el Indicador de Resultado?",
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
                                    text: "El Indicador de Resultado ha sido desactivado.",
                                    icon: "success"
                                });
                                $('#ir-row-' + IRId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#ir-row-' + IRId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#ires').DataTable().row('#ir-row-' + IRId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "El Indicador de Resultado no ha sido desactivado.",
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