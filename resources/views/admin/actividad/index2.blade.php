@extends('Layouts.plantilla')

@section('titulo', 'Actividades - Indicador')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>Programación de Actividades
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregaractividadmodal" title="nuevo actividad">
                            <i class="fas fa-plus"></i>
                        </button>
                        <a href="{{ route('listaracts') }}" class="btn btn-primary">
                            Volver a Indicadores
                        </a>
                    </h1>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Actividades del Indicador</li>
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
                    <div class="row container-fluid">
                        <div class="table-responsive">
                            <table class="table w-100" id="ips">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th class="text-center">Estrategia de Desarollo</th>
                                        <th class="text-center">Dimensión</th>
                                        <th class="text-center">Apuesta</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    <tr class="text-center">
                                        <td id="est" class="text-center">{{ $ip->apuesta->dimension->estrategia_dimension->codigo_e.'. '.$ip->apuesta->dimension->estrategia_dimension->nombre_e }}</th>
                                        <td id="dep" class="text-center">{{ $ip->apuesta->dimension->codigo_d.'. '.$ip->apuesta->dimension->nombre_d }}</th>
                                        <td id="apu" class="text-center">{{ $ip->apuesta->codigo_a.'. '.$ip->apuesta->nombre_a }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row container-fluid">
                        <div class="table-responsive">
                            <table class="table w-100" id="ips">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th class="text-center">Indicador</th>
                                        <th class="text-center">Dependencia Responsable</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    <tr class="text-center">
                                        <td id="ind" class="text-center"><input type="text" id="id_ip" hidden value="{{ $ip->id }}">{{ $ip->codigo_ip.'. '.$ip->nombre_ip }}</th>
                                        <td id="dep" class="text-center">{{ $ip->dependencia->nombre_d }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group m-2">
                                <label for="id_anio" class="position-relative" style="top: -25px;">Año</label>
                                <select name="id_anio" id="id_anio" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="0" selected>Todos</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-2">
                                <label for="id_trimestre" class="position-relative" style="top: -25px;">Trimestre</label>
                                <select name="id_trimestre" id="id_trimestre" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="0" selected>Todos</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>      
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row container-fluid">
                        <div class="table-responsive">
                            <table class="table w-100" id="acts">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th class="text-center">Código</th>
                                        <th class="text-center" width="60%">Actividad</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    @foreach ($acts as $act)
                                        <tr class="text-center" id="act-row-{{ $act->id }}">
                                            <td class="text-center">
                                                {{ $act->codigo_a }}
                                            </td>
                                            <td class="text-start" with="60%">
                                                {{ $act->nombre_a }}
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
                                                <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $act->id }}" data-toggle="modal" data-target="#veractividadmodal" title="ver actividad">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $act->id }}" data-toggle="modal" data-target="#editaractividadmodal" title="modificar actividad">
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
            </div>
        </div>

        <div class="modal fade" id="agregaractividadmodal">
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
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                </select>
                            </div>
    
                            <div class="form-group m-2">
                                <label for="trimestre">Trimestre <b class="text-danger"> * </b></label>
                                <select name="trimestre" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    
        
    
        <div class="modal fade" id="editaractividadmodal">
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
                            <input type="hidden" name="id_ip" id="id_ip_editar">
                            <input type="hidden" name="id_dep" id="id_dep_editar">
                            <div class="form-group m-2">
                                <label for="codigo">Código <b class="text-danger"> * </b></label>
                                <input type="text" name="codigo" id="codigo_editar" class="form-control"
                                    placeholder="Ingrese el código de la actividad" requiped>
                            </div>
    
                            <div class="form-group m-2">
                                <label for="nombre">Nombre <b class="text-danger"> * </b></label>
                                <input type="text" name="nombre" id="nombre_editar" class="form-control"
                                    placeholder="Ingrese el nombre de la actividad" requiped>
                            </div>
    
                            <div class="form-group m-2">
                                <label for="anio">Año <b class="text-danger"> * </b></label>
                                <select name="anio" id="anio_editar" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                </select>
                            </div>
    
                            <div class="form-group m-2">
                                <label for="trimestre">Trimestre <b class="text-danger"> * </b></label>
                                <select name="trimestre" id="trimestre_editar" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
    
                            <div class="form-group m-2">
                                <label for="meta">Meta 2027 <b class="text-danger"> * </b></label>
                                <input type="text" name="meta" id="meta_editar" class="form-control"
                                    placeholder="Ingrese la meta de la actividad" requiped>
                            </div>
    
                            <div class="form-group m-2">
                                <label for="aporte">Aporte <b class="text-danger"> * </b></label>
                                <input type="text" name="aporte" id="aporte_editar" class="form-control"
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

        <div class="modal fade" id="veractividadmodal">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Ver Datos de la Actividad</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
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
    </section>
