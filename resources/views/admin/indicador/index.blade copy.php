@extends('Layouts.plantilla')

@section('titulo', 'Indicadores')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Indicadores
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarindicadormodal" title="nuevo indicador">
                            <i class="fas fa-plus"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Indicadores</li>
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
                    <table class="display" id="indicadores" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">Código</th>
                                <th class="text-center">No</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($indicadores as $ind)
                                <tr class="text-center" id="ind-row-{{ $ind->id }}">
                                    <td class="text-center">
                                        {{ $i++ }}
                                    </td>
                                    <td class="text-start">
                                        {{ $ind->codigo }}
                                    </td>
                                    <td class="text-start">
                                        {{ $ind->nombre }}
                                    </td>
                                    <td class="text-center">
                                        @if ($ind->estado == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $ind->estado }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $ind->estado }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($ind->estado == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $ind->id }}" data-toggle="modal" data-target="#verindicadormodal" title="ver indicador">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $ind->id }}" data-toggle="modal" data-target="#editarindicadormodal" title="modificar indicador">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $ind->id }}" title="desactivar indicador">
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

    <div class="modal fade" id="agregarindicadormodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Indicador</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardarindicador') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="id_dependencia">Dependencia <b class="text-danger"> * </b></label>
                            <select name="id_dependencia" id="id_dependencia" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($dependencias as $d)
                                    <option value="{{ $d->id }}">{{ $d->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_estrategia">Estrategia <b class="text-danger"> * </b></label>
                            <select name="id_estrategia" id="id_estrategia" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_dimension">Dimensión <b class="text-danger"> * </b></label>
                            <select name="id_dimension" id="id_dimension" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_apuesta">Apuesta <b class="text-danger"> * </b></label>
                            <select name="id_apuesta" id="id_apuesta" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_sector">Sector <b class="text-danger"> * </b></label>
                                <select name="id_sector" id="id_sector" class="form-control">
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="id_tipo_indicador">Orientación <b class="text-danger"> * </b></label>
                            <select name="id_tipo_indicador" id="id_tipo_indicador" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($tipoindicador as $ti)
                                    <option value="{{ $ti->id }}">{{ $ti->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="codigo">Código <b class="text-danger"> * </b></label>
                            <input type="text" name="codigo" class="form-control"
                                placeholder="Ingrese el código del indicador" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="name">Nombre <b class="text-danger"> * </b></label>
                            <input type="text" name="nombre" class="form-control"
                                placeholder="Ingrese el nombre del usuario" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="descripcion">Descripción <b class="text-danger"> * </b></label>
                            <input type="text" name="descripcion" class="form-control"
                                placeholder="Ingrese la descripción del indicador" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="medido_a_traves">Medido a través de <b class="text-danger"> * </b></label>
                            <input type="text" name="medido_a_traves" class="form-control"
                                placeholder="Ingrese el concepto por el cuál se mide l indicador" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="unidad_medida">Unidad de Medida <b class="text-danger"> * </b></label>
                            <input type="text" name="unidad_medida" class="form-control"
                                placeholder="Ingrese la unidad de medida del indicador" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="frecuencia_reporte">Frecuencia del Reporte <b class="text-danger"> * </b></label>
                            <select name="frecuencia_reporte" id="frecuencia_reporte" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="Trimestral">Trimestral</option>
                                <option value="Semestral">Semestral</option>
                            </select>
                        </div>
                        <div class="form-group m-2">
                            <label for="meta_2024_3">Meta Periodo 3 del 2024 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2024_3" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="meta_2024_4">Meta Periodo 4 del 2024 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2024_4" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        meta 2024
                        <div class="form-group m-2">
                            <label for="meta_2025_1">Meta Periodo 1 del 2025 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2025_1" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="meta_2025_2">Meta Periodo 2 del 2025 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2025_2" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="meta_2025_3">Meta Periodo 3 del 2025 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2025_3" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="meta_2025_4">Meta Periodo 4 del 2025 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2025_4" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        meta 2025
                        <div class="form-group m-2">
                            <label for="meta_2026_1">Meta Periodo 1 del 2026 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2026_1" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="meta_2026_2">Meta Periodo 2 del 2026 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2026_2" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="meta_2026_3">Meta Periodo 3 del 2026 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2026_3" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="meta_2026_4">Meta Periodo 4 del 2026 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2026_4" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        meta 2026
                        <div class="form-group m-2">
                            <label for="meta_2027_1">Meta Periodo 1 del 2027 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2027_1" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="meta_2027_2">Meta Periodo 2 del 2027 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2027_2" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="meta_2027_3">Meta Periodo 3 del 2027 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2027_3" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        <div class="form-group m-2">
                            <label for="meta_2027_4">Meta Periodo 4 del 2027 <b class="text-danger"> * </b></label>
                            <input type="text" name="meta_2027_4" class="form-control"
                                placeholder="Ingrese el valor programado del indicador para este periodo" required>
                        </div>
                        meta 2027
                        meta cuatrenio
                        <div class="form-group m-2">
                            <label for="plan_abrigo">¿Es Plan Abrigo? <b class="text-danger"> * </b></label>
                            <select name="plan_abrigo" id="plan_abrigo" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="form-group m-2">
                            <label for="rol">Tipo de Rol <b class="text-danger"> * </b></label>
                            <select name="id_rol" id="id_rol" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r->id }}">{{ $r->nombre }}</option>
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

    <div class="modal fade" id="verusuariomodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos del Usuario</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Nombre: </strong><span id="vernombre"></span></p>
                    <p><strong>Email: </strong><span id="veremail"></span></p>
                    <p><strong>Rol: </strong><span id="verrol" class="badge bg-warning"></span></p>
                    <p><strong>Dependencia: </strong><span id="verdependencia"></span></p>
                    <p><strong>Estado: </strong><span id="verestado" class="badge bg-danger"></span></p>
                    <p><strong>Fecha de Registro: </strong><span id="vercreado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarusuariomodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos del Usuario</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizarusuario') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group m-2">
                            <label for="name">Nombre Completo</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Ingrese el nombre del usuario" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="email">Correo Electronico</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="Ingrese el correo electronico" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="dependencia">Dependencia</label>
                            <select name="id_dependencia" id="id_dependencia_editar" class="form-control" style="width: 100%">
                                <option value="" disabled>Seleccionar</option>
                                @foreach ($dependencias as $d)
                                    <option value="{{ $d->id }}">{{ $d->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group m-2">
                            <label for="rol">Tipo de Rol</label>
                            <select name="id_rol" id="id_rol_editar" class="form-control" style="width: 100%">
                                <option value="" disabled>Seleccionar</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r->id }}">{{ $r->nombre }}</option>
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
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            $('#usuarios').DataTable({
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
                    url: "//cdn.datatables.net/plug-ins/2.0.2/i18n/es-ES.json", // Traducción al español
                },
                columnDefs: [
                    { orderable: false, targets: 3 } // Desactivar ordenación en la columna de acciones
                ]
            });
        });
        $(document).on('click', '.ver', function() {
            var UsuarioId = $(this).data('id');
            var url = "{{ route('verusuario', ['id' => ':id']) }}";
            url = url.replace(':id', UsuarioId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#vernombre').text(data.name);
                    $('#veremail').text(data.email);
                    $('#verdependencia').text(data.dependencia.nombre);
                    $('#verrol').text(data.rol.nombre);
                    $('#verestado').text(data.estado);
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
                    $('#verusuariomodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var UsuarioId = $(this).data('id');
            var url = "{{ route('editarusuario', ['id' => ':id']) }}";
            url = url.replace(':id', UsuarioId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#id_dependencia_editar').val(data.id_dependencia).trigger('change');
                    $('#id_rol_editar').val(data.id_rol).trigger('change');
                    $('#estado').val(data.estado);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
        $(document).on('click', '.eliminar', function() {
            var UsuarioId = $(this).data('id');
            var url = "{{ route('eliminarusuario', ['id' => ':id']) }}";
            url = url.replace(':id', UsuarioId);
            Swal.fire({
                title: "Esta seguro de desactivar el Usuario?",
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
                            console.log(data);
                            if (data.success) {
                                Swal.fire({
                                    title: "¡Registro Desactivado!",
                                    text: "El usuario ha sido desactivado.",
                                    icon: "success"
                                });
                                $('#user-row-' + UsuarioId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#user-row-' + UsuarioId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#usuarios').DataTable().row('#user-row-' + UsuarioId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "El usuario no ha sido desactivado.",
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
        // Función para generar una cadena aleatoria
        function generarPasswordAleatorio(longitud = 8) {
            const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$&*';
            let password = '';
            for (let i = 0; i < longitud; i++) {
                password += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
            }
            return password;
        }
        $('#agregarusuariomodal').on('show.bs.modal', function() {
            const passwordAleatorio = generarPasswordAleatorio(8); // Longitud de 12 caracteres
            $('input[name="password"]').val(passwordAleatorio); // Asignar al campo de contraseña
        });
    </script>    
@endsection