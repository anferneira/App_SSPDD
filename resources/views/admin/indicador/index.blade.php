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
                                <th class="text-center">No</th>
                                <th class="text-center">Código</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Estado</th>
                                <!--<th class="text-center">Acciones</th>-->
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
                                        {{ $ind->codigo_interno }}
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
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            $('#indicadores').DataTable({
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
    </script>    
@endsection