@endsection

@section('scripts')
    <script>
        document.getElementById('meta').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('meta_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('aporte').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('aporte_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        $(document).ready(function() {
            // Inicializar DataTable
            $('#acts').DataTable({
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
                    url: "/plugins/datatables/idioma.json", // Traducción al español
                },
                columnDefs: [
                    { className: "text-center", orderable: false, targets: "_all" } // Desactivar ordenación en la columna de acciones
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
                    $('#codigo_editar').val(data.codigo_a);
                    $('#nombre_editar').val(data.nombre_a);
                    $('#id_ip_editar').val(data.id_ip);
                    $('#aporte_editar').val(data.aporte_a.replace(',', '.'));
                    $('#meta_editar').val(data.meta_a.replace(',', '.'));
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

        $('#id_anio').on('change', function () {
            var AnioId = $(this).val();
            var IndId = document.getElementById('id_ip').value;
            var TriId = document.getElementById('id_trimestre').value;
            var url = "{{ route('veractividades_anio2', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var table = $('#acts').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    data.forEach(function(item) {
                        // Definir la clase para el estado basado en el valor
                        var estadoClass = item.estado_a == 'Activo' ? 'bg-success' : 'bg-danger';
                        var estadoText = item.estado_a == 'Activo' ? 'Activo' : 'Inactivo';

                        // Agregar los datos a la tabla
                        table.row.add([
                            `<td class="text-center">${item.codigo_a}</td>`, // Código centrado
                            `<td class="text-center">${item.nombre_a}</td>`, // Nombre centrado
                            `<td class="text-center"><b class="badge ${estadoClass}">${estadoText}</b></td>`, // Estado centrado
                            `<td class="text-center">
                                <button type="button" class="ver btn btn-sm btn-info" data-id="${item.id}" data-toggle="modal" data-target="#veractividadmodal" title="Ver actividad">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="editar btn btn-sm btn-warning" data-id="${item.id}" data-toggle="modal" data-target="#editaractividadmodal" title="Modificar actividad">
                                    <i class="fas fa-user-edit"></i>
                                </button>
                                <button type="button" class="eliminar btn btn-sm btn-danger ${est}" data-id="${item.id}" title="Desactivar actividad">
                                    <i class="fas fa-user-minus"></i>
                                </button>
                            </td>` // Botones centrados
                        ]);
                    });
                    table.draw();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });

        $('#id_trimestre').on('change', function () {
            var TriId = $(this).val();
            var AnioId = document.getElementById('id_anio').value;
            var IndId = document.getElementById('id_ip').value;
            var url = "{{ route('veractividades_anio2', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var table = $('#acts').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    data.forEach(function(item) {
                        // Definir la clase para el estado basado en el valor
                        var estadoClass = item.estado_a == 'Activo' ? 'bg-success' : 'bg-danger';
                        var estadoText = item.estado_a == 'Activo' ? 'Activo' : 'Inactivo';

                        // Agregar los datos a la tabla
                        table.row.add([
                            `<td class="text-center">${item.codigo_a}</td>`, // Código centrado
                            `<td class="text-center">${item.nombre_a}</td>`, // Nombre centrado
                            `<td class="text-center"><b class="badge ${estadoClass}">${estadoText}</b></td>`, // Estado centrado
                            `<td class="text-center">
                                <button type="button" class="ver btn btn-sm btn-info" data-id="${item.id}" data-toggle="modal" data-target="#veractividadmodal" title="Ver actividad">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="editar btn btn-sm btn-warning" data-id="${item.id}" data-toggle="modal" data-target="#editaractividadmodal" title="Modificar actividad">
                                    <i class="fas fa-user-edit"></i>
                                </button>
                                <button type="button" class="eliminar btn btn-sm btn-danger ${est}" data-id="${item.id}" title="Desactivar actividad">
                                    <i class="fas fa-user-minus"></i>
                                </button>
                            </td>` // Botones centrados
                        ]);
                    });
                    table.draw();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
    </script>    
@endsection