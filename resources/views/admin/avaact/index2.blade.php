@extends('Layouts.plantilla')

@section('titulo', 'Actividades - Indicador')

@section('contenido')
    <div id="alerta_actividades"></div>
    @if ($faltan == 0)
        <div class="alert alert-success alert-dismissible fade show text-center h4" role="alert" id="alerta_blade">
            <strong id="control_faltan">No faltan avances por reportar</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @else
        <div class="alert alert-danger alert-dismissible fade show text-center h4" role="alert" id="alerta_blade">
            <strong id="control_faltan">De un total de {{ $total }} actividades, Faltan por reportar {{ $faltan }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>Avance de Actividades
                        <a href="{{ route('listaravaacts') }}" class="btn btn-primary">
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
                                        <th class="text-center">Acciones del Indicador</th>
                                        <th class="text-center">Dependencia Responsable</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    <tr class="text-center">
                                        <td id="ind" class="text-center"><input type="text" id="id_ip" hidden value="{{ $ip->id }}">{{ $ip->codigo_ip.'. '.$ip->nombre_ip }}</th>
                                        <td class="text-center">
                                            <button type="button" class="ver_ip btn btn-sm btn-info" data-id="{{ $ip->id }}" data-toggle="modal" data-target="#veravanceipmodal" title="ver avance del indicador">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#guardarevidenciasipmodal" title="cargar evidencias del indicador">
                                                <i class="fas fa-cloud-upload"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editarevidenciasipmodal" title="cargar evidencias del indicador">
                                                <i class="fas fa-cloud-upload"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#verevidenciasipmodal" title="ver evidencias del indicador">
                                                <i class="fas fa-solid fa-file"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#guardarlogrosipmodal" title="agregar logros del indicador">
                                                <i class="fas fa-solid fa-trophy"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editarlogrosipmodal" title="editar logros del indicador">
                                                <i class="fas fa-solid fa-trophy"></i>
                                            </button>
                                        </td>
                                        <td id="dep" class="text-center">{{ $ip->dependencia->nombre_d }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group m-2">
                                <label for="id_anio" class="position-relative" style="top: -25px;">Año</label>
                                <select name="id_anio" id="id_anio_act" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="0" selected>Todos</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group m-2">
                                <label for="id_trimestre" class="position-relative" style="top: -25px;">Trimestre</label>
                                <select name="id_trimestre" id="id_trimestre_act" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="0" selected>Todos</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>      
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-2">
                                <label for="rezago" class="position-relative" style="top: -25px;">Mostrar Rezagos / Ejecutado 100% / Sin Ejecutar / Desempeño</label>
                                <select name="rezago" id="rezago" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                    <option value="1" selected disabled>Seleccione una opción</option>
                                    <option value="0">Mostrar todos los indicadores</option>
                                    <option value="2">Ejecutado 100%</option>
                                    <option value="3">Rezago</option>
                                    <option value="4">Sin ejecutar</option>
                                    <option value="5">Desempeño Crítico</option>
                                    <option value="6">Desempeño Bajo</option>
                                    <option value="7">Desempeño Medio</option>
                                    <option value="8">Desempeño Satisfactorio</option>
                                    <option value="9">Desempeño Sobresaliente</option>
                                    <option value="10">Desempeño Sobre Ejecutado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row container-fluid">
                        <div class="table-responsive">
                            <table class="table w-auto" style="table-layout: auto;" id="acts">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th class="text-center">Código</th>
                                        <th class="text-center" width="30%">Actividad</th>
                                        <th class="text-center">Periodo</th>
                                        <th class="text-center">% Avance</th>
                                        <th class="text-center">% Periodo</th>
                                        <th class="text-center">% Año</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    @foreach ($acts as $act)
                                        <tr class="text-center" id="ava-row-{{ $act->id }}">
                                            <td>
                                                {{ $act->id }}
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $act->codigo_a }}
                                            </td>
                                            <td class="text-center align-middle" width="30%">
                                                {{ $act->nombre_a }}
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $act->anio_a.'_'.$act->trimestre_a }}
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $act->porcentaje_avance.' %' }}
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: {{ $act->porcentaje_avance }}%;" 
                                                        aria-valuenow="{{ $act->porcentaje_avance }}" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                                @if ($act->porcentaje_avance >= 0 && $act->porcentaje_avance < 40)
                                                    <b class="badge bg-danger"><span>Crítico</span></b>
                                                @else
                                                    @if ($act->porcentaje_avance >= 40 && $act->porcentaje_avance <= 60)
                                                        <b class="badge bg-orange"><span>Bajo</span></b>
                                                    @else
                                                        @if ($act->porcentaje_avance > 60 && $act->porcentaje_avance <= 70)
                                                            <b class="badge bg-warning"><span>Medio</span></b>
                                                        @else
                                                            @if ($act->porcentaje_avance > 70 && $act->porcentaje_avance <= 80)
                                                                <b class="badge bg-success"><span>Satisfactorio</span></b>
                                                            @else
                                                                @if ($act->porcentaje_avance > 80 && $act->porcentaje_avance <= 100)
                                                                    <b class="badge bg-primary"><span>Sobresaliente</span></b>
                                                                @else
                                                                    <b class="badge" style="background-color: #6f42c1; color: white;"><span>Sobrejecutado</span></b>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $act->porcentaje_periodo.' %' }}
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: {{ $act->porcentaje_periodo }}%;" 
                                                        aria-valuenow="{{ $act->porcentaje_periodo }}" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $act->porcentaje_anio.' %' }}
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: {{ $act->porcentaje_anio }}%;" 
                                                        aria-valuenow="{{ $act->porcentaje_anio }}" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
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
                                            <td class="text-center align-middle">
                                                @if ($act->avance == 0)
                                                    <button type="button" class="agregar btn btn-sm btn-primary" data-id="{{ $act->id }}" data-toggle="modal" data-target="#agregaravancemodal" title="agregar avance">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                @endif
                                                @if ($act->avance == 1)
                                                    <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $act->id }}" data-toggle="modal" data-target="#veravancemodal" title="ver avance">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $act->id }}" data-toggle="modal" data-target="#editaravancemodal" title="modificar avance">
                                                        <i class="fas fa-user-edit"></i>
                                                    </button>
                                                    <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $act->id }}" title="desactivar avance">
                                                        <i class="fas fa-user-minus"></i>
                                                    </button>
                                                @endif
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
                        <form action="{{ route('guardaravaact') }}" method="POST">
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group m-2">
                                        <label for="desc_act" class="position-relative">Descripción del Periodo</label>
                                        <textarea name="desc_act" id="desc_act" class="form-control" placeholder="Justificación del logro" required></textarea>
                                        <div class="d-flex justify-content-end mt-1">
                                            <span class="badge btn-danger" id="max_logro_act">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="envia_act" disabled>Guardar</button>
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
                            <input type="hidden" name="avance_oculto" id="avance1_editar_oculto">
                            <div class="form-group m-2">
                                <label for="id_dep">Dependencia Responsable <b class="text-danger"></b></label>
                                <input type="text" name="id_dep" class="form-control" readonly id="dependencia_editar">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="id_ip">Indicador <b class="text-danger"></b></label>
                                        <input type="text" name="id_ip_cod" class="form-control" readonly id="indicador_editar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="actividad">Actividad <b class="text-danger"></b></label>
                                        <input type="text" name="actividad" class="form-control" readonly id="actividad_editar">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="anio">Año <b class="text-danger"></b></label>
                                        <input type="text" name="anio" class="form-control" readonly id="anio_act_editar">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="trimestre">Trimestre <b class="text-danger"></b></label>
                                        <input type="text" name="trimestre" class="form-control" readonly id="trim_act_editar">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="avance">Avance del Periodo <b class="text-danger"> * </b></label>
                                        <input type="text" name="avance" id="avance1_editar" autofocus class="form-control"
                                            placeholder="Ingrese el avance del periodo" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado">Programado del Periodo <b class="text-danger"></b></label>
                                        <input type="text" name="programado" id="programado1_editar" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago1_editar">
                                    <b class="badge"></b>
                                </span>
                                <span id="ver_desempenio_editar">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group m-2">
                                        <label for="desc_act" class="position-relative">Descripción del Periodo</label>
                                        <textarea name="desc_act" id="desc_act_editar" class="form-control" placeholder="Justificación del logro" required></textarea>
                                        <div class="d-flex justify-content-end mt-1">
                                            <span class="badge btn-danger" id="max_logro_act_editar">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <label for="estado">Estado</label>
                                <select name="estado" id="estado" class="form-control" style="width: 100%">
                                    <option value="" disabled>Seleccionar</option>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" id="envia_act_editar">Guardar</button>
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
                        <p><strong>% Avance: </strong><span id="verporcavance"></span></p>
                        <p><strong>Desempeño: </strong><span id="verdesempenio" class="badge"></span></p>
                        <p><strong>Rezago: </strong><span id="verrezago" class="badge"></span></p>
                        <p><strong>% Periodo <span id="verperiodo1"></span>: </strong><span id="verporcperiodo"></span></p>
                        <p><strong>% Año <span id="veranio"></span>: </strong><span id="verporcanio"></span></p>
                        <p><strong>Justificación: </strong><span id="verjust_act"></span></p>
                        <p><strong>Estado: </strong><span id="verestado" class="badge bg-danger"></span></p>
                        <p><strong>Registro: </strong><span id="vercreado"></span></p>
                        <p><strong>Última Actualización: </strong><span id="veractualizado"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="veravanceipmodal">
            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Ver Datos del Avance Estratégico del Indicador - {{ $ip->codigo_ip }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Indicador: </strong><span id="cod_ip"></span></p>
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
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2024_3:</strong> <span id="avance_2024_3"></span></td>
                                            <td class="align-middle"><strong>Programado 2024_3:</strong> <span id="programado_2024_3"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2024_3:</strong> <span id="porcentaje_avance_2024_3"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2024_3">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2024_3'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2024_3'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2024_4:</strong> <span id="avance_2024_4"></span></td>
                                            <td class="align-middle"><strong>Programado 2024_4:</strong> <span id="programado_2024_4"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2024_4:</strong> <span id="porcentaje_avance_2024_4"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2024_4">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2025_1'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2025_1'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Total 2024:</strong> <span id="avance_2024"></span></td>
                                            <td class="align-middle"><strong>Programado 2024:</strong> <span id="programado_2024"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2024:</strong> <span id="porcentaje_2024"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2024">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2024'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2024'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="modal-body">
                                    <table id="tabla_logros_2024">
                                        <thead>
                                            <th class="text-center">Periodo</th>
                                            <th class="text-center">Justificación</th>
                                        </thead>
                                        <tbody id="tbody-logros_2024_ip">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-body">
                                    <table id="ver_evi_ip_2024">
                                        <thead>
                                            <th class="text-center">Archivo</th>
                                            <th class="text-center">Tipo de Archivo</th>
                                            <th class="text-center">Periodo</th>
                                            <th class="text-center">Estado</th>
                                        </thead>
                                        <tbody id="evidencias_ip_2024">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
    
                            <!-- Contenido para 2025 -->
                            <div class="tab-pane fade" id="content-2025_consulta" role="tabpanel" aria-labelledby="tab-2025_consulta">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2025_1:</strong> <span id="avance_2025_1"></span></td>
                                            <td class="align-middle"><strong>Programado 2025_1:</strong> <span id="programado_2025_1"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2025_1:</strong> <span id="porcentaje_avance_2025_1"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2025_1">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2025_1'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2025_1'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2025_2:</strong> <span id="avance_2025_2"></span></td>
                                            <td class="align-middle"><strong>Programado 2025_2:</strong> <span id="programado_2025_2"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2025_2:</strong> <span id="porcentaje_avance_2025_2"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2025_2">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2025_2'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2025_2'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2025_3:</strong> <span id="avance_2025_3"></span></td>
                                            <td class="align-middle"><strong>Programado 2025_3:</strong> <span id="programado_2025_3"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2025_3:</strong> <span id="porcentaje_avance_2025_3"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2025_3">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2025_3'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2025_3'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2025_4:</strong> <span id="avance_2025_4"></span></td>
                                            <td class="align-middle"><strong>Programado 2025_4:</strong> <span id="programado_2025_4"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2025_4:</strong> <span id="porcentaje_avance_2025_4"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2025_4">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2025_4'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2025_4'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Total 2025:</strong> <span id="avance_2025"></span></td>
                                            <td class="align-middle"><strong>Programado 2025:</strong> <span id="programado_2025"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2025:</strong> <span id="porcentaje_2025"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2025">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2025'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2025'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="modal-body">
                                    <table id="tabla_logros_2025">
                                        <thead>
                                            <th class="text-center">Periodo</th>
                                            <th class="text-center">Justificación</th>
                                        </thead>
                                        <tbody id="tbody-logros_2025_ip">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-body">
                                    <table id="ver_evi_ip_2025">
                                        <thead>
                                            <th class="text-center">Archivo</th>
                                            <th class="text-center">Tipo de Archivo</th>
                                            <th class="text-center">Periodo</th>
                                            <th class="text-center">Estado</th>
                                        </thead>
                                        <tbody id="evidencias_ip_2025">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
    
                            <!-- Contenido para 2026 -->
                            <div class="tab-pane fade" id="content-2026_consulta" role="tabpanel" aria-labelledby="tab-2026_consulta">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2026_1:</strong> <span id="avance_2026_1"></span></td>
                                            <td class="align-middle"><strong>Programado 2026_1:</strong> <span id="programado_2026_1"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2026_1:</strong> <span id="porcentaje_avance_2026_1"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2026_1">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2026_1'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2026_1'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2026_2:</strong> <span id="avance_2026_2"></span></td>
                                            <td class="align-middle"><strong>Programado 2026_2:</strong> <span id="programado_2026_2"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2026_2:</strong> <span id="porcentaje_avance_2026_2"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2026_2">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2026_2'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2026_2'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2026_3:</strong> <span id="avance_2026_3"></span></td>
                                            <td class="align-middle"><strong>Programado 2026_3:</strong> <span id="programado_2026_3"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2026_3:</strong> <span id="porcentaje_avance_2026_3"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2026_3">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2026_3'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2026_3'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2026_4:</strong> <span id="avance_2026_4"></span></td>
                                            <td class="align-middle"><strong>Programado 2026_4:</strong> <span id="programado_2026_4"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2026_4:</strong> <span id="porcentaje_avance_2026_4"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2026_4">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2026_4'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2026_4'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Total 2026:</strong> <span id="avance_2026"></span></td>
                                            <td class="align-middle"><strong>Programado 2026:</strong> <span id="programado_2026"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2026:</strong> <span id="porcentaje_2026"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2026">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2026'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2026'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="modal-body">
                                    <table id="tabla_logros_2026">
                                        <thead>
                                            <th class="text-center">Periodo</th>
                                            <th class="text-center">Justificación</th>
                                        </thead>
                                        <tbody id="tbody-logros_2026_ip">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-body">
                                    <table id="ver_evi_ip_2026">
                                        <thead>
                                            <th class="text-center">Archivo</th>
                                            <th class="text-center">Tipo de Archivo</th>
                                            <th class="text-center">Periodo</th>
                                            <th class="text-center">Estado</th>
                                        </thead>
                                        <tbody id="evidencias_ip_2026">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
    
                            <!-- Contenido para 2027 -->
                            <div class="tab-pane fade" id="content-2027_consulta" role="tabpanel" aria-labelledby="tab-2027_consulta">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2027_1:</strong> <span id="avance_2027_1"></span></td>
                                            <td class="align-middle"><strong>Programado 2027_1:</strong> <span id="programado_2027_1"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2027_1:</strong> <span id="porcentaje_avance_2027_1"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2027_1">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2027_1'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2027_1'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2027_2:</strong> <span id="avance_2027_2"></span></td>
                                            <td class="align-middle"><strong>Programado 2027_2:</strong> <span id="programado_2027_2"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2027_2:</strong> <span id="porcentaje_avance_2027_2"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2027_2">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2027_2'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2027_2'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2027_3:</strong> <span id="avance_2027_3"></span></td>
                                            <td class="align-middle"><strong>Programado 2027_3:</strong> <span id="programado_2027_3"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2027_3:</strong> <span id="porcentaje_avance_2027_3"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2027_3">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2027_3'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2027_3'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Avance 2027_4:</strong> <span id="avance_2027_4"></span></td>
                                            <td class="align-middle"><strong>Programado 2027_4:</strong> <span id="programado_2027_4"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2027_4:</strong> <span id="porcentaje_avance_2027_4"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2027_4">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2027_4'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2027_4'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="align-middle"><strong>Total 2027:</strong> <span id="avance_2027"></span></td>
                                            <td class="align-middle"><strong>Programado 2027:</strong> <span id="programado_2027"></span></td>
                                            <td class="align-middle">
                                                <strong>% Avance 2027:</strong> <span id="porcentaje_2027"></span>
                                                <div class="progress" style="height: 10px;" id="progress_2027">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: <span id='p_avance_2027'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2027'></span>" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="modal-body">
                                    <table id="tabla_logros_2027">
                                        <thead>
                                            <th class="text-center">Periodo</th>
                                            <th class="text-center">Justificación</th>
                                        </thead>
                                        <tbody id="tbody-logros_2027_ip">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-body">
                                    <table id="ver_evi_ip_2027">
                                        <thead>
                                            <th class="text-center">Archivo</th>
                                            <th class="text-center">Tipo de Archivo</th>
                                            <th class="text-center">Periodo</th>
                                            <th class="text-center">Estado</th>
                                        </thead>
                                        <tbody id="evidencias_ip_2027">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                        
                        <p><strong>Estado: </strong><span id="verestado_ip"></span></p>
                        <p><strong>Registro: </strong><span id="vercreado_ip"></span></p>
                        <p><strong>Última Actualización: </strong><span id="veractualizado_ip"></span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="guardarevidenciasipmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Cargar Evidencias del Indicador - {{ $ip->codigo_ip }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formularioEvidencias" action="{{ route('guardarevidenciasip') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_ip" id="id_ip_e" value="{{ $ip->id }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="id_anio" class="position-relative" style="top: -25px;">Año</label>
                                        <select name="id_anio" id="id_anio_eip" class="form-control position-relative" style="top: -25px;" data-live-search="true">
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
                                        <select name="id_trimestre" id="id_trimestre_eip" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                            <option value="0" selected>Todos</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>      
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group">
                                <!-- Input de archivo oculto -->
                                <label for="evidencias" class="btn btn-primary">Seleccionar Evidencias (PDF y/o Imagen):</label>
                                <input 
                                    type="file" 
                                    name="evidencias[]" 
                                    id="evidencias"
                                    class="form-control"
                                    accept="application/pdf, image/*" 
                                    multiple 
                                    style="display: none;"
                                >
                            </div>
                            <div>
                                <span class="badge">Nota: Se permite cargar hasta 5 archivos en formato pdf o imágen</span>
                            </div>
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
                            <div class="mt-3">
                                <button class="btn btn-success" type="submit">Guardar Evidencias</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal fade" id="editarevidenciasipmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Evidencias del Indicador - {{ $ip->codigo_ip }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formularioEvidenciasEditar" action="{{ route('actualizarevidenciasip') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_ip" id="id_ip_e_editar" value="{{ $ip->id }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="id_anio" class="position-relative" style="top: -25px;">Año</label>
                                        <select name="id_anio" id="id_anio_eip_editar" class="form-control position-relative" style="top: -25px;" data-live-search="true">
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
                                        <select name="id_trimestre" id="id_trimestre_eip_editar" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                            <option value="0" selected>Todos</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>      
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group">
                                <!-- Input de archivo oculto -->
                                <label for="evidencias-editar" class="btn btn-primary">Seleccionar Evidencias (PDF y/o Imagen):</label>
                                <input 
                                    type="file" 
                                    name="evidencias[]" 
                                    id="evidencias-editar"
                                    class="form-control"
                                    accept="application/pdf, image/*" 
                                    multiple 
                                    style="display: none;"
                                >
                            </div>
                            <div>
                                <span class="badge">Nota: Se permite cargar hasta 5 archivos en formato pdf o imágen</span>
                            </div>
                            <table id="tabla-archivos-editar" style="display: none;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-archivos-editar">
                                    <!-- Aquí se agregarán dinámicamente los archivos -->
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <button class="btn btn-success" type="submit">Actualizar Evidencias</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="verevidenciasipmodal" width="100%">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Ver Evidencias del Indicador - {{ $ip->codigo_ip }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="ver_evi">
                            <thead>
                                <th class="text-center">Archivo</th>
                                <th class="text-center">Tipo de Archivo</th>
                                <th class="text-center">Periodo</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach ($evidencias as $evi)
                                    <tr class="text-center">
                                        <td class="text-center display-6">
                                            <a href="{{ asset('storage/'.$evi->evidencia) }}" target="_blank">{{ $evi->texto_evidencia }}</a>
                                        </td>
                                        <td class="text-center">
                                            @if (substr($evi->evidencia, -3) == 'pdf')
                                                <i class="fas fa-file-pdf text-danger h4"></i>
                                            @else
                                                <i class="fas fa-file-image text-primary h4"></i>
                                            @endif    
                                        </td>
                                        <td class="text-center">{{ $evi->anio_eip.'_'.$evi->trimestre_eip }}</td>
                                        <td class="text-center">
                                            @if ($evi->estado_e == 'Activo')
                                                <b class="badge bg-success estado">
                                                    {{ $evi->estado_e }}
                                                </b>
                                            @else
                                                <b class="badge bg-danger">
                                                    {{ $evi->estado_e }}
                                                </b>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($evi->estado == 'Activo')
                                                <button type="button" class="btn btn-sm btn-danger eliminar-evidencia" data-id="{{ $evi->id }}" title="Eliminar evidencia">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="guardarlogrosipmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Logro del Indicador - {{ $ip->codigo_ip }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formularioLogros" action="{{ route('guardarlogroip') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_ip" id="id_ip_e" value="{{ $ip->id }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="id_anio" class="position-relative" style="top: -25px;">Año</label>
                                        <select name="id_anio" id="id_anio_lip" class="form-control position-relative" style="top: -25px;" data-live-search="true">
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
                                        <select name="id_trimestre" id="id_trimestre_lip" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                            <option value="0" selected>Todos</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>      
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <span class="badge">Nota: Ingrese mínimo 500 caracteres para la justificación</span>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group m-2">
                                        <label for="logro_ip" class="position-relative">Logro del Periodo</label>
                                        <textarea name="logro_ip" id="logro_ip" class="form-control" placeholder="Justificación del logro" required></textarea>
                                        <div class="d-flex justify-content-end mt-1">
                                            <span class="badge btn-danger" id="max_logro_ip">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-success" id="envia_logro" type="submit" disabled>Guardar Logro</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editarlogrosipmodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Logro del Indicador - {{ $ip->codigo_ip }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formularioLogrosEditar" action="{{ route('actualizarlogroip') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_ip" id="id_ip_e" value="{{ $ip->id }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="id_anio" class="position-relative" style="top: -25px;">Año</label>
                                        <select name="id_anio" id="id_anio_lip_editar" class="form-control position-relative" style="top: -25px;" data-live-search="true">
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
                                        <select name="id_trimestre" id="id_trimestre_lip_editar" class="form-control position-relative" style="top: -25px;" data-live-search="true">
                                            <option value="0" selected>Todos</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>      
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <span class="badge">Nota: Ingrese mínimo 500 caracteres para la justificación</span>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group m-2">
                                        <label for="logro_ip" class="position-relative">Logro del Periodo</label>
                                        <textarea name="logro_ip" id="logro_ip_editar" class="form-control" placeholder="Justificación del logro" required></textarea>
                                        <div class="d-flex justify-content-end mt-1">
                                            <span class="badge btn-danger" id="max_logro_ip_editar">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-success" id="envia_logro_editar" type="submit" disabled>Guardar Logro</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        
        document.addEventListener('DOMContentLoaded', function () {
            const formularioEvidencias = document.getElementById('formularioEvidencias');
            const formularioEvidenciasEditar = document.getElementById('formularioEvidenciasEditar');
            const inputip = document.getElementById('id_ip_e');
            const selectanio = document.getElementById('id_anio_eip');
            const selectanioeditar = document.getElementById('id_anio_eip_editar');
            const selecttri = document.getElementById('id_trimestre_eip');
            const selecttrieditar = document.getElementById('id_trimestre_eip_editar');
            const inputEvidencias = document.getElementById('evidencias');
            const inputEvidenciasEditar = document.getElementById('evidencias-editar');
            const labelEvidencias = document.querySelector("label[for='evidencias']");
            const labelEvidenciasEditar = document.querySelector("label[for='evidencias-editar']");
            const tablaArchivos = document.getElementById('tabla-archivos');
            const tablaArchivosEditar = document.getElementById('tabla-archivos-editar');
            const tbodyArchivos = document.getElementById('tbody-archivos');
            const tbodyArchivosEditar = document.getElementById('tbody-archivos-editar');
            const tbodyLogrosIp = document.getElementById('tbody-logro_ip');
            const maxArchivos = 5;
            let archivosSeleccionados = [];
            let archivosSeleccionadosEditar = [];
            
            function obtenerIcono(tipo) {
                if (tipo === 'application/pdf') {
                    return '<i class="fas fa-file-pdf text-danger h3"></i>';
                } else if (['image/jpg', 'image/jpeg', 'image/png'].includes(tipo)) {
                    return '<i class="fas fa-file-image text-primary h3"></i>';
                }
            }

            function actualizarListaArchivos() {
                tbodyArchivos.innerHTML = ''; 
                alert(1);
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

            function actualizarListaArchivosEditar() {
                tbodyArchivosEditar.innerHTML = ''; 
                alert(0);
                archivosSeleccionadosEditar.forEach((archivo, index) => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td class="text-center">${index + 1}</td>
                        <td>${archivo.name}</td>
                        <td class="text-center">${obtenerIcono(archivo.type)}</td>
                        <td class="text-center"><button class="btn btn-danger btn-sm eliminar-archivo-editar" data-index="${index}"><i class="fas fa-trash-alt"></i></button></td>
                    `;
                    tbodyArchivosEditar.appendChild(fila);
                });

                labelEvidenciasEditar.style.display = archivosSeleccionadosEditar.length >= maxArchivos ? 'none' : 'inline-block';
                tablaArchivosEditar.style.display = archivosSeleccionadosEditar.length > 0 ? 'table' : 'none';
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

            inputEvidenciasEditar.addEventListener('change', function (e) {
                const nuevosArchivos = Array.from(e.target.files);

                if (archivosSeleccionadosEditar.length + nuevosArchivos.length > maxArchivos) {
                    alert(`Solo puedes agregar hasta ${maxArchivos} archivos.`);
                    e.target.value = ''; 
                    return;
                }

                nuevosArchivos.forEach((archivo) => {
                    const tipoArchivo = archivo.type;
                    if (['application/pdf', 'image/jpg', 'image/jpeg', 'image/png'].includes(tipoArchivo)) {
                        archivosSeleccionadosEditar.push(archivo);
                    } else {
                        alert('Solo se permiten archivos PDF - JPG - JPEG - PNG.');
                    }
                });

                e.target.value = ''; 
                actualizarListaArchivosEditar();
            });

            tbodyArchivos.addEventListener('click', function (e) {
                if (e.target.closest('.eliminar-archivo')) {
                    const index = e.target.closest('.eliminar-archivo').getAttribute('data-index');
                    archivosSeleccionados.splice(index, 1);
                    actualizarListaArchivos();
                }
            });

            tbodyArchivosEditar.addEventListener('click', function (e) {
                if (e.target.closest('.eliminar-archivo-editar')) {
                    const index = e.target.closest('.eliminar-archivo-editar').getAttribute('data-index');
                    archivosSeleccionadosEditar.splice(index, 1);
                    actualizarListaArchivosEditar();
                }
            });

            // Subir evidencias (Formulario de evidencias)
            formularioEvidencias.addEventListener('submit', function(event) {
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

                // Verifica que `formData` contenga los archivos antes de enviar
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + (pair[1] instanceof File ? pair[1].name : pair[1]));  // Log de los archivos
                }
                
                var urlE = $("#formularioEvidencias").attr("action");

                $.ajax({
                    url: urlE,
                    type: "POST",
                    data: formData,  // Asegurarse de enviar `formData`
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Guardar mensaje en localStorage
                            localStorage.setItem("toastr_message", response.message);
                            //console.log('Respuesta:', response);
                            // Redirigir a la URL proporcionada
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        toastr.error("Hubo un error al guardar las evidencias.");
                    }
                });
            });

            formularioEvidenciasEditar.addEventListener('submit', function(event) {
                event.preventDefault(); // Evita el envío tradicional del formulario
                
                let formData = new FormData(this); // Capturar los datos del formulario

                // Asegurarnos de que se están agregando los archivos seleccionados
                if (archivosSeleccionadosEditar.length === 0) {
                    alert("No se ha seleccionado ningún archivo.");
                    return;
                }

                archivosSeleccionadosEditar.forEach((archivo, index) => {
                    formData.append('evidencias[]', archivo);
                });

                // Verifica que `formData` contenga los archivos antes de enviar
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + (pair[1] instanceof File ? pair[1].name : pair[1]));  // Log de los archivos
                }
                
                var urlE = $("#formularioEvidenciasEditar").attr("action");

                $.ajax({
                    url: urlE,
                    type: "POST",
                    data: formData,  // Asegurarse de enviar `formData`
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Guardar mensaje en localStorage
                            localStorage.setItem("toastr_message", response.message);
                            //console.log('Respuesta:', response);
                            // Redirigir a la URL proporcionada
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        toastr.error("Hubo un error al actualizar las evidencias.");
                    }
                });
            });

            $('#id_anio_eip_editar, #id_trimestre_eip_editar').on('change', function () {
                const id_ip = document.getElementById('id_ip_e_editar').value;
                const anio = document.getElementById('id_anio_eip_editar').value;
                const trimestre = document.getElementById('id_trimestre_eip_editar').value;
                const datos = `${id_ip}_${anio}_${trimestre}`;
                if (anio != '0' && trimestre != '0') {
                    // Generar la URL correctamente
                    const url = `{{ route('editarevidenciasip', ['id' => '__ID__']) }}`.replace('__ID__', datos);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(data) {
                            tbodyArchivosEditar.innerHTML = '';
                            if (!data || data.length === 0) {
                                tablaArchivosEditar.style.display = 'none';
                                return;
                            }

                            data.forEach((archivo, index) => {
                                const nombre = archivo.evidencia.split('_').slice(5).join('_');
                                const ultimopunto = nombre.lastIndexOf('.');
                                const extension = ultimopunto !== -1 ? nombre.substring(ultimopunto + 1) : '';
                                let icono = extension === 'pdf' ? '<i class="fas fa-file-pdf text-danger h4"></i>' : '<i class="fas fa-file-image text-primary h4"></i>';
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td class="text-center">${index + 1}</td>
                                    <td><a href="../../storage/` + archivo.evidencia + `" target="_blank">${nombre}</a></td>
                                    <td class="text-center">${icono}</td>
                                    <td class="text-center"><button class="btn btn-danger btn-sm eliminar-archivo" data-index="${index}"><i class="fas fa-trash-alt"></i></button></td>
                                `;
                                tbodyArchivosEditar.appendChild(tr);
                            });

                            tablaArchivosEditar.style.display = 'table';
                        },
                        error: function(xhr, status, error) {
                            console.error('Error AJAX:', status, error);
                        }
                    });
                }
            });

            $('#guardarevidenciasipmodal').on('hidden.bs.modal', function () {
                $(this).find('input[type="text"], input[type="number"]').val('0'); // Limpiar textos y números
                $(this).find('input[type="file"]').val(null); // Limpiar input de archivos
                $(this).find('select').prop('selectedIndex', 0); // Resetear selects al primer valor
                $('#tbody-archivos').empty(); // Vaciar la lista de evidencias
                $('#tabla-archivos').hide(); // Ocultar la lista de evidencias
                labelEvidencias.style.display = 'inline-block'; // Mostrar el label si estaba oculto
            });

            $('#editarevidenciasipmodal').on('hidden.bs.modal', function () {
                $(this).find('input[type="text"], input[type="number"]').val('0'); // Limpiar textos y números
                $(this).find('input[type="file"]').val(null); // Limpiar input de archivos
                $(this).find('select').prop('selectedIndex', 0); // Resetear selects al primer valor
                $('#tbody-archivos-editar').empty(); // Vaciar la lista de evidencias
                $('#tabla-archivos-editar').hide(); // Ocultar la lista de evidencias
                labelEvidenciasEditar.style.display = 'inline-block'; // Mostrar el label si estaba oculto
            });
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
                paging: true,
                searching: true,
                ordering: true,
                pagingType: 'full_numbers',
                language: {
                    paginate: {
                        first: '<<',
                        previous: '<',
                        next: '>',
                        last: '>>'
                    },
                    url: "/plugins/datatables/idioma.json",
                },
                columnDefs: [
                    { className: "text-center", orderable: false, targets: "_all" },
                    {
                        targets: 0,        // Primera columna (índice 0)
                        visible: false,    // Oculta columna
                        searchable: false
                    },
                    {
                        targets: "_all",        // A todas las columnas
                        className: "text-center align-middle"
                    }
                ]
            });

            $('#ver_evi').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                pagingType: 'full_numbers',
                language: {
                    paginate: {
                        first: '<<',
                        previous: '<',
                        next: '>',
                        last: '>>'
                    },
                    url: "/plugins/datatables/idioma.json",
                },
                columnDefs: [
                    { className: "text-center", orderable: false, targets: "_all" }
                ]
            });

            /*$('#acts, #ver_evi').DataTable({
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
            });*/
            $('#tabla-archivos, #tabla-archivos-editar').DataTable({
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

            if (avance === '' || parseFloat(avance) === 0  || avance === '0.') {
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
                                    badgeRezago.text(`Rezago del ${(rezago - 100).toFixed(2)}%`).removeClass().addClass('badge badge-warning');
                                } else {
                                    badgeRezago.text(`Rezago del ${(100 - rezago).toFixed(2)}%`).removeClass().addClass('badge badge-danger');
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
            const anio = document.getElementById('anio_act_editar').value;
            const trimestre = document.getElementById('trim_act_editar').value;
            const id_dep = document.getElementById('id_dep1_editar').value;

            const datos = `${id_a}_${avance}_${anio}_${trimestre}_${id_dep}_1`;
            const badgeRezago = $('#ver_rezago1_editar .badge');
            const badgeDesempeno = $('#ver_desempenio_editar .badge'); // Nuevo badge

            // Generar la URL correctamente
            const url = `{{ route('rezago1', ['id' => '__ID__']) }}`.replace('__ID__', datos);

            /*if (avance === '' || parseFloat(avance) === 0) {  
                badgeRezago.text('').removeClass().addClass('badge');
                badgeDesempeno.text('').removeClass().addClass('badge');
                return;
            }*/

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    if (Array.isArray(data)) {
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
                                    badgeRezago.text(`Rezago del ${(rezago - 100).toFixed(2)}%`).removeClass().addClass('badge badge-warning');
                                } else {
                                    badgeRezago.text(`Rezago del ${(100 - rezago).toFixed(2)}%`).removeClass().addClass('badge badge-danger');
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

        $('#editaravancemodal').on('shown.bs.modal', function () {
            const id_a = document.getElementById('id_a1_editar').value;
            const avance = document.getElementById('avance1_editar').value;
            const anio = document.getElementById('anio_act_editar').value;
            const trimestre = document.getElementById('trim_act_editar').value;
            const id_dep = document.getElementById('id_dep1_editar').value;

            const datos = `${id_a}_${avance}_${anio}_${trimestre}_${id_dep}_1`;
            const badgeRezago = $('#ver_rezago1_editar .badge');
            const badgeDesempeno = $('#ver_desempenio_editar .badge'); // Nuevo badge

            // Generar la URL correctamente
            const url = `{{ route('rezago1', ['id' => '__ID__']) }}`.replace('__ID__', datos);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    if (Array.isArray(data)) {
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
                                    badgeRezago.text(`Rezago del ${(rezago - 100).toFixed(2)}%`).removeClass().addClass('badge badge-warning');
                                } else {
                                    badgeRezago.text(`Rezago del ${(100 - rezago).toFixed(2)}%`).removeClass().addClass('badge badge-danger');
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
        
        $(document).on('click', '.editar', function() {
            var AvanceId = $(this).data('id');
            var url = "{{ route('editaravaact', ['id' => ':id']) }}";
            url = url.replace(':id', AvanceId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data[0].id);
                    $('#id_ip1_editar').val(data[0].id_ip);
                    $('#id_dep1_editar').val(data[0].id_d);
                    var avance = parseFloat(data[0].avance_aa.replace(',', '.'));
                    $('#avance1_editar').val(avance);
                    $('#avance1_editar_oculto').val(avance);
                    var aporte = parseFloat(data[0].aporte_a.replace(',', '.'));
                    $('#programado1_editar').val(aporte);
                    $('#id_a1_editar').val(data[0].id_a);
                    $('#dependencia_editar').val(data[0].nombre_d);
                    $('#indicador_editar').val(data[0].codigo_ip);
                    $('#actividad_editar').val(data[0].codigo_a);
                    $('#anio_act_editar').val(data[0].anio);
                    $('#trim_act_editar').val(data[0].trimestre);
                    $('#desc_act_editar').val(data[0].logro_aa);
                    $('#estado').val(data[0].estado);
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
            var RezId = document.getElementById('rezago').value;
            var url = "{{ route('veractividades_anio1', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId + '_' + RezId);
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
                        var barra_avance = '';
                        var barra_periodo = '';
                        var barra_anio = '';
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
                        barra_avance = `<div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                style="width:` + item.porcentaje_avance + `%;" 
                                                aria-valuenow="` + item.porcentaje_avance + `" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>`;
                        barra_periodo = `<div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                style="width:` + item.porcentaje_periodo + `%;" 
                                                aria-valuenow="` + item.porcentaje_periodo + `" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>`;
                        barra_anio =    `<div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                style="width:` + item.porcentaje_anio + `%;" 
                                                aria-valuenow="` + item.porcentaje_anio + `" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>`;
                        // Agregar los datos a la tabla
                        table.row.add([
                            item.id, // Id
                            item.codigo_a, // Código
                            item.nombre_a, // Nombre de la actividad
                            item.anio_a + '_' + item.trimestre_a, // Periodo
                            `<div class="text-center">` + item.porcentaje_avance + ' %' + barra_avance + getBadgePorcentajeAvance(item.porcentaje_avance) + `</div>`, // Porcentaje y progreso del trimestre
                            `<div class="text-center">` + item.porcentaje_periodo + ' %' + barra_periodo + `</div>`, // Porcentaje y progreso del periodo
                            `<div class="text-center">` + item.porcentaje_anio + ' %' + barra_anio + `</div>`, // Porcentaje y progreso del año
                            `<b class="badge ${estadoClass}">${estadoText}</b>`, // Estado
                            botones // Botones dinámicos según `avance`
                        ]);
                    });
                    table.draw();
                    // Actualizar la alerta de aviso de avance de actividades
                    var alertaHtml = `
                        <div class="alert ${faltan === 0 ? 'alert-success' : 'alert-danger'} alert-dismissible fade show text-center h4" role="alert" id="filtro_actividades">
                            <strong id="control_faltan">De un total de ${total} actividades, faltan por registrar ${faltan}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `;

                    // Reemplazar el contenido de la alerta en el DOM
                    $('#alerta_actividades').html(alertaHtml);
                    setTimeout(function() {
                        $("#filtro_actividades").alert('close');
                    }, 5000); // 5000 milisegundos = 5 segundos
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
            var RezId = document.getElementById('rezago').value;
            var url = "{{ route('veractividades_anio1', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId + '_' + RezId);
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
                        var barra_avance = '';
                        var barra_periodo = '';
                        var barra_anio = '';
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
                        barra_avance = `<div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                style="width:` + item.porcentaje_avance + `%;" 
                                                aria-valuenow="` + item.porcentaje_avance + `" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>`;
                        barra_periodo = `<div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                style="width:` + item.porcentaje_periodo + `%;" 
                                                aria-valuenow="` + item.porcentaje_periodo + `" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>`;
                        barra_anio =    `<div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                style="width:` + item.porcentaje_anio + `%;" 
                                                aria-valuenow="` + item.porcentaje_anio + `" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>`;
                        
                        // Agregar los datos a la tabla
                        table.row.add([
                            item.id, // Id
                            item.codigo_a, // Código
                            item.nombre_a, // Nombre de la actividad
                            item.anio_a + '_' + item.trimestre_a, // Periodo
                            `<div class="text-center">` + item.porcentaje_avance + ' %' + barra_avance + getBadgePorcentajeAvance(item.porcentaje_avance) + `</div>`, // Porcentaje y progreso del trimestre
                            `<div class="text-center">` + item.porcentaje_periodo + ' %' + barra_periodo + `</div>`, // Porcentaje y progreso del periodo
                            `<div class="text-center">` + item.porcentaje_anio + ' %' + barra_anio + `</div>`, // Porcentaje y progreso del año
                            `<b class="badge ${estadoClass}">${estadoText}</b>`, // Estado
                            botones // Botones dinámicos según `avance`
                        ]);
                    });
                    table.draw();
                    // Actualizar la alerta de aviso de avance de actividades
                    var alertaHtml = `
                        <div class="alert ${faltan === 0 ? 'alert-success' : 'alert-danger'} alert-dismissible fade show text-center h4" role="alert" id="filtro_actividades">
                            <strong id="control_faltan">De un total de ${total} actividades, faltan por registrar ${faltan}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `;

                    // Reemplazar el contenido de la alerta en el DOM
                    $('#alerta_actividades').html(alertaHtml);
                    setTimeout(function() {
                        $("#filtro_actividades").alert('close');
                    }, 5000); // 5000 milisegundos = 5 segundos
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });

        function getBadgePorcentajeAvance(porcentaje) {
            if (porcentaje >= 0 && porcentaje < 40) {
                return `<b class="badge bg-danger"><span>Crítico</span></b>`;
            } else if (porcentaje >= 40 && porcentaje <= 60) {
                return `<b class="badge" style="background-color: orange; color: white;"><span>Bajo</span></b>`;
            } else if (porcentaje > 60 && porcentaje <= 70) {
                return `<b class="badge bg-warning"><span>Medio</span></b>`;
            } else if (porcentaje > 70 && porcentaje <= 80) {
                return `<b class="badge bg-success"><span>Satisfactorio</span></b>`;
            } else if (porcentaje > 80 && porcentaje <= 100) {
                return `<b class="badge bg-primary"><span>Sobresaliente</span></b>`;
            } else {
                return `<b class="badge" style="background-color: #6f42c1; color: white;"><span>Sobrejecutado</span></b>`;
            }
        }

        $('#rezago').on('change', function () {
            var AnioId = document.getElementById('id_anio_act').value;
            var IndId = document.getElementById('id_ip').value;
            var TriId = document.getElementById('id_trimestre_act').value;
            var RezId = $(this).val();
            var url = "{{ route('veractividades_anio1', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId + '_' + RezId);
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
                        var barra_avance = '';
                        var barra_periodo = '';
                        var barra_anio = '';
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
                        barra_avance = `<div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                style="width:` + item.porcentaje_avance + `%;" 
                                                aria-valuenow="` + item.porcentaje_avance + `" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>`;
                        barra_periodo = `<div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                style="width:` + item.porcentaje_periodo + `%;" 
                                                aria-valuenow="` + item.porcentaje_periodo + `" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>`;
                        barra_anio =    `<div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                style="width:` + item.porcentaje_anio + `%;" 
                                                aria-valuenow="` + item.porcentaje_anio + `" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>`;
                        // Agregar los datos a la tabla
                        table.row.add([
                            item.id, // Id
                            item.codigo_a, // Código
                            item.nombre_a, // Nombre de la actividad
                            item.anio_a + '_' + item.trimestre_a, // Periodo
                            `<div class="text-center">` + item.porcentaje_avance + ' %' + barra_avance + getBadgePorcentajeAvance(item.porcentaje_avance) + `</div>`, // Porcentaje y progreso del trimestre
                            `<div class="text-center">` + item.porcentaje_periodo + ' %' + barra_periodo + `</div>`, // Porcentaje y progreso del periodo
                            `<div class="text-center">` + item.porcentaje_anio + ' %' + barra_anio + `</div>`, // Porcentaje y progreso del año
                            `<b class="badge ${estadoClass}">${estadoText}</b>`, // Estado
                            botones // Botones dinámicos según `avance`
                        ]);
                    });
                    table.draw();
                    // Actualizar la alerta de aviso de avance de actividades
                    var alertaHtml = `
                        <div class="alert ${faltan === 0 ? 'alert-success' : 'alert-danger'} alert-dismissible fade show text-center h4" role="alert" id="filtro_actividades">
                            <strong id="control_faltan">De un total de ${total} actividades, faltan por registrar ${faltan}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `;

                    // Reemplazar el contenido de la alerta en el DOM
                    $('#alerta_actividades').html(alertaHtml);
                    setTimeout(function() {
                        $("#filtro_actividades").alert('close');
                    }, 5000); // 5000 milisegundos = 5 segundos
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
                    $('#indicador').val(data[0].producto.codigo_ip).attr('title', data[0].producto.nombre_ip);
                    $('#actividad').val(data[0].codigo_a).attr('title', data[0].nombre_a);
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

        $(document).on('click', '.ver_ip', function() {
            var AvaIdId = $(this).data('id');
            var url = "{{ route('veravaest', ['id' => ':id']) }}";
            url = url.replace(':id', AvaIdId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#tab-2024_consulta').tab('show');
                    $('#cod_ip').text(data.codigo_ip + '. ' + data.nombre_ip); 
                    if (data.indproducto2[0].total_2024_3 != "No programado") {
                        $('#avance_2024_3').text(data.indproducto2[0].total_2024_3);
                        $('#programado_2024_3').text(data.indproducto2[0].p2024_3);
                    }
                    else {
                        $('#avance_2024_3').text("No programado");
                        $('#programado_2024_3').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2024_3 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2024_3 > 100) {
                            $('#porcentaje_avance_2024_3').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2024_3').text(data.indproducto2[0].porcentaje_2024_3 + ' %');
                        }
                        $('#p_avance_2024_3').text(data.indproducto2[0].porcentaje_2024_3);
                        $('#por_avance_2024_3').text(data.indproducto2[0].porcentaje_2024_3);
                        $('#progress_2024_3 .progress-bar').css('width', data.indproducto2[0].porcentaje_2024_3 + '%');  // Cambiar el ancho
                        $('#progress_2024_3').show();
                    }
                    else {
                        $('#porcentaje_avance_2024_3').text("No programado");
                        $('#progress_2024_3').hide();
                    }
                    if (data.indproducto2[0].total_2024_4 != "No programado") {
                        $('#avance_2024_4').text(data.indproducto2[0].total_2024_4);
                        $('#programado_2024_4').text(data.indproducto2[0].p2024_4);
                    }
                    else {
                        $('#avance_2024_4').text("No programado");
                        $('#programado_2024_4').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2024_4 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2024_4 > 100) {
                            $('#porcentaje_avance_2024_4').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2024_4').text(data.indproducto2[0].porcentaje_2024_4 + ' %');
                        }
                        $('#p_avance_2024_4').text(data.indproducto2[0].porcentaje_2024_4);
                        $('#por_avance_2024_4').text(data.indproducto2[0].porcentaje_2024_4);
                        $('#progress_2024_4 .progress-bar').css('width', data.indproducto2[0].porcentaje_2024_4 + '%');  // Cambiar el ancho
                        $('#progress_2024_4').show();
                    }
                    else {
                        $('#porcentaje_avance_2024_4').text("No programado");
                        $('#progress_2024_4').hide();
                    }
                    if (data.indproducto2[0].total_2024 === "No programado" && data.indproducto2[0].total_2024_4 === "No programado") {
                        $('#avance_2024').text("No programado");
                        $('#programado_2024').text("No programado");
                    }
                    else {
                        $('#avance_2024').text(data.indproducto2[0].total_2024);
                        $('#programado_2024').text(data.indproducto2[0].p2024);
                    }
                    if (data.indproducto2[0].porcentaje_2024 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2024 > 100) {
                            $('#porcentaje_2024').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2024').text(data.indproducto2[0].porcentaje_2024 + ' %');
                        }
                        $('#p_avance_2024').text(data.indproducto2[0].porcentaje_2024);
                        $('#por_avance_2024').text(data.indproducto2[0].porcentaje_2024);
                        $('#progress_2024 .progress-bar').css('width', data.indproducto2[0].porcentaje_2024 + '%');  // Cambiar el ancho
                        $('#progress_2024').show();
                    }
                    else {
                        $('#porcentaje_2024').text("No programado");
                        $('#progress_2024').hide();
                    }
                    if (data.indproducto2[0].total_2025_1 != "No programado") {
                        $('#avance_2025_1').text(data.indproducto2[0].total_2025_1);
                        $('#programado_2025_1').text(data.indproducto2[0].p2025_1);
                    }
                    else {
                        $('#avance_2025_1').text("No programado");
                        $('#programado_2025_1').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2025_1 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2025_1 > 100) {
                            $('#porcentaje_avance_2025_1').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2025_1').text(data.indproducto2[0].porcentaje_2025_1 + ' %');
                        }
                        $('#p_avance_2025_1').text(data.indproducto2[0].porcentaje_2025_1);
                        $('#por_avance_2025_1').text(data.indproducto2[0].porcentaje_2025_1);
                        $('#progress_2025_1 .progress-bar').css('width', data.indproducto2[0].porcentaje_2025_1 + '%');  // Cambiar el ancho
                        $('#progress_2025_1').show();
                    }
                    else {
                        $('#porcentaje_avance_2025_1').text("No programado");
                        $('#progress_2025_1').hide();
                    }
                    if (data.indproducto2[0].total_2025_2 != "No programado") {
                        $('#avance_2025_2').text(data.indproducto2[0].total_2025_2);
                        $('#programado_2025_2').text(data.indproducto2[0].p2025_2);
                    }
                    else {
                        $('#avance_2025_2').text("No programado");
                        $('#programado_2025_2').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2025_2 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2025_2 > 100) {
                            $('#porcentaje_avance_2025_2').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2025_2').text(data.indproducto2[0].porcentaje_2025_2 + ' %');
                        }
                        $('#p_avance_2025_2').text(data.indproducto2[0].porcentaje_2025_2);
                        $('#por_avance_2025_2').text(data.indproducto2[0].porcentaje_2025_2);
                        $('#progress_2025_2 .progress-bar').css('width', data.indproducto2[0].porcentaje_2025_2 + '%');  // Cambiar el ancho
                        $('#progress_2025_2').show();
                    }
                    else {
                        $('#porcentaje_avance_2025_2').text("No programado");
                        $('#progress_2025_2').hide();
                    }
                    if (data.indproducto2[0].total_2025_3 != "No programado") {
                        $('#avance_2025_3').text(data.indproducto2[0].total_2025_3);
                        $('#programado_2025_3').text(data.indproducto2[0].p2025_3);
                    }
                    else {
                        $('#avance_2025_3').text("No programado");
                        $('#programado_2025_3').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2025_3 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2025_3 > 100) {
                            $('#porcentaje_avance_2025_3').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2025_3').text(data.indproducto2[0].porcentaje_2025_3 + ' %');
                        }
                        $('#p_avance_2025_3').text(data.indproducto2[0].porcentaje_2025_3);
                        $('#por_avance_2025_3').text(data.indproducto2[0].porcentaje_2025_3);
                        $('#progress_2025_3 .progress-bar').css('width', data.indproducto2[0].porcentaje_2025_3 + '%');  // Cambiar el ancho
                        $('#progress_2025_3').show();
                    }
                    else {
                        $('#porcentaje_avance_2025_3').text("No programado");
                        $('#progress_2025_3').hide();
                    }
                    if (data.indproducto2[0].total_2025_4 != "No programado") {
                        $('#avance_2025_4').text(data.indproducto2[0].total_2025_4);
                        $('#programado_2025_4').text(data.indproducto2[0].p2025_4);
                    }
                    else {
                        $('#avance_2025_4').text("No programado");
                        $('#programado_2025_4').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2025_4 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2025_4 > 100) {
                            $('#porcentaje_avance_2025_4').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2025_4').text(data.indproducto2[0].porcentaje_2025_4 + ' %');
                        }
                        $('#p_avance_2025_4').text(data.indproducto2[0].porcentaje_2025_4);
                        $('#por_avance_2025_4').text(data.indproducto2[0].porcentaje_2025_4);
                        $('#progress_2025_4 .progress-bar').css('width', data.indproducto2[0].porcentaje_2025_4 + '%');  // Cambiar el ancho
                        $('#progress_2025_4').show();
                    }
                    else {
                        $('#porcentaje_avance_2025_4').text("No programado");
                        $('#progress_2025_4').hide();
                    }
                    if (data.indproducto2[0].total_2025_1 === "No programado" && data.indproducto2[0].total_2025_2 === "No programado" && data.indproducto2[0].total_2025_3 === "No programado" && data.indproducto2[0].total_2025_4 === "No programado") {
                        $('#avance_2025').text("No programado");
                        $('#programado_2025').text("No programado");
                    }
                    else {
                        $('#avance_2025').text(data.indproducto2[0].total_2025);
                        $('#programado_2025').text(data.indproducto2[0].p2025);
                    }
                    if (data.indproducto2[0].porcentaje_2025 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2025 > 100) {
                            $('#porcentaje_2025').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_2025').text(data.indproducto2[0].porcentaje_2025 + ' %');
                        }
                        $('#p_avance_2025').text(data.indproducto2[0].porcentaje_2025);
                        $('#por_avance_2025').text(data.indproducto2[0].porcentaje_2025);
                        $('#progress_2025 .progress-bar').css('width', data.indproducto2[0].porcentaje_2025 + '%');  // Cambiar el ancho
                        $('#progress_2025').show();
                    }
                    else {
                        $('#porcentaje_avance_2025').text("No programado");
                        $('#progress_2025').hide();
                    }
                    if (data.indproducto2[0].total_2026_1 != "No programado") {
                        $('#avance_2026_1').text(data.indproducto2[0].total_2026_1);
                        $('#programado_2026_1').text(data.indproducto2[0].p2026_1);
                    }
                    else {
                        $('#avance_2026_1').text("No programado");
                        $('#programado_2026_1').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2026_1 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2026_1 > 100) {
                            $('#porcentaje_avance_2026_1').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2026_1').text(data.indproducto2[0].porcentaje_2026_1 + ' %');
                        }
                        $('#p_avance_2026_1').text(data.indproducto2[0].porcentaje_2026_1);
                        $('#por_avance_2026_1').text(data.indproducto2[0].porcentaje_2026_1);
                        $('#progress_2026_1 .progress-bar').css('width', data.indproducto2[0].porcentaje_2026_1 + '%');  // Cambiar el ancho
                        $('#progress_2026_1').show();
                    }
                    else {
                        $('#porcentaje_avance_2026_1').text("No programado");
                        $('#progress_2026_1').hide();
                    }
                    if (data.indproducto2[0].total_2026_2 != "No programado") {
                        $('#avance_2026_2').text(data.indproducto2[0].total_2026_2);
                        $('#programado_2026_2').text(data.indproducto2[0].p2026_2);
                    }
                    else {
                        $('#avance_2026_2').text("No programado");
                        $('#programado_2026_2').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2026_2 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2026_2 > 100) {
                            $('#porcentaje_avance_2026_2').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2026_2').text(data.indproducto2[0].porcentaje_2026_2 + ' %');
                        }
                        $('#p_avance_2026_2').text(data.indproducto2[0].porcentaje_2026_2);
                        $('#por_avance_2026_2').text(data.indproducto2[0].porcentaje_2026_2);
                        $('#progress_2026_2 .progress-bar').css('width', data.indproducto2[0].porcentaje_2026_2 + '%');  // Cambiar el ancho
                        $('#progress_2026_2').show();
                    }
                    else {
                        $('#porcentaje_avance_2026_2').text("No programado");
                        $('#progress_2026_2').hide();
                    }
                    if (data.indproducto2[0].total_2026_3 != "No programado") {
                        $('#avance_2026_3').text(data.indproducto2[0].total_2026_3);
                        $('#programado_2026_3').text(data.indproducto2[0].p2026_3);
                    }
                    else {
                        $('#avance_2026_3').text("No programado");
                        $('#programado_2026_3').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2026_3 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2026_3 > 100) {
                            $('#porcentaje_avance_2026_3').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2026_3').text(data.indproducto2[0].porcentaje_2026_3 + ' %');
                        }
                        $('#p_avance_2026_3').text(data.indproducto2[0].porcentaje_2026_3);
                        $('#por_avance_2026_3').text(data.indproducto2[0].porcentaje_2026_3);
                        $('#progress_2026_3 .progress-bar').css('width', data.indproducto2[0].porcentaje_2026_3 + '%');  // Cambiar el ancho
                        $('#progress_2026_3').show();
                    }
                    else {
                        $('#porcentaje_avance_2026_3').text("No programado");
                        $('#progress_2026_3').hide();
                    }
                    if (data.indproducto2[0].total_2026_4 != "No programado") {
                        $('#avance_2026_4').text(data.indproducto2[0].total_2026_4);
                        $('#programado_2026_4').text(data.indproducto2[0].p2026_4);
                    }
                    else {
                        $('#avance_2026_4').text("No programado");
                        $('#programado_2026_4').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2026_4 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2026_4 > 100) {
                            $('#porcentaje_avance_2026_4').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2026_4').text(data.indproducto2[0].porcentaje_2026_4 + ' %');
                        }
                        $('#p_avance_2026_4').text(data.indproducto2[0].porcentaje_2026_4);
                        $('#por_avance_2026_4').text(data.indproducto2[0].porcentaje_2026_4);
                        $('#progress_2026_4 .progress-bar').css('width', data.indproducto2[0].porcentaje_2026_4 + '%');  // Cambiar el ancho
                        $('#progress_2026_4').show();
                    }
                    else {
                        $('#porcentaje_avance_2026_4').text("No programado");
                        $('#progress_2026_4').hide();
                    }
                    if (data.indproducto2[0].total_2026_1 === "No programado" && data.indproducto2[0].total_2026_2 === "No programado" && data.indproducto2[0].total_2026_3 === "No programado" && data.indproducto2[0].total_2026_4 === "No programado") {
                        $('#avance_2026').text("No programado");
                        $('#programado_2026').text("No programado");
                    }
                    else {
                        $('#avance_2026').text(data.indproducto2[0].total_2026);
                        $('#programado_2026').text(data.indproducto2[0].p2026);
                    }
                    if (data.indproducto2[0].porcentaje_2026 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2026 > 100) {
                            $('#porcentaje_2026').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_2026').text(data.indproducto2[0].porcentaje_2026 + ' %');
                        }
                        $('#p_avance_2026').text(data.indproducto2[0].porcentaje_2026);
                        $('#por_avance_2026').text(data.indproducto2[0].porcentaje_2026);
                        $('#progress_2026 .progress-bar').css('width', data.indproducto2[0].porcentaje_2026 + '%');  // Cambiar el ancho
                        $('#progress_2026').show();
                    }
                    else {
                        $('#porcentaje_2026').text("No programado");
                        $('#progress_2026').hide();
                    }
                    if (data.indproducto2[0].total_2027_1 != "No programado") {
                        $('#avance_2027_1').text(data.indproducto2[0].total_2027_1);
                        $('#programado_2027_1').text(data.indproducto2[0].p2027_1);
                    }
                    else {
                        $('#avance_2027_1').text("No programado");
                        $('#programado_2027_1').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2027_1 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2027_1 > 100) {
                            $('#porcentaje_avance_2027_1').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2027_1').text(data.indproducto2[0].porcentaje_2027_1 + ' %');
                        }
                        $('#p_avance_2027_1').text(data.indproducto2[0].porcentaje_2027_1);
                        $('#por_avance_2027_1').text(data.indproducto2[0].porcentaje_2027_1);
                        $('#progress_2027_1 .progress-bar').css('width', data.indproducto2[0].porcentaje_2027_1 + '%');  // Cambiar el ancho
                        $('#progress_2027_1').show();
                    }
                    else {
                        $('#porcentaje_avance_2027_1').text("No programado");
                        $('#progress_2027_1').hide();
                    }
                    if (data.indproducto2[0].total_2027_2 != "No programado") {
                        $('#avance_2027_2').text(data.indproducto2[0].total_2027_2);
                        $('#programado_2027_2').text(data.indproducto2[0].p2027_2);
                    }
                    else {
                        $('#avance_2027_2').text("No programado");
                        $('#programado_2027_2').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2027_2 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2027_2 > 100) {
                            $('#porcentaje_avance_2027_2').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2027_2').text(data.indproducto2[0].porcentaje_2027_2 + ' %');
                        }
                        $('#p_avance_2027_2').text(data.indproducto2[0].porcentaje_2027_2);
                        $('#por_avance_2027_2').text(data.indproducto2[0].porcentaje_2027_2);
                        $('#progress_2027_2 .progress-bar').css('width', data.indproducto2[0].porcentaje_2027_2 + '%');  // Cambiar el ancho
                        $('#progress_2027_2').show();
                    }
                    else {
                        $('#porcentaje_avance_2027_2').text("No programado");
                        $('#progress_2027_2').hide();
                    }
                    if (data.indproducto2[0].total_2027_3 != "No programado") {
                        $('#avance_2027_3').text(data.indproducto2[0].total_2027_3);
                        $('#programado_2027_3').text(data.indproducto2[0].p2027_3);
                    }
                    else {
                        $('#avance_2027_3').text("No programado");
                        $('#programado_2027_3').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2027_3 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2027_3 > 100) {
                            $('#porcentaje_avance_2027_3').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2027_3').text(data.indproducto2[0].porcentaje_2027_3 + ' %');
                        }
                        $('#p_avance_2027_3').text(data.indproducto2[0].porcentaje_2027_3);
                        $('#por_avance_2027_3').text(data.indproducto2[0].porcentaje_2027_3);
                        $('#progress_2027_3 .progress-bar').css('width', data.indproducto2[0].porcentaje_2027_3 + '%');  // Cambiar el ancho
                        $('#progress_2027_3').show();
                    }
                    else {
                        $('#porcentaje_avance_2027_3').text("No programado");
                        $('#progress_2027_3').hide();
                    }
                    if (data.indproducto2[0].total_2027_4 != "No programado") {
                        $('#avance_2027_4').text(data.indproducto2[0].total_2027_4);
                        $('#programado_2027_4').text(data.indproducto2[0].p2027_4);
                    }
                    else {
                        $('#avance_2027_4').text("No programado");
                        $('#programado_2027_4').text("No programado");
                    }
                    if (data.indproducto2[0].porcentaje_2027_4 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2027_4 > 100) {
                            $('#porcentaje_avance_2027_4').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_avance_2027_4').text(data.indproducto2[0].porcentaje_2027_4 + ' %');
                        }
                        $('#p_avance_2027_4').text(data.indproducto2[0].porcentaje_2027_4);
                        $('#por_avance_2027_4').text(data.indproducto2[0].porcentaje_2027_4);
                        $('#progress_2027_4 .progress-bar').css('width', data.indproducto2[0].porcentaje_2027_4 + '%');  // Cambiar el ancho
                        $('#progress_2027_4').show();
                    }
                    else {
                        $('#porcentaje_avance_2027_4').text("No programado");
                        $('#progress_2027_4').hide();
                    }
                    if (data.indproducto2[0].total_2027_1 === "No programado" && data.indproducto2[0].total_2027_2 === "No programado" && data.indproducto2[0].total_2027_3 === "No programado" && data.indproducto2[0].total_2027_4 === "No programado") {
                        $('#avance_2027').text("No programado");
                        $('#programado_2027').text("No programado");
                    }
                    else {
                        $('#avance_2027').text(data.indproducto2[0].total_2027);
                        $('#programado_2027').text(data.indproducto2[0].p2027);
                    }
                    if (data.indproducto2[0].porcentaje_2027 != "No programado") {
                        if (data.indproducto2[0].porcentaje_2027 > 100) {
                            $('#porcentaje_2027').text('100.00 %');    
                        }
                        else {
                            $('#porcentaje_2027').text(data.indproducto2[0].porcentaje_2027 + ' %');
                        }
                        $('#p_avance_2027').text(data.indproducto2[0].porcentaje_2027);
                        $('#por_avance_2027').text(data.indproducto2[0].porcentaje_2027);
                        $('#progress_2027 .progress-bar').css('width', data.indproducto2[0].porcentaje_2027 + '%');  // Cambiar el ancho
                        $('#progress_2027').show();
                    }
                    else {
                        $('#porcentaje_2027').text("No programado");
                        $('#progress_2027').hide();
                    }
                    var archivos = {
                        "2024": '',
                        "2025": '',
                        "2026": '',
                        "2027": ''
                    };

                    var nombreArchivo, nombreFinal;

                    data.evidencias.forEach(function(evi) {
                        let anio_evi = evi.anio_eip.toString();   // Asegura que sea string

                        nombreArchivo = evi.evidencia.split('/').pop();
                        nombreFinal = nombreArchivo.replace(/^.*?_.*?_.*?_.*?_.*?_(.*?)$/, '$1');

                        let fila = `<tr>
                                        <td class='text-center'><a href="../../storage/` + evi.evidencia + `" target="_blank">${nombreFinal}</a></td>
                                        <td class='text-center'>` + (nombreFinal.endsWith('pdf') ? "<i class='fas fa-file-pdf text-danger h4'></i>" : "<i class='fas fa-file-image text-primary h4'></i>") + `</td>
                                        <td class='text-center'>` + evi.anio_eip + '_' + evi.trimestre_eip + `</td>
                                        <td class='text-center'><b class='badge bg-` + (evi.estado_e == 'Activo' ? 'success' : 'danger') + `'>` + evi.estado_e + `</b></td>
                                    </tr>`;

                        if (archivos.hasOwnProperty(anio_evi)) {
                            archivos[anio_evi] += fila;
                        }
                    });

                    // Insertar filas
                    $('#evidencias_ip_2024').html(archivos["2024"]);
                    $('#evidencias_ip_2025').html(archivos["2025"]);
                    $('#evidencias_ip_2026').html(archivos["2026"]);
                    $('#evidencias_ip_2027').html(archivos["2027"]);
                    // Destruyes DataTable si ya estaba inicializado
                    if ($.fn.DataTable.isDataTable('#tabla_logros_2024')) {
                        $('#tabla_logros_2024').DataTable().destroy();
                    }
                    if ($.fn.DataTable.isDataTable('#tabla_logros_2025')) {
                        $('#tabla_logros_2025').DataTable().destroy();
                    }
                    if ($.fn.DataTable.isDataTable('#tabla_logros_2026')) {
                        $('#tabla_logros_2026').DataTable().destroy();
                    }
                    if ($.fn.DataTable.isDataTable('#tabla_logros_2027')) {
                        $('#tabla_logros_2027').DataTable().destroy();
                    }
                    if ($.fn.DataTable.isDataTable('#ver_evi_ip_2024')) {
                        $('#ver_evi_ip_2024').DataTable().destroy();
                    }
                    if ($.fn.DataTable.isDataTable('#ver_evi_ip_2025')) {
                        $('#ver_evi_ip_2025').DataTable().destroy();
                    }
                    if ($.fn.DataTable.isDataTable('#ver_evi_ip_2026')) {
                        $('#ver_evi_ip_2026').DataTable().destroy();
                    }
                    if ($.fn.DataTable.isDataTable('#ver_evi_ip_2027')) {
                        $('#ver_evi_ip_2027').DataTable().destroy();
                    }

                    // Vuelves a inicializar DataTable
                    $('#ver_evi_ip_2024, #ver_evi_ip_2025, #ver_evi_ip_2026, #ver_evi_ip_2027').DataTable({
                        paging: false,
                        searching: false,
                        ordering: true,
                        pagingType: 'full_numbers',
                        language: {
                            paginate: {
                                first: '<<',
                                previous: '<',
                                next: '>',
                                last: '>>'
                            },
                            url: "/plugins/datatables/idioma.json",
                        },
                        columnDefs: [
                            { className: "text-center", orderable: false, targets: "_all" }
                        ]
                    });

                    $('#tabla_logros_2024, #tabla_logros_2025, #tabla_logros_2026, #tabla_logros_2027').DataTable({
                        paging: false,
                        searching: false,
                        ordering: true,
                        pagingType: 'full_numbers',
                        language: {
                            paginate: {
                                first: '<<',
                                previous: '<',
                                next: '>',
                                last: '>>'
                            },
                            url: "/plugins/datatables/idioma.json",
                        },
                        columnDefs: [
                            { orderable: false }
                        ]
                    });

                    // Limpiar los tbody antes de agregar nuevos logros (opcional, si quieres resetear)
                    ['2024', '2025', '2026', '2027'].forEach(anio => {
                        const tbody = document.getElementById(`tbody-logros_${anio}_ip`);
                        if (tbody) tbody.innerHTML = '';
                    });

                    // Iterar por cada año en logros
                    for (const anio in data.logros) {
                        if (data.logros.hasOwnProperty(anio)) {
                            const tbody = document.getElementById(`tbody-logros_${anio}_ip`);
                            if (!tbody) continue;

                            data.logros[anio].forEach(logro => {
                                // Crear fila
                                const tr = document.createElement('tr');

                                // Crear columnas y asignar valores según lo que quieres mostrar
                                // Por ejemplo: logro, trimestre_lip
                                const tdLogro = document.createElement('td');
                                tdLogro.textContent = logro.logro;

                                const tdPeriodo = document.createElement('td');
                                tdPeriodo.textContent = logro.anio_lip + '_' + logro.trimestre_lip;
                                tdPeriodo.className = 'text-center';

                                // Agregar las columnas a la fila
                                tr.appendChild(tdPeriodo);
                                tr.appendChild(tdLogro);
                                
                                // Agregar fila al tbody correspondiente
                                tbody.appendChild(tr);
                            });
                        }
                    }
                    
                    $('#verestado_ip').text(data.estado_ip).removeClass().addClass('badge').addClass(data.estado_ip === 'Activo' ? 'bg-success' : 'bg-danger');
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
                    $('#vercreado_ip').text(fecharegistro);
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
                    $('#veractualizado_ip').text(fechaactualizado);
                    $('#veravanceipmodal').show();
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
            $('#verperiodo1').text('');
            $('#veranio').text('');
            $('#verprog').text('');
            $('#veravance').text('');
            $('#verrezago').text('').removeClass();
            $('#verporcanio').text('');
            $('#verporcavance').text('');
            $('#verdesempenio').text('').removeClass();
            $('#verjust_act').text('');
            $('#verestado').text('').removeClass();
            $('#vercreado').text('');
            $('#veractualizado').text('');
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#verindicador').text(data[0].codigo_ip + '. ' + data[0].nombre_ip);
                    $('#verdependencia').text(data[0].nombre_d);
                    $('#veractividad').text(data[0].codigo_a + '. ' + data[0].nombre_a);
                    $('#verperiodo').text(data[0].anio + '_' + data[0].trimestre);
                    $('#verperiodo1').text(data[0].anio + '_' + data[0].trimestre);
                    $('#veranio').text(data[0].anio);
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
                            $('#verrezago').text('Rezago del ' + (rezago * 100 - 100).toFixed(2) + '%').removeClass().addClass('badge badge-warning');
                        }
                        else {
                            if (rezago < 1) {
                                $('#verrezago').text('Rezago del ' + (100 - (rezago * 100)).toFixed(2) + '%').removeClass().addClass('badge badge-danger');
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
                    $('#verporcavance').text(data[0].porcentaje_avance + '%');
                    $('#verporcperiodo').text(data[0].porcentaje_periodo + '%');
                    $('#verporcanio').text(data[0].porcentaje_anio + '%');
                    $('#verjust_act').text(data[0].logro);
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

        $('#logro_ip').on('input', function () {
            var el = this;
            var val = el.value;

            // Guarda posición del cursor
            var start = el.selectionStart;
            var end = el.selectionEnd;

            // Reemplaza múltiples espacios por uno solo
            var newVal = val.replace(/\s+/g, ' ');

            if (newVal !== val) {
                // Si cambió, actualiza el valor
                el.value = newVal;

                // Ajusta la posición del cursor para que no se mueva hacia atrás al eliminar espacios extra
                var diff = val.length - newVal.length;
                var newPos = start - diff;
                if (newPos < 0) newPos = 0;

                el.setSelectionRange(newPos, newPos);
            }

            // Actualiza contador
            $('#max_logro_ip').text(el.value.length).removeClass('badge bg-success bg-danger');

            if (el.value.length >= 500) {
                $('#envia_logro').prop('disabled', false);
                $('#max_logro_ip').addClass('badge bg-success');
            } else {
                $('#envia_logro').prop('disabled', true);
                $('#max_logro_ip').addClass('badge bg-danger');
            }
        });

        $('#logro_ip_editar').on('input', function () {
            var el = this;
            var val = el.value;

            // Guarda posición del cursor
            var start = el.selectionStart;
            var end = el.selectionEnd;

            // Reemplaza múltiples espacios por uno solo
            var newVal = val.replace(/\s+/g, ' ');

            if (newVal !== val) {
                // Si cambió, actualiza el valor
                el.value = newVal;

                // Ajusta la posición del cursor para que no se mueva hacia atrás al eliminar espacios extra
                var diff = val.length - newVal.length;
                var newPos = start - diff;
                if (newPos < 0) newPos = 0;

                el.setSelectionRange(newPos, newPos);
            }

            // Actualiza contador
            $('#max_logro_ip_editar').text(el.value.length).removeClass('badge bg-success bg-danger');

            if (el.value.length >= 500) {
                $('#envia_logro_editar').prop('disabled', false);
                $('#max_logro_ip_editar').addClass('badge bg-success');
            } else {
                $('#envia_logro_editar').prop('disabled', true);
                $('#max_logro_ip_editar').addClass('badge bg-danger');
            }
        });

        $('#desc_act').on('input', function () {
            alert(0)
            var el = this;
            var val = el.value;

            // Guarda posición del cursor
            var start = el.selectionStart;
            var end = el.selectionEnd;

            // Reemplaza múltiples espacios por uno solo
            var newVal = val.replace(/\s+/g, ' ');

            if (newVal !== val) {
                // Si cambió, actualiza el valor
                el.value = newVal;

                // Ajusta la posición del cursor para que no se mueva hacia atrás al eliminar espacios extra
                var diff = val.length - newVal.length;
                var newPos = start - diff;
                if (newPos < 0) newPos = 0;

                el.setSelectionRange(newPos, newPos);
            }

            // Actualiza contador
            $('#max_logro_act').text(el.value.length).removeClass('badge bg-success bg-danger');

            if (el.value.length >= 500) {
                $('#envia_act').prop('disabled', false);
                $('#max_logro_act').addClass('badge bg-success');
            } else {
                $('#envia_act').prop('disabled', true);
                $('#max_logro_act').addClass('badge bg-danger');
            }
        });

        $('#desc_act_editar').on('input', function () {
            var el = this;
            var val = el.value;

            // Guarda posición del cursor
            var start = el.selectionStart;
            var end = el.selectionEnd;

            // Reemplaza múltiples espacios por uno solo
            var newVal = val.replace(/\s+/g, ' ');

            if (newVal !== val) {
                // Si cambió, actualiza el valor
                el.value = newVal;

                // Ajusta la posición del cursor para que no se mueva hacia atrás al eliminar espacios extra
                var diff = val.length - newVal.length;
                var newPos = start - diff;
                if (newPos < 0) newPos = 0;

                el.setSelectionRange(newPos, newPos);
            }

            // Actualiza contador
            $('#max_logro_act_editar').text(el.value.length).removeClass('badge bg-success bg-danger');

            if (el.value.length >= 500) {
                $('#envia_act_editar').prop('disabled', false);
                $('#max_logro_act_editar').addClass('badge bg-success');
            } else {
                $('#envia_act_editar').prop('disabled', true);
                $('#max_logro_act_editar').addClass('badge bg-danger');
            }
        });

        $('#agregaravancemodal').on('hidden.bs.modal', function () {
            $(this).find('input[type="text"], input[type="number"]').val('0'); // Limpiar textos y números
            $(this).find('.badge').text('').removeClass('bg-success bg-danger bg-warning'); // Limpiar spans con badge
        });

        $('#editaravancemodal').on('hidden.bs.modal', function () {
            $(this).find('input[type="text"], input[type="number"]').val('0'); // Limpiar textos y números
            $(this).find('.badge').text('').removeClass('bg-success bg-danger bg-warning'); // Limpiar spans con badge
        });

        $('#editaravancemodal').on('shown.bs.modal', function () {
            $('#desc_act_editar').trigger('input');
        });

        $('#id_anio_lip_editar, #id_trimestre_lip_editar').on('change', function () {
            const id_ip = document.getElementById('id_ip_e').value;
            const anio = document.getElementById('id_anio_lip_editar').value;
            
            const trimestre = document.getElementById('id_trimestre_lip_editar').value;
            
            const datos = `${id_ip}_${anio}_${trimestre}`;
            // Generar la URL correctamente
            const url = `{{ route('editarlogroip', ['id' => '__ID__']) }}`.replace('__ID__', datos);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    if (Array.isArray(data)) {
                        if (data != null) {
                            data.forEach(function(datos) {
                                $('#logro_ip_editar').val(datos.logro);
                                $('#logro_ip_editar').trigger('input');
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', status, error);
                }
            });
        });

        setTimeout(function() {
            $("#alerta_blade").alert('close');
        }, 5000); // 5000 milisegundos = 5 segundos
    </script>    
@endsection