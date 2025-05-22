@extends('Layouts.plantilla')

@section('titulo', 'Usuarios')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Usuarios
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importarusuariosmodal" title="cargar usuarios">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarusuariomodal" title="nuevo usuario">
                            <i class="fas fa-plus"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Usuarios</li>
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
                    <table class="display" id="usuarios" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">No</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Rol</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($usuarios as $usuario)
                                <tr class="text-center" id="user-row-{{ $usuario->id }}">
                                    <td class="text-center">
                                        {{ $i++ }}
                                    </td>
                                    <td class="text-start">
                                        {{ $usuario->name }}
                                    </td>
                                    <td class="text-center">
                                        <b class="badge bg-primary">
                                            {{ $usuario->rol->nombre_r }}
                                        </b>
                                    </td>
                                    <td class="text-center">
                                        @if ($usuario->estado_u == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $usuario->estado_u }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $usuario->estado_u }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($usuario->estado_u == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $usuario->id }}" data-toggle="modal" data-target="#verusuariomodal" title="ver usuario">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $usuario->id }}" data-toggle="modal" data-target="#editarusuariomodal" title="modificar usuario">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $usuario->id }}" title="desactivar usuario">
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

    <div class="modal fade" id="agregarusuariomodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Usuario</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardarusuario') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="name">Nombre Completo <b class="text-danger"> * </b></label>
                            <input type="text" name="name" class="form-control"
                                placeholder="Ingrese el nombre del usuario" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="email">Correo Electronico <b class="text-danger"> * </b></label>
                            <input type="email" name="email" class="form-control"
                                placeholder="Ingrese el correo electronico" required>
                        </div>

                        <input type="hidden" name="password" class="form-control">
                        
                        <div class="form-group m-2">
                            <label for="dependencia">Dependencia <b class="text-danger"> * </b></label>
                            <select name="id_dependencia" id="id_dependencia" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($dependencias as $d)
                                    <option value="{{ $d->id }}">{{ $d->nombre_d }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group m-2">
                            <label for="rol">Tipo de Rol <b class="text-danger"> * </b></label>
                            <select name="id_rol" id="id_rol" class="form-control">
                                <option value="" disabled selected>Seleccionar</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r->id }}">{{ $r->nombre_r }}</option>
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
        <div class="modal-dialog modal-dialog-scrollable" role="document">
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
                    <p><strong>Registro: </strong><span id="vercreado"></span></p>
                    <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarusuariomodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
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
                                    <option value="{{ $d->id }}">{{ $d->nombre_d }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group m-2">
                            <label for="rol">Tipo de Rol</label>
                            <select name="id_rol" id="id_rol_editar" class="form-control" style="width: 100%">
                                <option value="" disabled>Seleccionar</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r->id }}">{{ $r->nombre_r }}</option>
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

    <div class="modal fade" id="importarusuariosmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Usuarios (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvusuarios') }}" method="POST" enctype="multipart/form-data">
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
                    url: "../plugins/datatables/idioma.json", // Traducción al español
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
                    $('#verdependencia').text(data.dependencia.nombre_d);
                    $('#verrol').text(data.rol.nombre_r);
                    $('#verestado').text(data.estado_u).removeClass().addClass('badge').addClass(data.estado_u === 'Activo' ? 'bg-success' : 'bg-danger');
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
                    $('#id_dependencia_editar').val(data.id_d).trigger('change');
                    $('#id_rol_editar').val(data.id_r).trigger('change');
                    $('#estado').val(data.estado_u);
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