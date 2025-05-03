@extends('Layouts.plantilla')

@section('titulo', 'Metas ODS Indicador de Producto')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Metas ODS Indicador de Producto
                        <a href="{{ route('listarips') }}" class="btn btn-sm btn-primary" title="="Volver">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Metas ODS Indicadores de Producto</li>
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

                <table class="display" style="width: 100%;">
                    <thead class="text-center">
                        <tr class="text-center">
                            <th class="text-center">Indicador Resultado</th>
                            <th class="text-center">Nombre Meta ODS</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($ips as $ip)
                            <tr class="text-center" id="ip-row-{{ $ip->id }}">
                                <td class="text-center">
                                    {{ $i++ }}
                                </td>
                                <td class="text-start" width="60%">
                                    {{ $ip->codigo_ip.'. '.$ip->nombre_ip }}
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
                                    
                                    <a href="{{ route('verip', $ip->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
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
    </section>
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
                        fipst: '<<',       // Primer página
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
                    $('#vercodigo').text(data.codigo_ip);
                    $('#vernombre').text(data.nombre_ip);
                    $('#verlinea').text(data.linea_ip);
                    $('#verfuente').text(data.fuente_ip);
                    $('#vermeta').text(data.meta_ip);
                    $('#vertransformacion').text(data.transformacion_ip);
                    $('#vermedido').text(data.medidas.nombre_mr);
                    $('#verods').text(data.metas_ods.ods.codigo_ods + '. ' + data.metas_ods.ods.nombre_ods);
                    $('#vermetaods').text(data.metas_ods.codigo_mo + '. ' + data.metas_ods.nombre_mo);
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
        $(document).on('click', '.editar', function() {
            var IPId = $(this).data('id');
            var url = "{{ route('editarip', ['id' => ':id']) }}";
            url = url.replace(':id', IPId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#codigo').val(data.codigo_ip);
                    $('#nombre').val(data.nombre_ip);
                    $('#linea').val(data.linea_ip);
                    $('#fuente').val(data.fuente_ip);
                    $('#meta').val(data.meta_ip);
                    $('#transformacion').val(data.transformacion_ip);
                    $('#id_mr_editar').val(data.id_mr).trigger('change');
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