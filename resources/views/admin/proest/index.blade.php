@extends('Layouts.plantilla')

@section('titulo', 'Programación Estratégica')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Programación Estratégica
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarprogramacionmodal" title="nuevo programación">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importarprogramacionmodal" title="cargar programación">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Programación Estratégica</li>
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
                    <table class="display" id="proest" style="width: 100%;">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th class="text-center">No</th>
                                <th class="text-center" width="65%">Indicador</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($proests as $pe)
                                <tr class="text-center" id="proest{{ $pe->id }}">
                                    <td class="text-center">
                                        {{ $i++ }}
                                    </td>
                                    <td class="text-start">
                                        {{ $pe->indproducto->codigo_ip.'. '.$pe->indproducto->nombre_ip }}
                                    </td>
                                    <td class="text-center">
                                        @if ($pe->estado_pe == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $pe->estado_pe }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $pe->estado_pe }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($pe->estado_pe == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $pe->id }}" data-toggle="modal" data-target="#verprogramacionmodal" title="ver programación">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $pe->id }}" data-toggle="modal" data-target="#editarprogramacionmodal" title="modificar programación">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $pe->id }}" title="desactivar programación">
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

    <div class="modal fade" id="agregarprogramacionmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nueva Programación Estratégica</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardarproest') }}" method="POST">
                        @csrf
    
                        <!-- Pestañas de navegación -->
                        <ul class="nav nav-tabs" id="tab-programacion" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-2024" data-toggle="tab" href="#content-2024" role="tab" aria-controls="content-2024" aria-selected="true">2024</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2025" data-toggle="tab" href="#content-2025" role="tab" aria-controls="content-2025" aria-selected="false">2025</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2026" data-toggle="tab" href="#content-2026" role="tab" aria-controls="content-2026" aria-selected="false">2026</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2027" data-toggle="tab" href="#content-2027" role="tab" aria-controls="content-2027" aria-selected="false">2027</a>
                            </li>
                        </ul>
    
                        <!-- Contenido de las pestañas -->
                        <div class="tab-content mt-3" id="tab-content-programacion">
                            <!-- Contenido para 2024 -->
                            <div class="tab-pane fade show active" id="content-2024" role="tabpanel" aria-labelledby="tab-2024">
                                <div class="form-group m-2">
                                    <label for="2024_3">Periodo 2024_3 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2024_3" id="2024_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2024_4">Periodo 2024_4 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2024_4" id="2024_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
    
                            <!-- Contenido para 2025 -->
                            <div class="tab-pane fade" id="content-2025" role="tabpanel" aria-labelledby="tab-2025">
                                <div class="form-group m-2">
                                    <label for="2025_1">Periodo 2025_1 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2025_1" id="2025_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2025_2">Periodo 2025_2 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2025_2" id="2025_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2025_3">Periodo 2025_3 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2025_3" id="2025_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2025_4">Periodo 2025_4 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2025_4" id="2025_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
    
                            <!-- Contenido para 2026 -->
                            <div class="tab-pane fade" id="content-2026" role="tabpanel" aria-labelledby="tab-2026">
                                <div class="form-group m-2">
                                    <label for="2026_1">Periodo 2026_1 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2026_1" id="2026_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2026_2">Periodo 2026_2 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2026_2" id="2026_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2026_3">Periodo 2023_3 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2026_3" id="2026_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2026_4">Periodo 2026_4 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2026_4" id="2026_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <!-- Repite para otros períodos de 2026 -->
                            </div>
    
                            <!-- Contenido para 2027 -->
                            <div class="tab-pane fade" id="content-2027" role="tabpanel" aria-labelledby="tab-2027">
                                <div class="form-group m-2">
                                    <label for="2027_1">Periodo 2027_1 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2027_1" id="2027_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2027_2">Periodo 2027_2 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2027_2" id="2027_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2027_3">Periodo 2027_3 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2027_3" id="2027_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2027_4">Periodo 2027_4 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2027_4" id="2027_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <!-- Repite para otros períodos de 2027 -->
                            </div>
                            <!-- Contenido para tipo de operación -->
                            <div class="tab-pane fade" id="content-operacion" role="tabpanel" aria-labelledby="tab-operacion">
                                <div class="form-group m-2">
                                    <label for="operacion">Tipo de Operación <b class="text-danger"> * </b></label>
                                    <select name="operacion" id="operacion" class="form-control">
                                        <option value="" disabled selected>Seleccionar</option>
                                        <option value="1">Suma</option>
                                        <option value="2">Promedio</option>
                                    </select>
                                </div>
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
    </div>
    

    <div class="modal fade" id="verprogramacionmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos de la Programación Estratégica</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Indicador: </strong><span id="1"></span></p>
                    <ul class="nav nav-tabs" id="tab-programacion" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-2024_consulta" data-toggle="tab" href="#content-2024_consulta" role="tab" aria-controls="content-2024_consulta" aria-selected="true">2024</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2025_consulta" data-toggle="tab" href="#content-2025_consulta" role="tab" aria-controls="content-2025_consulta" aria-selected="false">2025</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2026_consulta" data-toggle="tab" href="#content-2026_consulta" role="tab" aria-controls="content-2026_consulta" aria-selected="false">2026</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2027_consulta" data-toggle="tab" href="#content-2027_consulta" role="tab" aria-controls="content-2027_consulta" aria-selected="false">2027</a>
                        </li>
                    </ul>

                    <!-- Contenido de las pestañas -->
                    <div class="tab-content mt-3" id="tab-content-programacion">
                        <!-- Contenido para 2024 -->
                        <div class="tab-pane fade show active" id="content-2024_consulta" role="tabpanel" aria-labelledby="tab-2024_consulta">
                            <p><strong>Periodo 2024_3: </strong><span id="2"></span></p>
                            <p><strong>Periodo 2024_4: </strong><span id="3"></span></p>
                        </div>

                        <!-- Contenido para 2025 -->
                        <div class="tab-pane fade" id="content-2025_consulta" role="tabpanel" aria-labelledby="tab-2025_consulta">
                            <p><strong>Periodo 2025_1: </strong><span id="4"></span></p>
                            <p><strong>Periodo 2025_2: </strong><span id="5"></span></p>
                            <p><strong>Periodo 2025_3: </strong><span id="6"></span></p>
                            <p><strong>Periodo 2025_4: </strong><span id="7"></span></p>
                        </div>

                        <!-- Contenido para 2026 -->
                        <div class="tab-pane fade" id="content-2026_consulta" role="tabpanel" aria-labelledby="tab-2026_consulta">
                            <p><strong>Periodo 2026_1: </strong><span id="8"></span></p>
                            <p><strong>Periodo 2026_2: </strong><span id="9"></span></p>
                            <p><strong>Periodo 2026_3: </strong><span id="10"></span></p>
                            <p><strong>Periodo 2026_4: </strong><span id="11"></span></p>
                        </div>

                        <!-- Contenido para 2027 -->
                        <div class="tab-pane fade" id="content-2027_consulta" role="tabpanel" aria-labelledby="tab-2027_consulta">
                            <p><strong>Periodo 2027_1: </strong><span id="12"></span></p>
                            <p><strong>Periodo 2027_2: </strong><span id="13"></span></p>
                            <p><strong>Periodo 2027_3: </strong><span id="14"></span></p>
                            <p><strong>Periodo 2027_4: </strong><span id="15"></span></p>
                        </div>
                    </div>
                    <p><strong>Estado: </strong><span id="verestado"></span></p>
                    <p><strong>Registro: </strong><span id="vercreado"></span></p>
                    <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarprogramacionmodal">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos de la Programación Estratégica</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizarproest') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="id_ip" id="id_ip">
                        <!-- Pestañas de navegación -->
                        <ul class="nav nav-tabs" id="tab-programacion" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-2024_editar" data-toggle="tab" href="#content-2024_editar" role="tab" aria-controls="content-2024_editar" aria-selected="true">2024</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2025_editar" data-toggle="tab" href="#content-2025_editar" role="tab" aria-controls="content-2025_editar" aria-selected="false">2025</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2026_editar" data-toggle="tab" href="#content-2026_editar" role="tab" aria-controls="content-2026_editar" aria-selected="false">2026</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2027_editar" data-toggle="tab" href="#content-2027_editar" role="tab" aria-controls="content-2027_editar" aria-selected="false">2027</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-estado" data-toggle="tab" href="#content-estado" role="tab" aria-controls="content-estado" aria-selected="false">Estado</a>
                            </li>
                        </ul>
    
                        <!-- Contenido de las pestañas -->
                        <div class="tab-content mt-3" id="tab-content-programacion">
                            <!-- Contenido para 2024 -->
                            <div class="tab-pane fade show active" id="content-2024_editar" role="tabpanel" aria-labelledby="tab-2024_editar">
                                <div class="form-group m-2">
                                    <label for="2024_3">Periodo 2024_3 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2024_3" id="2024_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2024_4">Periodo 2024_4 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2024_4" id="2024_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
    
                            <!-- Contenido para 2025 -->
                            <div class="tab-pane fade" id="content-2025_editar" role="tabpanel" aria-labelledby="tab-2025_editar">
                                <div class="form-group m-2">
                                    <label for="2025_1">Periodo 2025_1 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2025_1" id="2025_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2025_2">Periodo 2025_2 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2025_2" id="2025_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2025_3">Periodo 2025_3 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2025_3" id="2025_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2025_4">Periodo 2025_4 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2025_4" id="2025_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
    
                            <!-- Contenido para 2026 -->
                            <div class="tab-pane fade" id="content-2026_editar" role="tabpanel" aria-labelledby="tab-2026_editar">
                                <div class="form-group m-2">
                                    <label for="2026_1">Periodo 2026_1 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2026_1" id="2026_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2026_2">Periodo 2026_2 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2026_2" id="2026_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2026_3">Periodo 2026_3 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2026_3" id="2026_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2026_4">Periodo 2026_4 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2026_4" id="2026_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <!-- Repite para otros períodos de 2026 -->
                            </div>
    
                            <!-- Contenido para 2027 -->
                            <div class="tab-pane fade" id="content-2027_editar" role="tabpanel" aria-labelledby="tab-2027_editar">
                                <div class="form-group m-2">
                                    <label for="2027_1">Periodo 2027_1 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2027_1" id="2027_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2027_2">Periodo 2027_2 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2027_2" id="2027_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2027_3">Periodo 2027_3 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2027_3" id="2027_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="2027_4">Periodo 2027_4 <b class="text-danger"> * </b></label>
                                    <input type="text" name="2027_4" id="2027_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <!-- Repite para otros períodos de 2027 -->
                            </div>

                            <div class="tab-pane fade" id="content-estado" role="tabpanel" aria-labelledby="tab-estado">
                                <div class="form-group m-2">
                                    <label for="estado">Estado</label>
                                    <select name="estado" id="estado" class="form-control" style="width: 100%">
                                        <option value="" disabled>Seleccionar</option>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                            </div>
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

    <div class="modal fade" id="importarprogramacionmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Programaciones Estratégicas (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvproests') }}" method="POST" enctype="multipart/form-data">
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
            $('#proest').DataTable({
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
            var ProIdId = $(this).data('id');
            var url = "{{ route('verproest', ['id' => ':id']) }}";
            url = url.replace(':id', ProIdId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    $('#tab-2024_consulta').tab('show');
                    $('#1').text(data.indproducto.codigo_ip + '. ' + data.indproducto.nombre_ip); 
                    $('#2').text(data.p2024_3);
                    $('#3').text(data.p2024_4);
                    $('#4').text(data.p2025_1);
                    $('#5').text(data.p2025_2);
                    $('#6').text(data.p2025_3);
                    $('#7').text(data.p2025_4);
                    $('#8').text(data.p2026_1);
                    $('#9').text(data.p2026_2);
                    $('#10').text(data.p2026_3);
                    $('#11').text(data.p2026_4);
                    $('#12').text(data.p2027_1);
                    $('#13').text(data.p2027_2);
                    $('#14').text(data.p2027_3);
                    $('#15').text(data.p2027_4);
                    $('#verestado').text(data.estado_pe).removeClass().addClass('badge').addClass(data.estado_pe === 'Activo' ? 'bg-success' : 'bg-danger');
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
                    $('#verprogramacionmodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var ProIdId = $(this).data('id');
            var url = "{{ route('editarproest', ['id' => ':id']) }}";
            url = url.replace(':id', ProIdId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#id_ip').val(data.id_ip);
                    $('#2024_3_editar').val(data.p2024_3);
                    $('#2024_4_editar').val(data.p2024_4);
                    $('#2025_1_editar').val(data.p2025_1);
                    $('#2025_2_editar').val(data.p2025_2);
                    $('#2025_3_editar').val(data.p2025_3);
                    $('#2025_4_editar').val(data.p2025_4);
                    $('#2026_1_editar').val(data.p2026_1);
                    $('#2026_2_editar').val(data.p2026_2);
                    $('#2026_3_editar').val(data.p2026_3);
                    $('#2026_4_editar').val(data.p2026_4);
                    $('#2027_1_editar').val(data.p2027_1);
                    $('#2027_2_editar').val(data.p2027_2);
                    $('#2027_3_editar').val(data.p2027_3);
                    $('#2027_4_editar').val(data.p2027_4);
                    $('#estado').val(data.estado_pe);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
        $(document).on('click', '.eliminar', function() {
            var ProId = $(this).data('id');
            var url = "{{ route('eliminarproest', ['id' => ':id']) }}";
            url = url.replace(':id', ProId);
            Swal.fire({
                title: "Esta seguro de desactivar la Programación Estratégica?",
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
                                    text: "La Programación Estratégica ha sido desactivada.",
                                    icon: "success"
                                });
                                $('#proest' + ProId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#proest' + ProId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#proest').DataTable().row('#proest' + ProId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "La Programación Estratégica no ha sido desactivada.",
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