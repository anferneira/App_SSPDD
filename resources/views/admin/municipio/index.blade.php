@extends('Layouts.plantilla')

@section('titulo', 'Municipios')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Municipios
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarmunicipiomodal" title="nuevo municipio">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importarmunicipiomodal" title="cargar municipios">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Municipios</li>
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
                    <table class="display" id="municipios" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">Código Dane</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($municipios as $mun)
                                <tr class="text-center" id="mun-row-{{ $mun->id }}">
                                    <td class="text-center">
                                        {{ $mun->codigo_m }}
                                    </td>
                                    <td class="text-start">
                                        {{ $mun->nombre_m }}
                                    </td>
                                    <td class="text-center">
                                        @if ($mun->estado_m == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $mun->estado_m }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $mun->estado_m }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($mun->estado_m == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $mun->id }}" data-toggle="modal" data-target="#vermunicipiomodal" title="ver municipio">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $mun->id }}" data-toggle="modal" data-target="#editarmunicipiomodal" title="modificar municipio">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $mun->id }}" title="desactivar municipio">
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

    <div class="modal fade" id="agregarmunicipiomodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Municipio</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardarmunicipio') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="codigo">Código Dane <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" id="codigo" class="form-control"
                                placeholder="Ingrese el Código Dane del municipio" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="name">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                placeholder="Ingrese el nombre del municipio" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="longitud">Longitud <b class="text-danger"> * </b></label>
                            <input type="text" name="longitud" id="longitud" class="form-control"
                                placeholder="Ingrese el valor de la longitud del municipio" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="latitud">Latitud <b class="text-danger"> * </b></label>
                            <input type="text" name="latitud" id="latitud" class="form-control"
                                placeholder="Ingrese el valor de la latitud del municipio" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="provincia">Provincia</label>
                            <select name="id_p" id="id_p" class="form-control" style="width: 100%">
                                <option value="" disabled>Seleccionar</option>
                                @foreach ($provincias as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre_p }}</option>
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

    <div class="modal fade" id="vermunicipiomodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos del Municipio</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Código Dane: </strong><span id="vercodigo"></span></p>
                    <p><strong>Municipio: </strong><span id="vernombre"></span></p>
                    <p><strong>Provincia: </strong><span id="verprovincia"></span></p>
                    <p><strong>Latitud: </strong><span id="verlatitud"></span></p>
                    <p><strong>Longitud: </strong><span id="verlongitud"></span></p>
                    <p><strong>Estado: </strong><span id="verestado"></span></p>
                    <p><strong>Registro: </strong><span id="vercreado"></span></p>
                    <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarmunicipiomodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos del Municipio</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizarmunicipio') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group m-2">
                            <label for="codigo">Código Dane <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" id="codigo_editar" class="form-control"
                                placeholder="Ingrese el Código Dane del municipio" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="name">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" id="nombre_editar" class="form-control"
                                placeholder="Ingrese el nombre del municipio" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="longitud">Longitud <b class="text-danger"> * </b></label>
                            <input type="text" name="longitud" id="longitud_editar" class="form-control"
                                placeholder="Ingrese el valor de la longitud del municipio" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="latitud">Latitud <b class="text-danger"> * </b></label>
                            <input type="text" name="latitud" id="latitud_editar" class="form-control"
                                placeholder="Ingrese el valor de la latitud del municipio" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="provincia">Provincia</label>
                            <select name="id_p" id="id_p_editar" class="form-control" style="width: 100%">
                                <option value="" disabled>Seleccionar</option>
                                @foreach ($provincias as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre_p }}</option>
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

    <div class="modal fade" id="importarmunicipiomodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Municipios (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvmunicipios') }}" method="POST" enctype="multipart/form-data">
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
            $('#municipios').DataTable({
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
            var MunicipioId = $(this).data('id');
            var url = "{{ route('vermunicipio', ['id' => ':id']) }}";
            url = url.replace(':id', MunicipioId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#vercodigo').text(data.codigo_m); 
                    $('#vernombre').text(data.nombre_m);
                    $('#verprovincia').text(data.provincia.nombre_p);
                    $('#verlatitud').text(data.latitud_m);
                    $('#verlongitud').text(data.longitud_m);
                    $('#verprovincia').text(data.provincia.nombre_m);
                    $('#verestado').text(data.estado_m).removeClass().addClass('badge').addClass(data.estado_m === 'Activo' ? 'bg-success' : 'bg-danger');
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
                    $('#vermunicipiomodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var MunicipioId = $(this).data('id');
            var url = "{{ route('editarmunicipio', ['id' => ':id']) }}";
            url = url.replace(':id', MunicipioId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#codigo_editar').val(data.codigo_m);
                    $('#nombre_editar').val(data.nombre_m);
                    $('#latitud_editar').val(data.latitud_m);
                    $('#longitud_editar').val(data.longitud_m);
                    $('#id_p_editar').val(data.id_p);//.trigger('change');
                    $('#estado').val(data.estado_m);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
        $(document).on('click', '.eliminar', function() {
            var MunicipioId = $(this).data('id');
            var url = "{{ route('eliminarmunicipio', ['id' => ':id']) }}";
            url = url.replace(':id', MunicipioId);
            Swal.fire({
                title: "Esta seguro de desactivar el Municipio?",
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
                                    text: "El Municipio ha sido desactivada.",
                                    icon: "success"
                                });
                                $('#mun-row-' + MunicipioId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#mun-row-' + MunicipioId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#municipios').DataTable().row('#mun-row-' + MunicipioId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "El Municipio no ha sido desactivada.",
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