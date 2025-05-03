@extends('Layouts.plantilla')

@section('titulo', 'Indicadores de Producto')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Indicadores de Producto
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregaripmodal" title="nueva indicador">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importaripmodal" title="cargar indicadores">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Indicadores de Producto</li>
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
                    <table class="display" id="ips" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">Código</th>
                                <th class="text-center" width="60%">Nombre</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($ips as $ip)
                                <tr class="text-center" id="ip-row-{{ $ip->id }}">
                                    <td class="text-center">
                                        {{ $ip->codigo_ip }}
                                    </td>
                                    <td class="text-start" width="60%">
                                        {{ $ip->nombre_ip }}
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
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $ip->id }}" data-toggle="modal" data-target="#veripmodal" title="ver indicador">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $ip->id }}" data-toggle="modal" data-target="#editaripmodal" title="modificar indicador">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $ip->id }}" title="desactivar indicador">
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

    <div class="modal fade" id="agregaripmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Indicador de Producto</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardarip') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="codigo">Código <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" class="form-control"
                                placeholder="Ingrese el código del indicador" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="nombre">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" class="form-control"
                                placeholder="Ingrese el nombre del indicador" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="descripcion">Descripción <b class="text-danger"> * </b></label>
                            <input type="text" name="descripcion" class="form-control"
                                placeholder="Ingrese el descripcion del indicador" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="linea">Línea Base <b class="text-danger"> * </b></label>
                            <input type="text" name="linea" class="form-control"
                                placeholder="Ingrese la línea base del indicador" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="fuente">Fuente / Año <b class="text-danger"> * </b></label>
                            <input type="text" name="fuente" class="form-control"
                                placeholder="Ingrese la fuente y el año del indicador" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="meta">Meta 2027 Plan de Desarrollo<b class="text-danger"> * </b></label>
                            <input type="text" name="meta" class="form-control"
                                placeholder="Ingrese la meta del indicador del PD" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="meta_real">Meta 2027 Real<b class="text-danger"> * </b></label>
                            <input type="text" name="meta_real" class="form-control"
                                placeholder="Ingrese la meta del indicador del PD real" requiped>
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

    <div class="modal fade" id="veripmodal" tabindex="-1" aria-labelledby="veripmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos del Indicador de Producto</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body" width="10px">
                    <p><strong>ODS: </strong><span id="verods"></span></p>
                    <p><strong>Meta ODS: </strong><span id="vermeto"></span></p>
                    <p><strong>Indicador MGA: </strong><span id="verindmga"></span></p>
                    <p><strong>Indicador de Resultado: </strong><span id="verindir"></span></p>
                    <p><strong>Indicador de Producto: </strong><span id="verindip"></span></p>
                    <p><strong>Descripción: </strong><span id="verdesc"></span></p>
                    <p><strong>Dependencia Responsable: </strong><span id="verdepres"></span></p>
                    <p><strong>Sectorial: </strong><span id="versec"></span></p>
                    <p><strong>Dependencia Encargada: </strong><span id="verdepenc"></span></p>
                    <p><strong>Estrategia: </strong><span id="verest"></span></p>
                    <p><strong>Dimension: </strong><span id="verdim"></span></p>
                    <p><strong>Apuesta: </strong><span id="verapu"></span></p>
                    <p><strong>Línea Base: </strong><span id="verlinea"></span></p>
                    <p><strong>Fuente: </strong><span id="verfuente"></span></p>
                    <p><strong>Meta 2027 PD: </strong><span id="vermeta"></span></p>
                    <p><strong>Meta 2027 Real: </strong><span id="vermetareal"></span></p>
                    <p><strong>Frecuencia de Medición: </strong><span id="verfre"></span></p>
                    <p><strong>Medido a Través: </strong><span id="vermed"></span></p>
                    <p><strong>Es Plan Abrigo?: </strong><span id="verpa"></span></p>
                    <p><strong>Orientación: </strong><span id="veror"></span></p>
                    <p><strong>Dimensión de Pobreza: </strong><span id="verdp"></span></p>
                    <p><strong>Variable de Pobreza: </strong><span id="vervp"></span></p>
                    <p><strong>Pilar EDPM: </strong><span id="vernedpm"></span></p>
                    <p><strong>Programa EDPM: </strong><span id="verpedpm"></span></p>
                    <p><strong>Estado: </strong><span id="verestado" class="badge bg-danger"></span></p>
                    <p><strong>Registro: </strong><span id="vercreado"></span></p>
                    <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="veripodsmodal" tabindex="-1" aria-labelledby="veripodsmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos de la ODS del Indicador de Producto</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body" width="10px">
                    <p><strong>Código: </strong><span id="vercodigoods"></span></p>
                    <p><strong>Nombre: </strong><span id="vernombreods"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="veripmetaodsmodal" tabindex="-1" aria-labelledby="veripmetaodsmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos de la Meta ODS del Indicador de Producto</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body" width="10px">
                    <p><strong>ODS: </strong><span id="verodsmeta"></span></p>
                    <p><strong>Código: </strong><span id="vercodmetods"></span></p>
                    <p><strong>Nombre: </strong><span id="vernommetods"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editaripmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos del Indicador de Producto</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizarip') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group m-2">
                            <label for="codigo">Código <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" id="codigo_editar" class="form-control"
                                placeholder="Ingrese el código del indicador" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="nombre">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" id="nombre_editar" class="form-control"
                                placeholder="Ingrese el nombre del indicador" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="linea">Línea <b class="text-danger"> * </b></label>
                            <input type="text" name="linea" id="linea_editar" class="form-control"
                                placeholder="Ingrese la línea base del indicador" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="fuente">Fuente / Año <b class="text-danger"> * </b></label>
                            <input type="text" name="fuente" id="fuente_editar" class="form-control"
                                placeholder="Ingrese la fuente y el año del indicador" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="meta">Meta 2027 Plan de Desarrollo<b class="text-danger"> * </b></label>
                            <input type="text" name="meta" id="meta_editar" class="form-control"
                                placeholder="Ingrese la meta del indicador del PD" requiped>
                        </div>

                        <div class="form-group m-2">
                            <label for="meta_real">Meta 2027 Real<b class="text-danger"> * </b></label>
                            <input type="text" name="meta_real" id="meta_real_editar" class="form-control"
                                placeholder="Ingrese la meta del indicador del PD real" requiped>
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

    <div class="modal fade" id="importaripmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Indicadores de Productos (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvips') }}" method="POST" enctype="multipart/form-data">
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
            $('#ips').DataTable({
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
            var IPId = $(this).data('id');
            var url = "{{ route('verip', ['id' => ':id']) }}";
            url = url.replace(':id', IPId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    // Crear los hipervínculos para cada ods, ahora con un evento de clic que abrirá el modal
                    var odsConcatenados = data.ods.map(function(ods) {
                        return `<a href="javascript:void(0);" class="ver-ods-link" data-id="${ods.id}" id="ods">${ods.codigo_ods}</a>`;
                    }).join('_');  // Se usa guion bajo para separar los hipervínculos
                    // Mostrar el resultado concatenado en el lugar adecuado
                    // Concatenar los códigos ods separados por _
                    var MetaodsConcatenados = data.metas_ods.map(function(ods) {
                        return `<a href="javascript:void(0);" class="ver-meta-ods-link" data-id="${ods.id}" id="meta_ods">${ods.codigo_mo}</a>`;
                    }).join('_');
                    // Mostrar el resultado concatenado en el lugar adecuado
                    $('#verods').html(odsConcatenados);
                    $('#vermeto').html(MetaodsConcatenados);
                    $('#verindmga').text(data.mga.codigo_mga + '. ' + data.mga.producto_mga);
                    $('#verindir').text(data.resultado.codigo_ir + '. ' + data.resultado.nombre_ir);
                    $('#verindip').text(data.codigo_ip + '. ' + data.nombre_ip);
                    $('#verdesc').text(data.descripcion_ip);
                    $('#verdepres').text(data.dependencia.nombre_d);
                    $('#versec').text(data.programa.sectorial.codigo_s + '. ' + data.programa.sectorial.nombre_s);
                    $('#verdepenc').text(data.programa.sectorial.sectordependencia.nombre_d);
                    $('#verest').text(data.apuesta.dimension.estrategia_dimension.codigo_e + '. ' + data.apuesta.dimension.estrategia_dimension.nombre_e);
                    $('#verdim').text(data.apuesta.dimension.codigo_d + '. ' + data.apuesta.dimension.nombre_d);
                    $('#verapu').text(data.apuesta.codigo_a + '. ' + data.apuesta.nombre_a);
                    $('#verlinea').text(data.linea_ip);
                    $('#verfuente').text(data.fuente_ip);
                    $('#vermeta').text(data.meta_ip);
                    $('#vermetareal').text(data.meta_ip_real);
                    $('#verfre').text(data.frecuencia_ip);
                    $('#vermed').text(data.medida.medido_mp);
                    $('#verpa').text(data.abrigo_ip);
                    $('#veror').text(data.orientar.nombre_o);
                    $('#verdp').text(data.variable.dimension.codigo_dp + '. ' + data.variable.dimension.nombre_dp);
                    $('#vervp').text(data.variable.nombre_vp);
                    $('#vernedpm').text(data.edpm.nombre_edpm);
                    $('#verpedpm').text(data.edpm.programa_edpm);
                    $('#verestado').text(data.estado_ip).removeClass().addClass('badge').addClass(data.estado_ip === 'Activo' ? 'bg-success' : 'bg-danger');
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
                    $('#veripmodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.ver-ods-link', function() {
            var IPODSId = $(this).data('id');
            var url = "{{ route('veripods', ['id' => ':id']) }}";
            url = url.replace(':id', IPODSId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    $('#vercodigoods').text(data.codigo_ods);
                    $('#vernombreods').text(data.nombre_ods);
                    //$('#veripmetaodsmodal').show();
                    var modalods = new bootstrap.Modal(document.getElementById('veripodsmodal'));
                    modalods.show(); // Mostrar el segundo modal
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.ver-meta-ods-link', function() {
            var IPMETODSId = $(this).data('id');
            var url = "{{ route('veripmetods', ['id' => ':id']) }}";
            url = url.replace(':id', IPMETODSId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    $('#verodsmeta').text(data.ods.codigo_ods + '. ' + data.ods.nombre_ods);
                    $('#vercodmetods').text(data.codigo_mo);
                    $('#vernommetods').text(data.nombre_mo);
                    //$('#veripmetodsmodal').show();
                    var modalmetaods = new bootstrap.Modal(document.getElementById('veripmetaodsmodal'));
                    modalmetaods.show(); // Mostrar el segundo modal
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var IPId = $(this).data('id');
            var url = "{{ route('editarip', ['id' => ':id']) }}";
            url = url.replace(':id', IPId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#codigo_editar').val(data.codigo_ip);
                    $('#nombre_editar').val(data.nombre_ip);
                    $('#linea_editar').val(data.linea_ip);
                    $('#fuente_editar').val(data.fuente_ip);
                    $('#meta_editar').val(data.meta_ip);
                    $('#id_mr_editar').val(data.id_mr).trigger('change');
                    $('#id_mo_editar').val(data.id_mo).trigger('change');
                    $('#meta_real_editar').val(data.meta_ip_real);
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
            var IPId = $(this).data('id');
            var url = "{{ route('eliminarip', ['id' => ':id']) }}";
            url = url.replace(':id', IPId);
            Swal.fire({
                title: "Esta seguro de desactivar el Indicador de Producto?",
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
                                    text: "El Indicador de Producto ha sido desactivado.",
                                    icon: "success"
                                });
                                $('#ip-row-' + IPId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#ip-row-' + IPId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#ipes').DataTable().row('#ip-row-' + IPId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "El Indicador de Producto no ha sido desactivado.",
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