@extends('Layouts.plantilla')

@section('titulo', 'Actividades - Indicador')

@section('contenido')
    <div id="alerta_actividades"></div>
    @if ($faltan == 0)
        <div class="alert alert-success alert-dismissible fade show text-center h4" role="alert">
    @else
        <div class="alert alert-danger alert-dismissible fade show text-center h4" role="alert">
    @endif
        <strong id="control_faltan">De un total de {{ $total }} actividades, Faltan por registrar {{ $faltan }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>Avance de Estratégico
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importaravancemodal" title="cargar avances">
                            <i class="fas fa-cloud-upload"></i>
                        </button>
                        <a href="{{ route('listaravaests') }}" class="btn btn-primary">
                            Volver a Indicadores
                        </a>
                    </h1>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Avence Estratégico del Indicador</li>
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
                                        <th class="text-center">Estrategia de Desarrollo</th>
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
                                <select name="id_anio" id="id_anio_est" class="form-control position-relative" style="top: -25px;" data-live-search="true">
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
                                <select name="id_trimestre" id="id_trimestre_est" class="form-control position-relative" style="top: -25px;" data-live-search="true">
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
                                        <th class="text-center">Periodo</th>
                                        <th class="text-center">% Avance Periodo</th>
                                        <th class="text-center">% Avance Año</th>
                                        <th class="text-center">% Avance Cuatrenio</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($ests as $est)
                                        <tr class="text-center" id="est-row-{{ $est->id }}">
                                            <td class="text-center">
                                                {{ $est->codigo_a }}
                                            </td>
                                            <td class="text-center" width="60%">
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
                                                <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $est->id }}" data-toggle="modal" data-target="#veravancemodal" title="ver avance">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="ver btn btn-sm btn-primary" data-id="{{ $act->id }}" data-toggle="modal" data-target="#veravancemodal" title="ver avance">
                                                    <i class="fas fa-cloud-upload"></i>
                                                </button>
                                                <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $act->id }}" data-toggle="modal" data-target="#editaravancemodal" title="modificar avance">
                                                    <i class="fas fa-cloud-upload"></i>
                                                </button>
                                                <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $act->id }}" title="desactivar avance">
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

        <div class="modal fade" id="agregaravancemodal">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Crear Avance de Actividad</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formularioAvance" action="{{ route('guardaravaact') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id_a" class="form-control" readonly id="id_a">
                            <input type="hidden" name="id_dep" class="form-control" readonly id="id_dep">
                            <div class="form-group m-2">
                                <label for="id_dep">Dependencia Responsable <b class="text-danger"></b></label>
                                <input type="text" name="id_dep" class="form-control" readonly id="dependencia">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="id_ip">Indicador <b class="text-danger"></b></label>
                                        <input type="text" name="id_ip" class="form-control" readonly id="indicador">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="actividad">Actividad <b class="text-danger"></b></label>
                                        <input type="text" name="actividad" class="form-control" readonly id="actividad">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="anio">Año <b class="text-danger"></b></label>
                                        <input type="text" name="anio" class="form-control" readonly id="anio_act">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="trimestre">Trimestre <b class="text-danger"></b></label>
                                        <input type="text" name="trimestre" class="form-control" readonly id="trim_act">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="avance">Avance del Periodo <b class="text-danger"> * </b></label>
                                        <input type="text" name="avance" id="avance1" autofocus class="form-control"
                                            placeholder="Ingrese el avance del periodo" required value="0">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado">Programado del Periodo <b class="text-danger"></b></label>
                                        <input type="text" name="programado" id="programado1" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago1">
                                    <b class="badge"></b>
                                </span>
                                <span id="ver_desempenio">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="form-group m-2">
                                <label for="evidencias" class="btn btn-primary">Seleccionar Evidencias (PDF y/o Imagen):</label>
                                <input 
                                    type="file" 
                                    name="evidencias[]" 
                                    id="evidencias"
                                    class="form-control"
                                    accept="application/pdf, image/*" 
                                    multiple 
                                    style="display: none";
                                >
                            </div>
                            <div>
                                <span class="badge">Nota: Se permite cargar hasta 5 archivos en formato pdf o imágen</span>
                            </div>                            
                            <!--<div id="lista-archivos" style="margin-top: 10px; font-size: 14px; color: #333;">-->
                                <!-- Aquí se mostrarán los nombres de los archivos seleccionados -->
                            <!--</div>-->
                            <table id="tabla-archivos" style="display: none;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-archivos">
                                    <!-- Aquí se agregarán dinámicamente los archivos -->
                                </tbody>
                            </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    
        
    
        <div class="modal fade" id="editaravancemodal">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos del Avance de Actividad</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('actualizaravaact') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="id_a" id="id_a1_editar">
                            <input type="hidden" name="id_ip" id="id_ip1_editar">
                            <input type="hidden" name="id_dep" id="id_dep1_editar">
                            <div class="form-group m-2">
                                <label for="anio">Año <b class="text-danger"> * </b></label>
                                <select name="anio" id="anio1_editar" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                </select>
                            </div>
    
                            <div class="form-group m-2">
                                <label for="trimestre">Trimestre <b class="text-danger"> * </b></label>
                                <select name="trimestre" id="trimestre1_editar" class="form-control">
                                    <option value="" disabled>Seleccionar</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="avance">Avance del Periodo <b class="text-danger"> * </b></label>
                                        <input type="text" name="avance" id="avance1_editar" class="form-control"
                                            placeholder="Ingrese el avance del periodo" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado">Programado del Periodo <b class="text-danger"> * </b></label>
                                        <input type="text" name="programado" id="programado1_editar" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago1_editar">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="form-group m-2">
                                <label for="estado">Estado</label>
                                <select name="estado" id="estado" class="form-control" style="width: 100%">
                                    <option value="" disabled>Seleccionar</option>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>
                            <div class="form-group m-2">
                                <label for="evidencias_editar" class="btn btn-primary">Seleccionar Evidencias (PDF y/o Imagen):</label>
                                <input 
                                    type="file" 
                                    name="evidencias[]" 
                                    id="evidencias_editar"
                                    class="form-control"
                                    accept="application/pdf, image/*" 
                                    multiple 
                                    required
                                    style="display: none";
                                >
                            </div>
                            <div id="lista-archivos-editar" style="margin-top: 10px; font-size: 14px; color: #333;">
                                <!-- Aquí se mostrarán los nombres de los archivos seleccionados -->
                            </div>
                            <div class="form-group m-2">
                                <div class="table-responsive">
                                    <label for="evidencias">Evidencias</label>
                                    <table class="table w-100" id="ips">
                                        <tbody id="verlistaevidencias_editar">
                                            
                                        </tbody>
                                    </table>
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
    
        <div class="modal fade" id="importaravancemodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Cargar Avances Actividades (Archivo CSV)</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('csvavaacts') }}" method="POST" enctype="multipart/form-data">
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

        <div class="modal fade" id="veravancemodal">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Ver Datos del Avance de Actividad</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Actividad: </strong><span id="veractividad"></span></p>
                        <p><strong>Indicador: </strong><span id="verindicador"></span></p>
                        <p><strong>Dependencia: </strong><span id="verdependencia"></span></p>
                        <p><strong>Periodo: </strong><span id="verperiodo"></span></p>
                        <p><strong>Programado: </strong><span id="verprog"></span></p>
                        <p><strong>Avance: </strong><span id="veravance"></span></p>
                        <p><strong>Rezago: </strong><span id="verrezago" class="badge"></span></p>
                        <p><strong>% Año: </strong><span id="verporcanio"></span></p>
                        <p><strong>Desempeño: </strong><span id="verdesempenio" class="badge"></span></p>
                        <p><strong>Evidencias:<span id="verevidencia" class="badge"></span>
                        <p><strong><ul id="verlistaevidencias"></ul></strong></p>
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
        /*document.getElementById('evidencias').addEventListener('change', function(e) {
            const archivos = e.target.files;
            for (let i = 0; i < archivos.length; i++) {
                if ((archivos[i].type !== 'application/pdf') && (archivos[i].type !== 'image/jpg') && (archivos[i].type !== 'image/jpeg') && (archivos[i].type !== 'image/png')) {
                    alert('Solo se permiten archivos PDF - JPG - JPEG - PNG.');
                    e.target.value = ''; // Limpiar selección
                    break;
                }
            }
        });
        document.getElementById('evidencias').addEventListener('change', function(e) {
            const listaArchivos = document.getElementById('lista-archivos');
            listaArchivos.innerHTML = ''; // Limpiar la lista de archivos previa

            const archivos = e.target.files; // Obtener los archivos seleccionados
            if (archivos.length > 0) {
                for (let i = 0; i < archivos.length; i++) {
                    const archivo = archivos[i];
                    const nombreArchivo = document.createElement('div');
                    nombreArchivo.textContent = `Archivo ${i + 1}: ${archivo.name}`;
                    listaArchivos.appendChild(nombreArchivo);
                }
            } else {
                listaArchivos.textContent = 'No se han seleccionado archivos.';
            }
        });*/
        /*document.addEventListener('DOMContentLoaded', function () {
            const inputEvidencias = document.getElementById('evidencias');
            const listaArchivos = document.getElementById('lista-archivos');
            const maxArchivos = 5;
            let archivosSeleccionados = [];

            function actualizarListaArchivos() {
                listaArchivos.innerHTML = ''; // Limpiar la lista de archivos
                archivosSeleccionados.forEach((archivo, index) => {
                    const itemArchivo = document.createElement('div');
                    itemArchivo.innerHTML = `Archivo ${index + 1}: ${archivo.name} 
                        <button class="btn btn-danger btn-sm ml-2 eliminar-archivo" data-index="${index}">X</button>`;
                    listaArchivos.appendChild(itemArchivo);
                });

                // Deshabilitar el input si llega al máximo
                inputEvidencias.disabled = archivosSeleccionados.length >= maxArchivos;
            }

            inputEvidencias.addEventListener('change', function (e) {
                const nuevosArchivos = Array.from(e.target.files);

                if (archivosSeleccionados.length + nuevosArchivos.length > maxArchivos) {
                    alert(`Solo puedes agregar hasta ${maxArchivos} archivos.`);
                    e.target.value = ''; // Limpiar selección
                    return;
                }

                nuevosArchivos.forEach((archivo) => {
                    const tipoArchivo = archivo.type;
                    if (['application/pdf', 'image/jpg', 'image/jpeg', 'image/png'].includes(tipoArchivo)) {
                        archivosSeleccionados.push(archivo);
                    } else {
                        alert('Solo se permiten archivos PDF - JPG - JPEG - PNG.');
                    }
                });

                e.target.value = ''; // Limpiar el input para poder volver a seleccionar archivos
                actualizarListaArchivos();
            });

            listaArchivos.addEventListener('click', function (e) {
                if (e.target.classList.contains('eliminar-archivo')) {
                    const index = e.target.getAttribute('data-index');
                    archivosSeleccionados.splice(index, 1);
                    actualizarListaArchivos();
                }
            });
        });*/
        /*document.addEventListener('DOMContentLoaded', function () {
            const inputEvidencias = document.getElementById('evidencias');
            const labelEvidencias = document.querySelector("label[for='evidencias']"); // Label del botón "Seleccionar Evidencias"
            const listaArchivos = document.getElementById('lista-archivos');
            const maxArchivos = 5;
            let archivosSeleccionados = [];

            function actualizarListaArchivos() {
                listaArchivos.innerHTML = ''; // Limpiar la lista de archivos
                archivosSeleccionados.forEach((archivo, index) => {
                    const itemArchivo = document.createElement('div');
                    itemArchivo.innerHTML = `Archivo ${index + 1}: ${archivo.name} 
                        <button class="btn btn-danger btn-sm ml-2 eliminar-archivo" data-index="${index}">X</button>`;
                    listaArchivos.appendChild(itemArchivo);
                });

                // Ocultar el botón si llega al máximo de archivos
                if (archivosSeleccionados.length >= maxArchivos) {
                    inputEvidencias.style.display = 'none'; // Ocultar pero mantener espacio
                    labelEvidencias.style.display = 'none';
                } else {
                    inputEvidencias.style.display = 'block';
                    labelEvidencias.style.display = 'inline-block';
                }
            }

            inputEvidencias.addEventListener('change', function (e) {
                const nuevosArchivos = Array.from(e.target.files);

                if (archivosSeleccionados.length + nuevosArchivos.length > maxArchivos) {
                    alert(`Solo puedes agregar hasta ${maxArchivos} archivos.`);
                    e.target.value = ''; // Limpiar selección
                    return;
                }

                nuevosArchivos.forEach((archivo) => {
                    const tipoArchivo = archivo.type;
                    if (['application/pdf', 'image/jpg', 'image/jpeg', 'image/png'].includes(tipoArchivo)) {
                        archivosSeleccionados.push(archivo);
                    } else {
                        alert('Solo se permiten archivos PDF - JPG - JPEG - PNG.');
                    }
                });

                e.target.value = ''; // Limpiar el input para permitir nuevas selecciones
                actualizarListaArchivos();
            });

            listaArchivos.addEventListener('click', function (e) {
                if (e.target.classList.contains('eliminar-archivo')) {
                    const index = e.target.getAttribute('data-index');
                    archivosSeleccionados.splice(index, 1);
                    actualizarListaArchivos();
                }
            });
        });*/
        /*document.addEventListener('DOMContentLoaded', function () {
            const inputEvidencias = document.getElementById('evidencias');
            const labelEvidencias = document.querySelector("label[for='evidencias']"); // Botón "Seleccionar Evidencias"
            const listaArchivos = document.getElementById('lista-archivos');
            const maxArchivos = 5;
            let archivosSeleccionados = [];

            function actualizarListaArchivos() {
                listaArchivos.innerHTML = ''; // Limpiar la lista de archivos

                archivosSeleccionados.forEach((archivo, index) => {
                    const itemArchivo = document.createElement('div');
                    itemArchivo.innerHTML = `Archivo ${index + 1}: ${archivo.name} 
                        <button class="btn btn-danger btn-sm ml-2 eliminar-archivo" data-index="${index}">X</button>`;
                    listaArchivos.appendChild(itemArchivo);
                });

                // Ocultar completamente el botón cuando haya 5 archivos
                if (archivosSeleccionados.length >= maxArchivos) {
                    labelEvidencias.style.display = 'none'; // Ocultar botón de selección
                } else {
                    labelEvidencias.style.display = 'inline-block'; // Mostrar botón
                }
            }

            inputEvidencias.addEventListener('change', function (e) {
                const nuevosArchivos = Array.from(e.target.files);

                if (archivosSeleccionados.length + nuevosArchivos.length > maxArchivos) {
                    alert(`Solo puedes agregar hasta ${maxArchivos} archivos.`);
                    e.target.value = ''; // Limpiar selección
                    return;
                }

                nuevosArchivos.forEach((archivo) => {
                    const tipoArchivo = archivo.type;
                    if (['application/pdf', 'image/jpg', 'image/jpeg', 'image/png'].includes(tipoArchivo)) {
                        archivosSeleccionados.push(archivo);
                    } else {
                        alert('Solo se permiten archivos PDF - JPG - JPEG - PNG.');
                    }
                });

                e.target.value = ''; // Limpiar input para evitar acumulación de archivos en el mismo evento
                actualizarListaArchivos();
            });

            listaArchivos.addEventListener('click', function (e) {
                if (e.target.classList.contains('eliminar-archivo')) {
                    const index = e.target.getAttribute('data-index');
                    archivosSeleccionados.splice(index, 1);
                    actualizarListaArchivos();
                }
            });
        });*/

        /*document.addEventListener('DOMContentLoaded', function () {
            const inputEvidencias = document.getElementById('evidencias');
            const labelEvidencias = document.querySelector("label[for='evidencias']"); // Botón "Seleccionar Evidencias"
            const listaArchivos = document.getElementById('lista-archivos');
            const maxArchivos = 5;
            let archivosSeleccionados = [];

            function actualizarListaArchivos() {
                listaArchivos.innerHTML = ''; // Limpiar la lista de archivos

                archivosSeleccionados.forEach((archivo, index) => {
                    const itemArchivo = document.createElement('div');
                    itemArchivo.innerHTML = `Archivo ${index + 1}: ${archivo.name} 
                        <button class="btn btn-danger btn-sm ml-2 eliminar-archivo" data-index="${index}">X</button>`;
                    listaArchivos.appendChild(itemArchivo);
                });

                // Ocultar completamente el botón cuando haya 5 archivos
                labelEvidencias.style.display = archivosSeleccionados.length >= maxArchivos ? 'none' : 'inline-block';
            }

            inputEvidencias.addEventListener('change', function (e) {
                const nuevosArchivos = Array.from(e.target.files);

                if (archivosSeleccionados.length + nuevosArchivos.length > maxArchivos) {
                    alert(`Solo puedes agregar hasta ${maxArchivos} archivos.`);
                    e.target.value = ''; // Limpiar selección
                    return;
                }

                nuevosArchivos.forEach((archivo) => {
                    const tipoArchivo = archivo.type;
                    if (['application/pdf', 'image/jpg', 'image/jpeg', 'image/png'].includes(tipoArchivo)) {
                        archivosSeleccionados.push(archivo);
                    } else {
                        alert('Solo se permiten archivos PDF - JPG - JPEG - PNG.');
                    }
                });

                e.target.value = ''; // Limpiar input para permitir nuevas selecciones
                actualizarListaArchivos();
            });

            listaArchivos.addEventListener('click', function (e) {
                if (e.target.classList.contains('eliminar-archivo')) {
                    const index = e.target.getAttribute('data-index');
                    archivosSeleccionados.splice(index, 1);
                    actualizarListaArchivos();
                }
            });

            // 🔹 Evento para limpiar el modal cuando se cierra 🔹
            $('#agregaravancemodal').on('hidden.bs.modal', function () {
                archivosSeleccionados = []; // Vaciar la lista de archivos
                inputEvidencias.value = ''; // Resetear el input file
                listaArchivos.innerHTML = ''; // Limpiar la lista de archivos
                labelEvidencias.style.display = 'inline-block'; // Volver a mostrar el botón

                // Limpiar todos los inputs dentro del modal
                $(this).find('input[type="text"], input[type="hidden"]').val('');
            });
        });*/

        /*document.addEventListener('DOMContentLoaded', function () {
            const inputEvidencias = document.getElementById('evidencias');
            const labelEvidencias = document.querySelector("label[for='evidencias']"); // Botón "Seleccionar Evidencias"
            const tablaArchivos = document.getElementById('tabla-archivos'); // Contenedor de la tabla
            const tbodyArchivos = document.getElementById('tbody-archivos'); // Cuerpo de la tabla
            const maxArchivos = 5;
            let archivosSeleccionados = [];

            function obtenerIcono(tipo) {
                if (tipo === 'application/pdf') {
                    return '<i class="fas fa-file-pdf text-danger h3"></i>'; // Ícono rojo para PDF
                } else if (['image/jpg', 'image/jpeg', 'image/png'].includes(tipo)) {
                    return '<i class="fas fa-file-image text-primary h3"></i>'; // Ícono azul para imágenes
                }
                //return '<i class="fas fa-file text-secondary"></i>'; // Ícono genérico
            }

            function actualizarListaArchivos() {
                tbodyArchivos.innerHTML = ''; // Limpiar la tabla

                archivosSeleccionados.forEach((archivo, index) => {
                    const fila = document.createElement('tr');

                    fila.innerHTML = `
                        <td class="text-center">${index + 1}</td>
                        <td>${archivo.name}</td>
                        <td class="text-center">${obtenerIcono(archivo.type)}</td>
                        <td class="text-center"><button class="btn btn-danger btn-sm eliminar-archivo" data-index="${index}"><i class="fas fa-trash-alt"></i></button></td>
                    `;
                    tbodyArchivos.appendChild(fila);
                });

                // Ocultar el botón si se alcanzan 5 archivos, mostrarlo si se elimina alguno
                labelEvidencias.style.display = archivosSeleccionados.length >= maxArchivos ? 'none' : 'inline-block';

                // Mostrar u ocultar la tabla dependiendo de si hay archivos
                tablaArchivos.style.display = archivosSeleccionados.length > 0 ? 'table' : 'none';
            }

            inputEvidencias.addEventListener('change', function (e) {
                const nuevosArchivos = Array.from(e.target.files);

                if (archivosSeleccionados.length + nuevosArchivos.length > maxArchivos) {
                    alert(`Solo puedes agregar hasta ${maxArchivos} archivos.`);
                    e.target.value = ''; // Limpiar selección
                    return;
                }

                nuevosArchivos.forEach((archivo) => {
                    const tipoArchivo = archivo.type;
                    if (['application/pdf', 'image/jpg', 'image/jpeg', 'image/png'].includes(tipoArchivo)) {
                        archivosSeleccionados.push(archivo);
                    } else {
                        alert('Solo se permiten archivos PDF - JPG - JPEG - PNG.');
                    }
                });

                e.target.value = ''; // Limpiar input para permitir nuevas selecciones
                actualizarListaArchivos();
            });

            tbodyArchivos.addEventListener('click', function (e) {
                if (e.target.closest('.eliminar-archivo')) {
                    const index = e.target.closest('.eliminar-archivo').getAttribute('data-index');
                    archivosSeleccionados.splice(index, 1);
                    actualizarListaArchivos();
                }
            });

            // 🔹 Evento para limpiar el modal cuando se cierra 🔹
            $('#agregaravancemodal').on('hidden.bs.modal', function () {
                archivosSeleccionados = []; // Vaciar la lista de archivos
                inputEvidencias.value = ''; // Resetear el input file
                tbodyArchivos.innerHTML = ''; // Limpiar la tabla
                labelEvidencias.style.display = 'inline-block'; // Volver a mostrar el botón
                tablaArchivos.style.display = 'none'; // Ocultar la tabla si está vacía

                // Limpiar todos los inputs dentro del modal
                $(this).find('input[type="text"], input[type="hidden"]').val('');
            });
        });*/        

        document.addEventListener('DOMContentLoaded', function () {
            const inputEvidencias = document.getElementById('evidencias');
            const labelEvidencias = document.querySelector("label[for='evidencias']");
            const tablaArchivos = document.getElementById('tabla-archivos');
            const tbodyArchivos = document.getElementById('tbody-archivos');
            const formulario = document.querySelector("form[action*='guardaravaact']");
            const maxArchivos = 5;
            let archivosSeleccionados = [];

            function obtenerIcono(tipo) {
                if (tipo === 'application/pdf') {
                    return '<i class="fas fa-file-pdf text-danger h3"></i>';
                } else if (['image/jpg', 'image/jpeg', 'image/png'].includes(tipo)) {
                    return '<i class="fas fa-file-image text-primary h3"></i>';
                }
            }

            function actualizarListaArchivos() {
                tbodyArchivos.innerHTML = ''; 

                archivosSeleccionados.forEach((archivo, index) => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td class="text-center">${index + 1}</td>
                        <td>${archivo.name}</td>
                        <td class="text-center">${obtenerIcono(archivo.type)}</td>
                        <td class="text-center"><button class="btn btn-danger btn-sm eliminar-archivo" data-index="${index}"><i class="fas fa-trash-alt"></i></button></td>
                    `;
                    tbodyArchivos.appendChild(fila);
                });

                labelEvidencias.style.display = archivosSeleccionados.length >= maxArchivos ? 'none' : 'inline-block';
                tablaArchivos.style.display = archivosSeleccionados.length > 0 ? 'table' : 'none';
            }

            inputEvidencias.addEventListener('change', function (e) {
                const nuevosArchivos = Array.from(e.target.files);

                if (archivosSeleccionados.length + nuevosArchivos.length > maxArchivos) {
                    alert(`Solo puedes agregar hasta ${maxArchivos} archivos.`);
                    e.target.value = ''; 
                    return;
                }

                nuevosArchivos.forEach((archivo) => {
                    const tipoArchivo = archivo.type;
                    if (['application/pdf', 'image/jpg', 'image/jpeg', 'image/png'].includes(tipoArchivo)) {
                        archivosSeleccionados.push(archivo);
                    } else {
                        alert('Solo se permiten archivos PDF - JPG - JPEG - PNG.');
                    }
                });

                e.target.value = ''; 
                actualizarListaArchivos();
            });

            tbodyArchivos.addEventListener('click', function (e) {
                if (e.target.closest('.eliminar-archivo')) {
                    const index = e.target.closest('.eliminar-archivo').getAttribute('data-index');
                    archivosSeleccionados.splice(index, 1);
                    actualizarListaArchivos();
                }
            });

            // 🔹 Evento para limpiar el modal cuando se cierra 🔹
            $('#agregaravancemodal').on('hidden.bs.modal', function () {
                archivosSeleccionados = []; 
                inputEvidencias.value = ''; 
                tbodyArchivos.innerHTML = ''; 
                labelEvidencias.style.display = 'inline-block';
                tablaArchivos.style.display = 'none'; 

                $(this).find('input[type="text"], input[type="hidden"]').val('');
            });

            document.getElementById('evidencias').addEventListener('change', function() {
                let files = this.files;
                if (files.length === 0) {
                    console.log("No hay archivos seleccionados.");
                } else {
                    console.log("Archivos seleccionados:", files);
                }
            });

            $('#formularioAvance').submit(function(event) {
                event.preventDefault(); // Evita el envío tradicional del formulario

                let formData = new FormData(this); // Capturar los datos del formulario

                // Asegurarnos de que se están agregando los archivos seleccionados
                if (archivosSeleccionados.length === 0) {
                    alert("No se ha seleccionado ningún archivo.");
                    return;
                }

                archivosSeleccionados.forEach((archivo, index) => {
                    formData.append('evidencias[]', archivo);
                });

                // Para depuración: Mostrar los archivos en un alert antes de enviar
                let fileNames = archivosSeleccionados.map(file => file.name);
                alert("Archivos seleccionados:\n" + fileNames.join("\n"));

                $.ajax({
                    url: $("#formularioAvance").attr("action"),
                    type: "POST",
                    data: formData,  // Asegurarse de enviar `formData`
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Guardar mensaje en localStorage
                            localStorage.setItem("toastr_message", response.message);
                            console.log('Respuesta:', response);
                            // Redirigir a la URL proporcionada
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(xhr) {
                        toastr.error("Hubo un error al guardar el avance.");
                    }
                });
            });
        });

        document.getElementById('evidencias_editar').addEventListener('change', function(e) {
            const archivos = e.target.files;
            for (let i = 0; i < archivos.length; i++) {
                if ((archivos[i].type !== 'application/pdf') && (archivos[i].type !== 'image/jpg') && (archivos[i].type !== 'image/jpeg') && (archivos[i].type !== 'image/png')) {
                    alert('Solo se permiten archivos PDF - JPG - JPEG - PNG.');
                    e.target.value = ''; // Limpiar selección
                    break;
                }
            }
        });
        document.getElementById('evidencias_editar').addEventListener('change', function(e) {
            const listaArchivos = document.getElementById('lista-archivos-editar');
            listaArchivos.innerHTML = ''; // Limpiar la lista de archivos previa

            const archivos = e.target.files; // Obtener los archivos seleccionados
            if (archivos.length > 0) {
                for (let i = 0; i < archivos.length; i++) {
                    const archivo = archivos[i];
                    const nombreArchivo = document.createElement('div');
                    nombreArchivo.textContent = `Archivo ${i + 1}: ${archivo.name}`;
                    listaArchivos.appendChild(nombreArchivo);
                }
            } else {
                listaArchivos.textContent = 'No se han seleccionado archivos.';
            }
        });
        // Muestra el selector de archivos al hacer clic en el botón
        document.getElementById('customFileBtn').addEventListener('click', function () {
            document.getElementById('archivo_csv').click(); // Simula el clic en el input de archivo oculto
        });

        // Muestra el nombre del archivo seleccionado
        document.getElementById('archivo_csv').addEventListener('change', function () {
            const fileName = this.files[0] ? this.files[0].name : 'No se ha seleccionado ningún archivo';
            document.getElementById('fileName').textContent = fileName;
        });
        document.getElementById('avance1').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('avance1_editar').addEventListener('input', function (e) {
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
            $('#tabla-archivos').DataTable({
                paging: false, // Activar paginación
                searching: false, // Activar barra de búsqueda
                ordering: false, // Activar ordenación de columnas
                pagingType: 'full_numbers', // Pagina completa: << < 1 2 3 > >>
                info: false,
                language: {
                    url: "/plugins/datatables/idioma.json", // Traducción al español
                },
                columnDefs: [
                    { className: "text-center", orderable: false, targets: "_all" } // Desactivar ordenación en la columna de acciones
                ]
            });
            // Verificar si hay un mensaje almacenado en localStorage
            let message = localStorage.getItem("toastr_message");
            if (message) {
                toastr.success(message);
                // Eliminar el mensaje para que no se vuelva a mostrar
                localStorage.removeItem("toastr_message");
            }
        });

        $('#id_dep1').on('change', function () {
            var id_dep = $(this).val();
            var url = "{{ route('ind_dep1', ['id' => ':id']) }}".replace(':id', id_dep);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var indSelect = $('#id_ip1');
                    indSelect.empty();
                    indSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Indicador) {
                        indSelect.append('<option value="' + Indicador.id + '">' + Indicador.codigo_ip + '</option>');
                    });
                    indSelect.trigger('change');
                }
            });
        });
        $('#id_ip1').on('change', function () {
            var id_ip = $(this).val();
            var url = "{{ route('ind_act', ['id' => ':id']) }}".replace(':id', id_ip);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    var actSelect = $('#id_a1');
                    actSelect.empty();
                    actSelect.append('<option value="" disabled selected>Seleccionar</option>');
                    data.forEach(function(Actividad) {
                        actSelect.append('<option value="' + Actividad.id + '">' + Actividad.codigo_a + '. ' + Actividad.nombre_a + '</option>');
                    });
                    actSelect.trigger('change');
                }
            });
        });
        $('#trimestre1').on('input', function () {
            const id_a = document.getElementById('id_a1').value;
            const avance = document.getElementById('avance1').value;
            const anio = document.getElementById('anio1').value;
            const trimestre = document.getElementById('trimestre1').value;
            const id_dep = document.getElementById('id_dep1').value;
            const badge = $('#ver_rezago1 .badge');
            var datos = id_a + "_" + avance + "_" + anio + "_" + trimestre + "_" + id_dep + "_" + 0;
            var url = "{{ route('rezago1', ['id' => ':id']) }}".replace(':id', datos);
            console.log(datos);
            if (avance === '' || avance === 0) {
                badge.text('').removeClass().addClass('badge');
            }
            else {
                $.ajax({
                    url: url,
                    type: 'get',
                    success: function(data) {
                        console.log(data);
                        badge.text('').removeClass().addClass('badge');
                        // Verifica si el periodo ya fue programado
                        if (typeof data === 'string') {
                            // El mensaje del servidor indica que el periodo ya fue programado
                            badge.text(data).removeClass().addClass('badge badge-info');
                            const prog = $('#programado1');
                            prog.val(data.valor_programado);
                        }
                        else if (Array.isArray(data)) {
                            // Procesar datos del periodo
                            data.forEach(function(datos) {
                                const prog = $('#programado1');
                                var programado = datos.valor_programado.replace(',', '.');
                                prog.val(programado);
                                if (datos.valor_programado == 0)
                                    badge.text('No programado').removeClass().addClass('badge badge-danger');
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
        $('#trimestre1_editar').on('input', function () {
            const id_ip = document.getElementById('id_ip1_editar').value;
            const avance = document.getElementById('avance1_editar').value;
            const anio = document.getElementById('anio1_editar').value;
            const trimestre = document.getElementById('trimestre1_editar').value;
            const id_dep = document.getElementById('id_dep1_editar').value;
            const badge = $('#ver_rezago1_editar .badge');
            var datos = id_a + "_" + avance + "_" + anio + "_" + trimestre + "_" + id_dep + "_" + 1;
            var url = "{{ route('rezago1', ['id' => ':id']) }}".replace(':id', datos);
            if (avance === '' || avance === 0) {
                badge.text('').removeClass().addClass('badge');
            }
            else {
                $.ajax({
                    url: url,
                    type: 'get',
                    success: function(data) {
                        badge.text('').removeClass().addClass('badge');
                        // Verifica si el periodo ya fue programado
                        if (typeof data === 'string') {
                            // El mensaje del servidor indica que el periodo ya fue programado
                            badge.text(data).removeClass().addClass('badge badge-info');
                            const prog = $('#programado1_editar');
                            prog.val('');
                        }
                        else if (Array.isArray(data)) {
                            // Procesar datos del periodo
                            data.forEach(function(datos) {
                                const prog = $('#programado1_editar');
                                var programado = datos.valor_programado.replace(',', '.');
                                prog.val(programado);
                                if (datos.valor_programado == 0)
                                    badge.text('No programado').removeClass().addClass('badge badge-danger');
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
        /*$('#avance1').on('input', function () {
            const id_a = document.getElementById('id_a').value;
            const avance = document.getElementById('avance1').value;
            const anio = document.getElementById('anio_act').value;
            const trimestre = document.getElementById('trim_act').value;
            const id_dep = document.getElementById('id_dep').value;
            var datos = id_a + "_" + avance + "_" + anio + "_" + trimestre + "_" + id_dep + "_" + 0;
            var rezago = 0;
            var mensaje = 0;
            const badge = $('#ver_rezago1 .badge');
            //const badge2 = $('#ver_desempenio .badge');
            var url = "{{ route('rezago1', ['id' => ':id']) }}".replace(':id', datos);
            if (avance === '' || avance === 0) {
                badge.text('').removeClass().addClass('badge');
            }
            else {
                $.ajax({
                    url: url,
                    type: 'get',
                    success: function(data) {
                        // Verifica si el periodo ya fue programado
                        if (typeof data === 'string') {
                            // El mensaje del servidor indica que el periodo ya fue programado
                            badge.text(data).removeClass().addClass('badge badge-info');
                        }
                        else if (Array.isArray(data)) {
                            // Procesar datos del periodo
                            data.forEach(function(datos) {
                                var programado = parseFloat(datos.valor_programado.replace(',', '.'));
                                if (programado > 0) {
                                    rezago = parseFloat(avance) / programado;
                                    if (rezago === 1) {
                                        badge.text('Ha cumplido').removeClass().addClass('badge badge-success');
                                    }
                                    else {
                                        if (rezago > 1) {
                                            badge.text('Rezago Superior del ' + (rezago * 100 - 100).toFixed(2) + '%').removeClass().addClass('badge badge-warning');
                                        }
                                        else {
                                            badge.text('Rezago Inferior del ' + (100 - (rezago * 100)).toFixed(2) + '%').removeClass().addClass('badge badge-danger');
                                        }
                                    }
                                }
                                else {
                                    badge.text('No programado').removeClass().addClass('badge badge-danger');;
                                }
                                
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
        });*/
        $('#avance1').on('input', function () {
            const id_a = document.getElementById('id_a').value;
            const avance = document.getElementById('avance1').value;
            const anio = document.getElementById('anio_act').value;
            const trimestre = document.getElementById('trim_act').value;
            const id_dep = document.getElementById('id_dep').value;

            const datos = `${id_a}_${avance}_${anio}_${trimestre}_${id_dep}_0`;
            const badgeRezago = $('#ver_rezago1 .badge');
            const badgeDesempeno = $('#ver_desempenio .badge'); // Nuevo badge

            // Generar la URL correctamente
            const url = `{{ route('rezago1', ['id' => '__ID__']) }}`.replace('__ID__', datos);

            if (avance === '' || parseFloat(avance) === 0) {  
                badgeRezago.text('').removeClass().addClass('badge');
                badgeDesempeno.text('').removeClass().addClass('badge');
                return;
            }

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    if (typeof data === 'string') {
                        // Si el periodo ya fue programado
                        badgeRezago.text(data).removeClass().addClass('badge badge-info');
                        badgeDesempeno.text('').removeClass().addClass('badge');
                    } else if (Array.isArray(data)) {
                        data.forEach(function(datos) {
                            const programado = datos.valor_programado ? parseFloat(datos.valor_programado.replace(',', '.')) : 0;
                            
                            if (programado > 0) {
                                let rezago = (parseFloat(avance) / programado) * 100; // Convertir a porcentaje
                                let desempenoTexto = "";
                                let desempenoClase = "badge"; // Clase base

                                // Determinar desempeño según porcentaje de rezago
                                if (rezago >= 0 && rezago < 40) {
                                    desempenoTexto = "CRÍTICO";
                                    desempenoClase += " badge-danger";
                                } else if (rezago >= 40 && rezago <= 60) {
                                    desempenoTexto = "BAJO";
                                    desempenoClase += " badge-warning";
                                } else if (rezago > 60 && rezago <= 70) {
                                    desempenoTexto = "MEDIO";
                                    desempenoClase += " badge-primary";
                                } else if (rezago > 70 && rezago <= 80) {
                                    desempenoTexto = "SATISFACTORIO";
                                    desempenoClase += " badge-info";
                                } else if (rezago > 80 && rezago <= 100) {
                                    desempenoTexto = "SOBRESALIENTE";
                                    desempenoClase += " badge-success";
                                } else if (rezago > 100) {
                                    desempenoTexto = "SOBRE EJECUCIÓN";
                                    desempenoClase += " badge-dark";
                                }

                                // Actualizar el badge de desempeño
                                badgeDesempeno.text(`Desempeño: ${desempenoTexto}`).removeClass().addClass(desempenoClase);

                                // Actualizar el badge de rezago
                                if (rezago === 100) {
                                    badgeRezago.text('Ha cumplido').removeClass().addClass('badge badge-success');
                                } else if (rezago > 100) {
                                    badgeRezago.text(`Rezago Superior del ${(rezago - 100).toFixed(2)}%`).removeClass().addClass('badge badge-warning');
                                } else {
                                    badgeRezago.text(`Rezago Inferior del ${(100 - rezago).toFixed(2)}%`).removeClass().addClass('badge badge-danger');
                                }
                            } else {
                                badgeRezago.text('No programado').removeClass().addClass('badge badge-danger');
                                badgeDesempeno.text('').removeClass().addClass('badge');
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', status, error);
                }
            });
        });
        $('#avance1_editar').on('input', function () {
            const id_a = document.getElementById('id_a1_editar').value;
            const avance = document.getElementById('avance1_editar').value;
            const anio = document.getElementById('anio1_editar').value;
            const trimestre = document.getElementById('trimestre1_editar').value;
            const id_dep = document.getElementById('id_dep1_editar').value;
            var datos = id_a + "_" + avance + "_" + anio + "_" + trimestre + "_" + id_dep + "_" + 1;
            console.log(datos);
            var rezago = 0;
            var mensaje = 0;
            const badge = $('#ver_rezago1_editar .badge');
            var url = "{{ route('rezago1', ['id' => ':id']) }}".replace(':id', datos);
            if (avance === '' || avance === 0) {
                badge.text('').removeClass().addClass('badge');
            }
            else {
                $.ajax({
                    url: url,
                    type: 'get',
                    success: function(data) {
                        console.log(data);
                        // Verifica si el periodo ya fue programado
                        if (typeof data === 'string') {
                            // El mensaje del servidor indica que el periodo ya fue programado
                            badge.text(data).removeClass().addClass('badge badge-info');
                        }
                        else if (Array.isArray(data)) {
                            // Procesar datos del periodo
                            data.forEach(function(datos) {
                                var programado = parseFloat(datos.valor_programado.replace(',', '.'));
                                if (programado > 0) {
                                    rezago = parseFloat(avance.replace(',', '.')) / programado;
                                    if (rezago === 1) {
                                        badge.text('Ha cumplido').removeClass().addClass('badge badge-success');
                                    }
                                    else {
                                        if (rezago > 1) {
                                            badge.text('Rezago Superior del ' + (rezago * 100 - 100).toFixed(2) + '%').removeClass().addClass('badge badge-warning');
                                        }
                                        else {
                                            badge.text('Rezago Inferior del ' + (100 - (rezago * 100)).toFixed(2) + '%').removeClass().addClass('badge badge-danger');
                                        }
                                    }
                                }
                                else {
                                    badge.text('No programado').removeClass().addClass('badge badge-danger');;
                                }   
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
        
        $(document).on('click', '.editar', function() {
            var AvanceId = $(this).data('id');
            var url = "{{ route('editaravaact', ['id' => ':id']) }}";
            url = url.replace(':id', AvanceId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    $('#id').val(data[0].id);
                    $('#id_ip1_editar').val(data[0].id_ip);
                    $('#id_dep1_editar').val(data[0].id_d);
                    var avance = parseFloat(data[0].avance_aa.replace(',', '.'));
                    $('#avance1_editar').val(avance);
                    var aporte = parseFloat(data[0].aporte_a.replace(',', '.'));
                    $('#programado1_editar').val(aporte);
                    $('#id_a1_editar').val(data[0].id_a);
                    $('#anio1_editar').val(data[0].anio).trigger('change');
                    $('#trimestre1_editar').val(data[0].trimestre).trigger('change');
                    $('#estado').val(data[0].estado);
                    // Asegúrate de que el campo 'evidencias' existe y no es null
                    if (data[0].evidencias) {
                        // Seleccionamos el contenedor donde queremos agregar los elementos
                        const listaEvidencias = document.getElementById('verlistaevidencias_editar'); // Asegúrate de tener un elemento con id 'lista-evidencias'
                        // Limpiar cualquier contenido previo
                        listaEvidencias.innerHTML = '';
                        const evidencias = data[0].evidencias.split('|'); // Convertir a array
                        evidencias.forEach(function(e,index) {
                            // Recorrer las evidencias y agregar un <li> por cada una
                            const [id, evidencia] = e.split(','); // Dividir por coma para obtener id y evidencia
                            const tr = document.createElement('tr');
                            const td1 = document.createElement('td');
                            const td2 = document.createElement('td');
                            const a = document.createElement('a');
                            const button = document.createElement('button');
                            const icon = document.createElement('i');
                            tr.id = `evi-row-${id}`;
                            // Crear un texto para "Evidencia "
                            const textoEvidencia = document.createTextNode('Evidencia ' + (index + 1) + ': ');

                            // Crear el enlace
                            const evid = e.split('evidencias/')
                            // Crear el enlace con la URL de la evidencia
                            a.href = '../../storage/evidencias/' + evidencia;
                            a.target = '_blank';
                            a.textContent = evid[1];
                            //a.textContent = 'Ver Evidencia ' + (index + 1);
                            // Agregar el enlace y el texto al <td>
                            td1.appendChild(textoEvidencia);
                            td1.appendChild(a);
                            // Agregar el <td1> al <tr>
                            tr.appendChild(td1);
                            // Configurar el botón
                            button.type = 'button';
                            button.className = 'eliminar_evidencia btn btn-sm btn-danger';
                            button.setAttribute('data-id', id);
                            button.setAttribute('title', 'Eliminar Evidencia');
                            // Agregar ícono al botón
                            icon.className = 'fas fa-user-minus';
                            button.appendChild(icon);
                            // Agregar el botón a la celda
                            td2.appendChild(button);
                            // Agregar el <td2> al <tr>
                            tr.appendChild(td2);
                            // Agregar el <li> a la lista
                            listaEvidencias.appendChild(tr);    
                        });
                    } else {
                        console.log('No hay evidencias para esta actividad.');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });
        $(document).on('click', '.eliminar', function() {
            var AvanceId = $(this).data('id');
            var url = "{{ route('eliminaravaact', ['id' => ':id']) }}";
            url = url.replace(':id', AvanceId);
            Swal.fire({
                title: "Esta seguro de desactivar el Avance de la Actividad?",
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
                                    text: "El Avance de la Actividad ha sido desactivado.",
                                    icon: "success"
                                });
                                $('#ava-row-' + AvanceId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#ava-row-' + AvanceId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#avances').DataTable().row('#ava-row-' + AvanceId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "El Avance de la Actividad no ha sido desactivado.",
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

        $(document).on('click', '.eliminar_evidencia', function() {
            var EvidId = $(this).data('id');
            var url = "{{ route('eliminarevidact', ['id' => ':id']) }}";
            url = url.replace(':id', EvidId);
            Swal.fire({
                title: "Esta seguro de eliminar la Evidencia de la Actividad?",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText : "Cerrar",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Eliminar"
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
                                    title: "¡Registro Eliminado!",
                                    text: "La Evidencia de la Actividad ha sido Eliminada.",
                                    icon: "success"
                                });
                                $('#evi-row-' + EvidId).remove();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "El Avance de la Actividad no ha sido desactivado.",
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

        $('#id_anio_act').on('change', function () {
            var AnioId = $(this).val();
            var IndId = document.getElementById('id_ip').value;
            var TriId = document.getElementById('id_trimestre_act').value;
            var url = "{{ route('veractividades_anio1', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    // Desestructurar los tres valores del JSON
                    var datos = data[0];  // Lista de actividades
                    var faltan = data[1]; // Cantidad de actividades sin avance
                    var total = data[2];  // Total de actividades
                    var table = $('#acts').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    datos.forEach(function(item) {
                        // Definir la clase para el estado basado en el valor
                        var estadoClass = item.estado_a == 'Activo' ? 'bg-success' : 'bg-danger';
                        var estadoText = item.estado_a == 'Activo' ? 'Activo' : 'Inactivo';
                        // Generar botones dinámicamente según avance
                        var botones = '';
                        if (item.avance == 0) {
                            botones += `<button type="button" class="agregar btn btn-sm btn-primary" data-id="${item.id}" data-toggle="modal" data-target="#agregaravancemodal" title="agregar avance">
                                            <i class="fas fa-plus"></i>
                                        </button>`;
                        }
                        if (item.avance == 1) {
                            botones += `<button type="button" class="ver btn btn-sm btn-info" data-id="${item.id}" data-toggle="modal" data-target="#veravancemodal" title="ver avance">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="${item.id}" data-toggle="modal" data-target="#editaravancemodal" title="modificar avance">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" data-id="${item.id}" title="desactivar avance">
                                            <i class="fas fa-user-minus"></i>
                                        </button>`;
                        }
                        // Agregar los datos a la tabla
                        table.row.add([
                            item.codigo_a, // Código
                            item.nombre_a, // Nombre de la actividad
                            `<b class="badge ${estadoClass}">${estadoText}</b>`, // Estado
                            botones // Botones dinámicos según `avance`
                            /*// Opciones: Agregar botones con las clases y atributos adecuados
                            `<button type="button" class="agregar btn btn-sm btn-primary" data-id="${item.id}" data-toggle="modal" data-target="#agregaravancemodal" title="nuevo avance">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button type="button" class="ver btn btn-sm btn-info" data-id="${item.id}" data-toggle="modal" data-target="#veravancemodal" title="ver avance">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="editar btn btn-sm btn-warning" data-id="${item.id}" data-toggle="modal" data-target="#editaravancemodal" title="modificar avance">
                                <i class="fas fa-user-edit"></i>
                            </button>
                            <button type="button" class="eliminar btn btn-sm btn-danger ${est}" data-id="${item.id}" title="desactivar avance">
                                <i class="fas fa-user-minus"></i>
                            </button>`*/
                        ]);
                    });
                    table.draw();
                    // Actualizar la alerta de aviso de avance de actividades
                    var alertaHtml = `
                        <div class="alert ${faltan === 0 ? 'alert-success' : 'alert-danger'} alert-dismissible fade show text-center h4" role="alert">
                            <strong id="control_faltan">De un total de ${total} actividades, faltan por registrar ${faltan}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `;

                    // Reemplazar el contenido de la alerta en el DOM
                    $('#alerta_actividades').html(alertaHtml);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });

        $('#id_trimestre_act').on('change', function () {
            var AnioId = document.getElementById('id_anio_act').value;
            var IndId = document.getElementById('id_ip').value;
            var TriId = $(this).val();
            var url = "{{ route('veractividades_anio1', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    // Desestructurar los tres valores del JSON
                    var datos = data[0];  // Lista de actividades
                    var faltan = data[1]; // Cantidad de actividades sin avance
                    var total = data[2];  // Total de actividades
                    var table = $('#acts').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    datos.forEach(function(item) {
                        // Definir la clase para el estado basado en el valor
                        var estadoClass = item.estado_a == 'Activo' ? 'bg-success' : 'bg-danger';
                        var estadoText = item.estado_a == 'Activo' ? 'Activo' : 'Inactivo';
                        // Generar botones dinámicamente según avance
                        var botones = '';
                        if (item.avance == 0) {
                            botones += `<button type="button" class="agregar btn btn-sm btn-primary" data-id="${item.id}" data-toggle="modal" data-target="#agregaravancemodal" title="agregar avance">
                                            <i class="fas fa-plus"></i>
                                        </button>`;
                        }
                        if (item.avance == 1) {
                            botones += `<button type="button" class="ver btn btn-sm btn-info" data-id="${item.id}" data-toggle="modal" data-target="#veravancemodal" title="ver avance">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="${item.id}" data-toggle="modal" data-target="#editaravancemodal" title="modificar avance">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" data-id="${item.id}" title="desactivar avance">
                                            <i class="fas fa-user-minus"></i>
                                        </button>`;
                        }
                        // Agregar los datos a la tabla
                        table.row.add([
                            item.codigo_a, // Código
                            item.nombre_a, // Nombre de la actividad
                            `<b class="badge ${estadoClass}">${estadoText}</b>`, // Estado
                            botones // Botones dinámicos según `avance`
                            /*// Opciones: Agregar botones con las clases y atributos adecuados
                            `<button type="button" class="agregar btn btn-sm btn-primary" data-id="${item.id}" data-toggle="modal" data-target="#agregaravancemodal" title="nuevo avance">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button type="button" class="ver btn btn-sm btn-info" data-id="${item.id}" data-toggle="modal" data-target="#veravancemodal" title="ver avance">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="editar btn btn-sm btn-warning" data-id="${item.id}" data-toggle="modal" data-target="#editaravancemodal" title="modificar avance">
                                <i class="fas fa-user-edit"></i>
                            </button>
                            <button type="button" class="eliminar btn btn-sm btn-danger ${est}" data-id="${item.id}" title="desactivar avance">
                                <i class="fas fa-user-minus"></i>
                            </button>`*/
                        ]);
                    });
                    table.draw();
                    // Actualizar la alerta de aviso de avance de actividades
                    var alertaHtml = `
                        <div class="alert ${faltan === 0 ? 'alert-success' : 'alert-danger'} alert-dismissible fade show text-center h4" role="alert">
                            <strong id="control_faltan">De un total de ${total} actividades, faltan por registrar ${faltan}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `;

                    // Reemplazar el contenido de la alerta en el DOM
                    $('#alerta_actividades').html(alertaHtml);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });

        $(document).on('click', '.agregar', function() {
            var Datos = $(this).data('id');
            var url = "{{ route('agregaravaact', ['id' => ':id']) }}";
            url = url.replace(':id', Datos);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id_a').val(data[0].id);
                    $('#id_dep').val(data[0].id_dep);
                    $('#dependencia').val(data[0].producto.dependencia.nombre_d);
                    $('#indicador').val(data[0].producto.codigo_ip);
                    $('#actividad').val(data[0].codigo_a);
                    $('#anio_act').val(data[0].anio_a);
                    $('#trim_act').val(data[0].trimestre_a);
                    $('#programado1').val(data[0].aporte_a.replace(',', '.'));
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });

        $(document).on('click', '.ver', function() {
            var AvanceId = $(this).data('id');
            var url = "{{ route('veravaact', ['id' => ':id']) }}";
            url = url.replace(':id', AvanceId);
            $('#verindicador').text('');
            $('#verdependencia').text('');
            $('#veractividad').text('');
            $('#verperiodo').text('');
            $('#verprog').text('');
            $('#veravance').text('');
            $('#verrezago').text('').removeClass();
            $('#verporcanio').text('');
            $('#verdesempenio').text('').removeClass();
            verlistaevidencias.innerHTML = '';
            $('#verestado').text('').removeClass();
            $('#vercreado').text('');
            $('#veractualizado').text('');
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    $('#verindicador').text(data[0].codigo_ip + '. ' + data[0].nombre_ip);
                    $('#verdependencia').text(data[0].nombre_d);
                    $('#veractividad').text(data[0].codigo_a + '. ' + data[0].nombre_a);
                    $('#verperiodo').text(data[0].anio + '_' + data[0].trimestre);
                    if (data.length > 0) {
                        $('#verprog').text(data[0].aporte.replace(',', '.'));
                        $('#veravance').text(data[0].avance.replace(',', '.'));
                        rezago = parseFloat(data[0].avance.replace(',', '.')) / parseFloat(data[0].aporte.replace(',', '.'));
                    }
                    else {
                        $('#veravance').text('');
                        rezago = "NE";
                    }
                    if (rezago === 1) {
                        $('#verrezago').text('Ha cumplido').removeClass().addClass('badge badge-success');
                    }
                    else {
                        if (rezago > 1) {
                            $('#verrezago').text('Rezago Superior del ' + (rezago * 100 - 100).toFixed(2) + '%').removeClass().addClass('badge badge-warning');
                        }
                        else {
                            if (rezago < 1) {
                                $('#verrezago').text('Rezago Inferior del ' + (100 - (rezago * 100)).toFixed(2) + '%').removeClass().addClass('badge badge-danger');
                            }
                            else {
                                if (rezago === 0)
                                    $('#verrezago').text('No programado').removeClass().addClass('badge badge-danger');
                                else
                                    $('#verrezago').text('No ejecutado').removeClass().addClass('badge badge-danger');
                            }
                        }
                    }
                    if (rezago != "NE") {
                        rezago = rezago1(rezago);
                        if (rezago == "Crítico")
                            $('#verdesempenio').text(rezago).removeClass().addClass('badge badge-danger');
                        else {
                            if (rezago == "Bajo")
                                $('#verdesempenio').text(rezago).removeClass().addClass('badge badge-warning');
                            else {
                                if (rezago == "medio")
                                    $('#verdesempenio').text(rezago).removeClass().addClass('badge badge-secondary');
                                else {
                                    if (rezago == "Satisfactorio")
                                        $('#verdesempenio').text(rezago).removeClass().addClass('badge badge-info');
                                    else {
                                        if (rezago == "Sobresaliente")
                                            $('#verdesempenio').text(rezago).removeClass().addClass('badge badge-success');
                                        else {
                                            if (rezago == "Sobrejecución")
                                                $('#verdesempenio').text(rezago).removeClass().addClass('badge badge-primary');
                                            else
                                                $('#verdesempenio').text(rezago).removeClass().addClass('badge badge-dark');
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else
                        $('#verdesempenio').text('').removeClass().addClass('badge badge-danger');
                    $('#verporcanio').text(((data[0].avance * 100) / data[0].total_aporte_anio).toFixed(2) + '%');
                    $('#verestado').text('Sin Evidencias').removeClass();
                    // Asegúrate de que el campo 'evidencias' existe y no es null
                    if (data[0].evidencias) {
                        // Seleccionamos el contenedor donde queremos agregar los elementos
                        const listaEvidencias = document.getElementById('verlistaevidencias'); // Asegúrate de tener un elemento con id 'lista-evidencias'
                        // Limpiar cualquier contenido previo
                        listaEvidencias.innerHTML = '';
                        const evidencias = data[0].evidencias.split('|'); // Convertir a array
                        evidencias.forEach(function(e,index) {
                            // Recorrer las evidencias y agregar un <li> por cada una
                            const li = document.createElement('li');
                            const a = document.createElement('a');
                             // Crear un texto para "Evidencia "
                            const textoEvidencia = document.createTextNode('Evidencia ' + (index + 1) + ': ');

                            // Crear el enlace
                            const evid = e.split('evidencias/')
                            // Crear el enlace con la URL de la evidencia
                            a.href = '../../storage/' + e;
                            a.target = '_blank';
                            a.textContent = evid[1];
                            //a.textContent = 'Ver Evidencia ' + (index + 1);
                            // Agregar el enlace y el texto al <li>
                            li.appendChild(textoEvidencia);
                            li.appendChild(a);
                            // Agregar el <li> a la lista
                            listaEvidencias.appendChild(li);    
                        });
                    } else {
                        $('#verevidencia').text('Sin Evidencias').addClass('badge').addClass('bg-danger');
                    }
                    //$('#verevidencia').text(evid);
                    if (data.length > 0) {
                        $('#verestado').text(data[0].estado).removeClass().addClass('badge').addClass(data[0].estado === 'Activo' ? 'bg-success' : 'bg-danger');
                        var fechacreado = new Date(data[0].created_at);
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
                        var fechaactualizado = new Date(data[0].updated_at);
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
                    }
                    else {
                        $('#verestado').text('');
                        $('#vercreado').text('');
                        $('#veractualizado').text('');
                    }
                    $('#veravancemodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });

        function rezago1(r) {
            r = Math.abs(r);
            if (r>0 && r<0.4)
                return "Crítico";
            else {
                if (r>=0.4 && r<=0.6)
                    return "Bajo";
                else {
                    if (r>0.6 && r<=0.7)
                        return "Medio";
                    else {
                        if (r>0.7 && r<=0.8)
                            return "Satisfactorio";
                        else {
                            if (r>0.8 && r<=1)
                                return "Sobresaliente";
                            else {
                                if (r>1 && r<=3)
                                    return "Sobre Ejecución";
                                else {
                                    return "Revisar el dato ingresado";
                                }
                            }
                        }
                    }
                }
            }
        }

        $('#agregaravancemodal').on('hidden.bs.modal', function () {
            $(this).find('input[type="text"], input[type="number"]').val('0'); // Limpiar textos y números
            $(this).find('input[type="file"]').val(null); // Limpiar input de archivos
            $(this).find('select').prop('selectedIndex', 0); // Resetear selects al primer valor
            $(this).find('.badge').text('').removeClass('bg-success bg-danger bg-warning'); // Limpiar spans con badge
            $('#verlistaevidencias').empty(); // Vaciar la lista de evidencias
        });
    </script>    
@endsection