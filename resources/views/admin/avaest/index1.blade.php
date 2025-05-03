@extends('Layouts.plantilla')

@section('titulo', 'Avances Estratégicos')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Indicadores de Producto</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Avance Estratégico</li>
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
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group m-2">
                                <label for="id_d" class="position-relative" style="top: -25px;">Dependencia</label>
                                <select name="id_d" id="id_d" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="0" selected>Todos</option>
                                    @foreach ($dependencias as $d)
                                        <option value="{{ $d->id }}">{{ $d->nombre_d }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <table class="display" id="avances" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">Código</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @foreach ($ips as $ip)
                                <tr class="text-center" id="ava-row-{{ $ip->id }}">
                                    <td class="text-center">
                                        {{ $ip->codigo_ip }}
                                    </td>
                                    <td class="text-center">
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
                                        <a href="{{ route('ver_ind2', $ip->id) }}" class="ver btn btn-sm btn-info" title="ver avances">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
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
            $('#avances').DataTable({
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
                    { orderable: false, targets: "_all" },                // Desactivar ordenación en la columna de acciones
                    { className: "text-center", targets: "_all" },        // Centra la segunda columna
                ]
            });
            // Verificar si hay un mensaje almacenado en localStorage
            /*let message = localStorage.getItem("toastr_message");
            if (message) {
                toastr.success(message);
                // Eliminar el mensaje para que no se vuelva a mostrar
                localStorage.removeItem("toastr_message");
            }*/
        });

        // Cuando se cambie el valor de la dependencia
        $('#id_d').on('change', function () {
            var id_d = $(this).val();
            var urlDependencia = "{{ route('dep_indi1', ['id' => ':id']) }}".replace(':id', id_d);
            $.ajax({
                url: urlDependencia,
                type: 'get',
                success: function(data) {
                    var table = $('#avances').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    
                    data.forEach(function(item) {
                        // Construcción del estado con la clase de color correcta
                        var estado = "<td class='text-center'>";
                        estado += item.estado_ip === 'Activo' 
                            ? "<b class='badge bg-success estado'>" + item.estado_ip + "</b></td>"
                            : "<b class='badge bg-danger'>" + item.estado_ip + "</b></td>";

                        // Construcción de la acción con el botón de ver
                        var AccionUrl = "{{ route('ver_ind1', ['id' => ':id']) }}".replace(':id', item.id);
                        var accion = '<td class="text-center">';
                        accion += '<a href="' + AccionUrl + '" class="ver btn btn-sm btn-info" title="ver actividades">';
                        accion += '<i class="fas fa-eye"></i></a></td>';

                        // Agregar la fila a la tabla
                        table.row.add([
                            item.codigo_ip,   // Código del indicador
                            item.nombre_ip,   // Nombre del indicador
                            estado,           // Estado con la clase adecuada
                            accion,           // Botón de acción
                        ]);
                    });

                    table.draw();

                }
            });
        });
    </script>    
@endsection