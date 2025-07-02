@extends('Layouts.plantilla')

@section('titulo', 'Avances Financieros - Indicador')

@section('contenido')
    <div id="alerta_financieros"></div>
        @if ($faltan == 0)
            <div class="alert alert-success alert-dismissible fade show text-center h4" role="alert" id="alerta_blade">
                <strong id="control_faltan">No faltan avances por reportar</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @else
            <div class="alert alert-danger alert-dismissible fade show text-center h4" role="alert" id="alerta_blade">
                <strong id="control_faltan">De un total de {{ $total }} registros financieros, Faltan por reportar {{ $faltan }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>Avances Financieros
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregaravancemodal" title="nuevo avance">
                            <i class="fas fa-plus"></i>
                        </button>
                        <a href="{{ route('listaravafins') }}" class="btn btn-primary">
                            Volver a Indicadores
                        </a>
                    </h1>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Avances Financieros</li>
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
                                        <th class="text-center">Acciones</th>
                                        <th class="text-center">Dependencia Responsable</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    <tr class="text-center">
                                        <td id="ind" class="text-center"><input type="text" id="id_ip" hidden value="{{ $ip->id }}">{{ $ip->codigo_ip.'. '.$ip->nombre_ip }}</th>
                                        <td id="ind" class="text-center">
                                            <button type="button" class="ver_ip btn btn-sm btn-info" data-id="{{ $ip->id }}" data-toggle="modal" data-target="#veravanceipmodal" title="ver avance">
                                                <i class="fas fa-eye"></i>
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
                                <select name="id_anio" id="id_anio_avaf" class="form-control position-relative" style="top: -25px;" data-live-search="true">
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
                                <select name="id_trimestre" id="id_trimestre_avaf" class="form-control position-relative" style="top: -25px;" data-live-search="true">
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
                            <table class="table w-auto" style="table-layout: auto;" id="avafins">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th class="text-center" style="width: 12%;">Periodo</th>
                                        <th class="text-center" style="width: 30%;">% Periodo</th>
                                        <th class="text-center" style="width: 25%;">% Año</th>
                                        <th class="text-center" style="width: 20%;">Estado</th>
                                        <th class="text-center" style="width: 20%;">Opciones</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    @foreach ($ip->indproducto as $pro)
                                        @foreach ($pro->avancefin as $ava)
                                            <tr class="text-center" id="ava-row-{{ $ava->id ?? 'nuevo' }}">
                                                <td class="text-center align-middle">
                                                    {{ $ava->anio_af.'_'.$ava->trimestre_af }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    @if ($ava->porcentaje_periodo > '100.00')
                                                        {{ '100.00 %' }}
                                                    @else
                                                        {{ is_numeric($ava->porcentaje_periodo) ? $ava->porcentaje_periodo.' %' : $ava->porcentaje_periodo }}
                                                    @endif
                                                    <div class="progress" style="height: 10px;">
                                                        <div class="progress-bar bg-success" role="progressbar" 
                                                            style="width: {{ is_numeric($ava->porcentaje_periodo) ? $ava->porcentaje_periodo : 0 }}%;" 
                                                            aria-valuenow="{{ is_numeric($ava->porcentaje_periodo) ? $ava->porcentaje_periodo : 0 }}" 
                                                            aria-valuemin="0" 
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <b class="badge 
                                                        @if ($ava->desempenio_periodo == 'Crítico') bg-danger
                                                        @elseif ($ava->desempenio_periodo == 'Bajo') bg-orange
                                                        @elseif ($ava->desempenio_periodo == 'Medio') bg-warning
                                                        @elseif ($ava->desempenio_periodo == 'Satisfactorio') bg-success
                                                        @elseif ($ava->desempenio_periodo == 'Sobresaliente') bg-primary
                                                        @else" style="background-color: #6f42c1; color: white;
                                                        @endif
                                                    ">
                                                        <span>{{ $ava->desempenio_periodo }}</span>
                                                    </b>
                                                </td>
                                                <td class="text-center align-middle">
                                                    @if ($ava->porcentaje_anio > '100.00')
                                                        {{ '100.00 %' }}
                                                    @else
                                                        {{ is_numeric($ava->porcentaje_anio) ? $ava->porcentaje_anio.' %' : $ava->porcentaje_anio }}
                                                    @endif
                                                    <div class="progress" style="height: 10px;">
                                                        <div class="progress-bar bg-success" role="progressbar" 
                                                            style="width: {{ is_numeric($ava->porcentaje_anio) ? $ava->porcentaje_anio : 0 }}%;" 
                                                            aria-valuenow="{{ is_numeric($ava->porcentaje_anio) ? $ava->porcentaje_anio : 0 }}" 
                                                            aria-valuemin="0" 
                                                            aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    @if (!empty($ava->estado_af) && $ava->estado_af == 'Activo')
                                                        <b class="badge bg-success estado">{{ $ava->estado_af }}</b>
                                                    @elseif (!empty($ava->estado_af))
                                                        <b class="badge bg-danger">{{ $ava->estado_af }}</b>
                                                    @else
                                                        <b class="badge bg-secondary">Sin avance</b>
                                                    @endif
                                                </td>

                                                @php
                                                    $est = (!empty($ava->estado_af) && $ava->estado_af == 'Inactivo') ? 'disabled' : '';
                                                @endphp

                                                <td class="text-center align-middle">
                                                    @if (!empty($ava->id))
                                                        {{-- Opciones si el avance ya existe en la BD --}}
                                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $ava->id }}" data-toggle="modal" data-target="#veravancemodal" title="ver avance">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $ava->id }}" data-toggle="modal" data-target="#editaravancemodal" title="modificar avance"> 
                                                            <i class="fas fa-user-edit"></i>
                                                        </button>
                                                        <button type="button" class="eliminar btn btn-sm btn-danger" {{ $est }} data-id="{{ $ava->id }}" title="desactivar avance">
                                                            <i class="fas fa-user-minus"></i>
                                                        </button>
                                                    @else
                                                        {{-- Opción si es avance virtual desde programado --}}
                                                        <button type="button" class="agregar btn btn-sm btn-primary" 
                                                            data-anio="{{ $ava->anio_af }}" 
                                                            data-trim="{{ $ava->trimestre_af }}" 
                                                            data-idpf="{{ $pro->id }}"
                                                            data-toggle="modal" 
                                                            data-target="#agregaravancemodal" 
                                                            title="agregar avance"> 
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>    
                </div>
            </div>
        </div>

        <div class="modal fade" id="agregaravancemodal">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Crear Avance Financiero del indicador - {{ $ip->codigo_ip }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('guardaravafin') }}" method="POST">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id_pf" class="form-control" readonly id="id_pf">
                            <div class="form-group m-2">
                                <label for="id_dep">Dependencia Responsable <b class="text-danger"></b></label>
                                <input type="text" name="id_dep" class="form-control" value="{{ $ip->dependencia->nombre_d }}" readonly id="dependencia">
                            </div>
                            <div class="form-group m-2">
                                <label for="ip">Indicador <b class="text-danger"></b></label>
                                <input type="text" name="ip" class="form-control" readonly id="indicador"  value="{{ $ip->codigo_ip.'. '.$ip->nombre_ip }}">   
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="anio">Año <b class="text-danger"></b></label>
                                        <input type="text" name="anio_af" class="form-control" readonly id="anio_af">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="trimestre">Trimestre <b class="text-danger"></b></label>
                                        <input type="text" name="trimestre_af" class="form-control" readonly id="trimestre_af">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="bp">Requiere Código BPIN <b class="text-danger"></b></label>
                                        <select name="bp" id="bp" class="form-control" style="width: 100%">
                                            <option value="Si">Si</option>
                                            <option value="No" selected>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="bpin" id="label_bpin">Código BPIN<b class="text-danger"> * </b></label>
                                            <input type="text" name="bpin" id="bpin" autofocus class="form-control"
                                                placeholder="Ingrese el código bpin" required value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <!-- Contenedor del label y el span alineados horizontalmente -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="avance_ICLD">Avance ICLD<b class="text-danger"> * </b></label>
                                            <span id="ver_numero_icld">
                                                <b class="badge"></b>
                                            </span>
                                        </div>
                                        <input type="text" name="avance_icld" id="avance_icld" autofocus class="form-control"
                                            placeholder="Ingrese el avance del periodo" required value="0">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado_ICLD">Programado ICLD<b class="text-danger"></b></label>
                                        <input type="text" name="programado_icld" id="programado_icld" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago_icld">
                                    <b class="badge"></b>
                                </span>
                                <span id="ver_desempenio_icld">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="avance_ICDE">Avance ICDE<b class="text-danger"> * </b></label>
                                            <span id="ver_numero_icde">
                                                <b class="badge"></b>
                                            </span>
                                        </div>
                                        <input type="text" name="avance_icde" id="avance_icde" autofocus class="form-control"
                                            placeholder="Ingrese el avance del periodo" required value="0">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado_ICDE">Programado ICDE<b class="text-danger"></b></label>
                                        <input type="text" name="programado_icde" id="programado_icde" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago_icde">
                                    <b class="badge"></b>
                                </span>
                                <span id="ver_desempenio_icde">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="avance_SGPE">Avance SGPE<b class="text-danger"> * </b></label>
                                            <span id="ver_numero_sgpe">
                                                <b class="badge"></b>
                                            </span>
                                        </div>
                                        <input type="text" name="avance_sgpe" id="avance_sgpe" autofocus class="form-control"
                                            placeholder="Ingrese el avance del periodo" required value="0">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado_SGPE">Programado SGP Educación<b class="text-danger"></b></label>
                                        <input type="text" name="programado_sgpe" id="programado_sgpe" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago_sgpe">
                                    <b class="badge"></b>
                                </span>
                                <span id="ver_desempenio_sgpe">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="avance_SGPS">Avance SGPS<b class="text-danger"> * </b></label>
                                            <span id="ver_numero_sgps">
                                                <b class="badge"></b>
                                            </span>
                                        </div>
                                        <input type="text" name="avance_sgps" id="avance_sgps" autofocus class="form-control"
                                            placeholder="Ingrese el avance del periodo" required value="0">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado_SGPS">Programado SGP Salud<b class="text-danger"></b></label>
                                        <input type="text" name="programado_sgps" id="programado_sgps" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago_sgps">
                                    <b class="badge"></b>
                                </span>
                                <span id="ver_desempenio_sgps">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="avance_SGPAPSB">Avance SGPAPSB<b class="text-danger"> * </b></label>
                                            <span id="ver_numero_sgpapsb">
                                                <b class="badge"></b>
                                            </span>
                                        </div>
                                        <input type="text" name="avance_sgpapsb" id="avance_sgpapsb" autofocus class="form-control"
                                            placeholder="Ingrese el avance del periodo" required value="0">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado_SGPAPSB">Programado SGP APSB<b class="text-danger"></b></label>
                                        <input type="text" name="programado_spgapsb" id="programado_sgpapsb" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago_sgpapsb">
                                    <b class="badge"></b>
                                </span>
                                <span id="ver_desempenio_sgpapsb">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="avance_RPED">Avance R. P. E. Descentralizadas<b class="text-danger"> * </b></label>
                                            <span id="ver_numero_rped">
                                                <b class="badge"></b>
                                            </span>
                                        </div>
                                        <input type="text" name="avance_rped" id="avance_rped" autofocus class="form-control"
                                            placeholder="Ingrese el avance del periodo" required value="0">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado_RPED">Programado R. P. E. Descentralizadas<b class="text-danger"></b></label>
                                        <input type="text" name="programado_rped" id="programado_rped" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago_rped">
                                    <b class="badge"></b>
                                </span>
                                <span id="ver_desempenio_rped">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="avance_SGR">Avance S. G. Regalias<b class="text-danger"> * </b></label>
                                            <span id="ver_numero_sgr">
                                                <b class="badge"></b>
                                            </span>
                                        </div>
                                        <input type="text" name="avance_sgr" id="avance_sgr" autofocus class="form-control"
                                            placeholder="Ingrese el avance del periodo" required value="0">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado_SGR">Programado S. G. Regalias<b class="text-danger"></b></label>
                                        <input type="text" name="programado_sgr" id="programado_sgr" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago_sgr">
                                    <b class="badge"></b>
                                </span>
                                <span id="ver_desempenio_sgr">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="avance_CR">Avance Crédito<b class="text-danger"> * </b></label>
                                            <span id="ver_numero_cr">
                                                <b class="badge"></b>
                                            </span>
                                        </div>
                                        <input type="text" name="avance_cr" id="avance_cr" autofocus class="form-control"
                                            placeholder="Ingrese el avance del periodo" required value="0">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado_CR">Programado Crédito<b class="text-danger"></b></label>
                                        <input type="text" name="programado_cr" id="programado_cr" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago_cr">
                                    <b class="badge"></b>
                                </span>
                                <span id="ver_desempenio_cr">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="avance_G">Avance Gestión<b class="text-danger"> * </b></label>
                                            <span id="ver_numero_g">
                                                <b class="badge"></b>
                                            </span>
                                        </div>
                                        <input type="text" name="avance_g" id="avance_g" autofocus class="form-control"
                                            placeholder="Ingrese el avance del periodo" required value="0">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado_G">Programado Gestión<b class="text-danger"></b></label>
                                        <input type="text" name="programado_g" id="programado_g" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago_g">
                                    <b class="badge"></b>
                                </span>
                                <span id="ver_desempenio_g">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="avance_CO">Avance Coofinanciación<b class="text-danger"> * </b></label>
                                            <span id="ver_numero_co">
                                                <b class="badge"></b>
                                            </span>
                                        </div>
                                        <input type="text" name="avance_co" id="avance_co" autofocus class="form-control"
                                            placeholder="Ingrese el avance del periodo" required value="0">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado_CO">Programado Coofinanciación<b class="text-danger"></b></label>
                                        <input type="text" name="programado_co" id="programado_co" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago_co">
                                    <b class="badge"></b>
                                </span>
                                <span id="ver_desempenio_co">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="avance_OR">Avance Otros Recursos<b class="text-danger"> * </b></label>
                                            <span id="ver_numero_or">
                                                <b class="badge"></b>
                                            </span>
                                        </div>
                                        <input type="text" name="avance_or" id="avance_or" autofocus class="form-control"
                                            placeholder="Ingrese el avance del periodo" required value="0">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-2">
                                        <label for="programado_OR">Programado Otros Recursos<b class="text-danger"></b></label>
                                        <input type="text" name="programado_or" id="programado_or" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-2">
                                <span id="ver_rezago_or">
                                    <b class="badge"></b>
                                </span>
                                <span id="ver_desempenio_or">
                                    <b class="badge"></b>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group m-2">
                                        <label for="desc_fin" class="position-relative">Descripción del Periodo</label>
                                        <textarea name="desc_fin" id="desc_fin" class="form-control" placeholder="Justificación del logro" required></textarea>
                                        <div class="d-flex justify-content-end mt-1">
                                            <span class="badge btn-danger" id="max_logro_fin">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" id="envia_fin" disabled>Guardar</button>
                            </div>
                        </form>
                    </div>
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
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="veravancemodal">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Ver Datos del Avance Financiero para el Indicador  - {{ $ip->codigo_ip }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="verindicador">Indicador</label>
                                    <p><span id="verindicador"></span></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="verdependencia">Dependencia</label>
                                    <p><span id="verdependencia"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="veranio">Año</label>
                                    <p><span id="veranio"></span></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="vertrimestre">Trimestre</label>
                                    <p><span id="vertrimestre"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="veravaicld">Avance ICLD</label>
                                    <p><span id="veravaicld"></span></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="verproicld">Programado ICLD</label>
                                    <p><span id="verproicld"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="veravaicde">Avance ICDE</label>
                                    <p><span id="veravaicde"></span></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="verproicde">Programado ICDE</label>
                                    <p><span id="verproicde"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="veravasgpe">Avance SGP Educación</label>
                                    <p><span id="veravasgpe"></span></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="verprosgpe">Programado SGP Educación</label>
                                    <p><span id="verprosgpe"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="veravasgps">Avance SGP Salud</label>
                                    <p><span id="veravasgps"></span></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="verprosgps">Programado SGP Salud</label>
                                    <p><span id="verprosgps"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="veravasgpapsb">Avance SGPA PSB</label>
                                    <p><span id="veravasgpapsb"></span></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="verprosgpapsb">Programado SGPA PSB</label>
                                    <p><span id="verprosgpapsb"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="veravarped">Avance R. P. E. Descentralizadas</label>
                                    <p><span id="veravarped"></span></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="verprorped">Programado R. P. E. Descentralizadas</label>
                                    <p><span id="verprorped"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="veravasgr">Avance S. G. Regalías</label>
                                    <p><span id="veravasgr"></span></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="verprosgr">Programado S. G. Regalías</label>
                                    <p><span id="verprosgr"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="veravacr">Avance Crédito</label>
                                    <p><span id="veravacr"></span></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="verprocr">Programado Crédito</label>
                                    <p><span id="verprocr"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="veravag">Avance S. G. Gestión</label>
                                    <p><span id="veravag"></span></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="verprog">Programado Gestión</label>
                                    <p><span id="verprog"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="veravaco">Avance Coofinanciación</label>
                                    <p><span id="veravaco"></span></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="verproco">Programado Coofinanciación</label>
                                    <p><span id="verproco"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="vertotava">Total Avance</label>
                                    <p><span id="vertotava"></span></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-2">
                                    <label for="vertotpro">Total Programado</label>
                                    <p><span id="vertotpro"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group m-2">
                                    <label for="verdesc">Descripción</label>
                                    <p><span id="verdesc"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="veravanceipmodal">
            <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Ver Datos del Avance Financiero del Indicador - {{ $ip->codigo_ip }}</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
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
                                                        style="width: <span id='p_avance_2024_4'></span>%;" 
                                                        aria-valuenow="<span id='por_avance_2024_4'></span>" 
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
               
        document.querySelectorAll('input[id^="avance_"]').forEach(function (input) {
            input.addEventListener('input', function (e) {
                let valor = e.target.value;

                // Eliminar puntos (ya no se permiten)
                valor = valor.replace(/\./g, '');

                // Eliminar cualquier carácter que no sea dígito o coma
                valor = valor.replace(/[^0-9,]/g, '');

                // Permitir solo una coma, y solo si hay un número antes
                let nuevoValor = '';
                let comaAgregada = false;
                for (let i = 0; i < valor.length; i++) {
                    const char = valor[i];
                    if (char === ',') {
                        if (!comaAgregada && i > 0 && /\d/.test(valor[i - 1])) {
                            nuevoValor += char;
                            comaAgregada = true;
                        }
                        // Si no hay número antes o ya hay coma, se omite
                    } else {
                        nuevoValor += char;
                    }
                }

                e.target.value = nuevoValor;
            });
        });
        
        $(document).ready(function() {
            // Inicializar DataTable
            $('#avafins').DataTable({
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
                        targets: "_all",        // A todas las columnas
                        className: "text-center align-middle"
                    }
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
        
        $('input[id^="avance_"]').on('input', function () {
            const idAvance = $(this).attr('id'); // ejemplo: avance_icld
            const clave = idAvance.replace('avance_', ''); // ejemplo: icld

            let avance = $(this).val();
            let programado = $(`#programado_${clave}`).val();

            const formatter = new Intl.NumberFormat('es-CO', {
                        style: 'currency',
                        currency: 'COP',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });

            let valorNumerico = parseFloat(avance.replace(',', '.'));
            if (isNaN(valorNumerico)) {
                valorNumerico = 0; // Si no es un número, asignar 0
            }
            $('#ver_numero_' + clave + ' .badge').text(formatter.format(valorNumerico));

            // Reemplazar puntos y comas para convertir a número
            programado = parseFloat(programado.replace(/\$/g, '').replace(/\./g, '').replace(',', '.'));
            avance = parseFloat(avance.replace(',', '.'));
            const badgeRezago = $(`#ver_rezago_${clave} .badge`);
            const badgeDesempeno = $(`#ver_desempenio_${clave} .badge`);

            // Si no hay avance o programado no es válido, limpiar
            if (!avance || avance === 0 || !programado || programado === 0) {
                badgeRezago.text('').removeClass().addClass('badge');
                badgeDesempeno.text('').removeClass().addClass('badge');
                return;
            }

            let rezago = (avance / programado) * 100;
            let desempenoTexto = "";
            let desempenoClase = "badge";

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

            badgeDesempeno.text(`Desempeño: ${desempenoTexto}`).removeClass().addClass(desempenoClase);

            if (rezago === 100) {
                badgeRezago.text('Ha cumplido').removeClass().addClass('badge badge-success');
            } else if (rezago > 100) {
                badgeRezago.text(`Rezago del ${(rezago - 100).toFixed(2)}%`).removeClass().addClass('badge badge-warning');
            } else {
                badgeRezago.text(`Rezago del ${(100 - rezago).toFixed(2)}%`).removeClass().addClass('badge badge-danger');
            }
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

        $('#bp').on('input', function () {
            const valor = document.getElementById('bp').value;
            if (valor === 'No') {
                $('#label_bpin').hide();   // Oculta el label
                $('#bpin').closest('div').hide(); // Oculta el input y su contenedor si está dentro de un <div>
                    $('#bpin').val('0');
            } else {
                $('#label_bpin').show();   // Muestra el label
                $('#bpin').closest('div').show(); // Muestra el input y su contenedor si está dentro de un <div>
                $('#bpin').val(''); // Limpia el valor del input
            }
        });

        $('#agregaravancemodal').on('shown.bs.modal', function () {
            $('#label_bpin').hide();   // Oculta el label
            $('#bpin').closest('div').hide(); // Oculta el input y su contenedor si está dentro de un <div>
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

        $('#anio').on('change', function () {
            var AnioId = $(this).val();
            var IndId = document.getElementById('id_ip').value;
            var TriId = document.getElementById('id_trimestre_avaf').value;
            var url = "{{ route('traer_financiero_anio', ['id' => ':id']) }}";
            url = url.replace(':id', IndId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    var anios = ['2024', '2025', '2026', '2027'];
                    var trimestres = ['1', '2', '3', '4'];
                    var campos = ['icld', 'icde', 'sgpe', 'sgps', 'sgpapsb', 'rped', 'sgr', 'cr', 'g', 'co', 'or'];

                    if (TriId != '0' && AnioId != '') {
                        anios.forEach(function(a) {
                            trimestres.forEach(function(t) {
                                if (a == AnioId && t == TriId) {
                                    campos.forEach(function(c) {
                                        var valor = data[0][c + '_' + a + '_' + t];
                                        console.log(valor);
                                        $('programado_' + c.toUpperCase()).text(valor);
                                    });
                                }
                            });
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });

        $('#id_anio_avaf').on('change', function () {
            var AnioId = $(this).val();
            var IndId = document.getElementById('id_ip').value;
            var TriId = document.getElementById('id_trimestre_avaf').value;
            var RezId = document.getElementById('rezago').value;
            var url = "{{ route('verfinanciero_anio', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId + '_' + RezId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    // Desestructurar los tres valores del JSON
                    var table = $('#avafins').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    data[0].forEach(function(item) {
                        var estadoClass = item.estado_af == 'Activo' ? 'bg-success' : 'bg-danger';
                        var estadoText = item.estado_af == 'Activo' ? 'Activo' : 'Inactivo';

                        var botones = `
                            <button type="button" class="ver btn btn-sm btn-info" data-id="${item.id}" data-toggle="modal" data-target="#veravancemodal" title="ver avance">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="editar btn btn-sm btn-warning" data-id="${item.id}" data-toggle="modal" data-target="#editaravancemodal" title="modificar avance">
                                <i class="fas fa-user-edit"></i>
                            </button>
                            <button type="button" class="eliminar btn btn-sm btn-danger" data-id="${item.id}" title="desactivar avance">
                                <i class="fas fa-user-minus"></i>
                            </button>
                        `;

                        var barra_periodo = `
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                    style="width: ${item.porcentaje_periodo}%;" 
                                    aria-valuenow="${item.porcentaje_periodo}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                </div>
                            </div>
                        `;

                        var barra_anio = `
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                    style="width: ${item.porcentaje_anio}%;" 
                                    aria-valuenow="${item.porcentaje_anio}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                </div>
                            </div>
                        `;

                        var periodo = item.anio_af + '_' + item.trimestre_af;

                        let porcentajePeriodoHTML = '';

                        if (parseFloat(item.porcentaje_periodo) > 100.00) {
                            porcentajePeriodoHTML = `<div class="text-center">100.00 %${barra_periodo} ${getBadgePorcentajeAvance(item.porcentaje_periodo)}</div>`;
                        } else {
                            porcentajePeriodoHTML = `<div class="text-center">${parseFloat(item.porcentaje_periodo).toFixed(2)} %${barra_periodo} ${getBadgePorcentajeAvance(item.porcentaje_periodo)}</div>`;
                        }

                        let porcentajeAnioHTML = '';

                        if (parseFloat(item.porcentaje_anio) > 100.00) {
                            porcentajeAnioHTML = `<div class="text-center">100.00 %${barra_anio}</div>`;
                        } else {
                            porcentajeAnioHTML = `<div class="text-center">${parseFloat(item.porcentaje_anio).toFixed(2)} %${barra_anio}</div>`;
                        }

                        table.row.add([
                            periodo,
                            porcentajePeriodoHTML,
                            porcentajeAnioHTML,
                            `<b class="badge ${estadoClass}">${estadoText}</b>`,
                            botones
                        ]);
                    });
                    table.draw();

                    var alertaHtml = `
                        <div class="alert ${data[2] === 0 ? 'alert-success' : 'alert-danger'} alert-dismissible fade show text-center h4" role="alert" id="filtro_financieros">
                            <strong id="control_faltan">De un total de ${data[1]} registros financieros, faltan por registrar ${data[2]}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `;

                    // Reemplazar el contenido de la alerta en el DOM
                    $('#alerta_financieros').html(alertaHtml);
                    setTimeout(function() {
                        $("#filtro_financieros").alert('close');
                    }, 5000); // 5000 milisegundos = 5 segundos
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });

        $('#id_trimestre_avaf').on('change', function () {
            var TriId = $(this).val();
            var IndId = document.getElementById('id_ip').value;
            var AnioId = document.getElementById('id_anio_avaf').value;
            var RezId = document.getElementById('rezago').value;
            var url = "{{ route('verfinanciero_anio', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId + '_' + RezId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    // Desestructurar los tres valores del JSON
                    var table = $('#avafins').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    data[0].forEach(function(item) {
                        var estadoClass = item.estado_af == 'Activo' ? 'bg-success' : 'bg-danger';
                        var estadoText = item.estado_af == 'Activo' ? 'Activo' : 'Inactivo';

                        var botones = `
                            <button type="button" class="ver btn btn-sm btn-info" data-id="${item.id}" data-toggle="modal" data-target="#veravancemodal" title="ver avance">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="editar btn btn-sm btn-warning" data-id="${item.id}" data-toggle="modal" data-target="#editaravancemodal" title="modificar avance">
                                <i class="fas fa-user-edit"></i>
                            </button>
                            <button type="button" class="eliminar btn btn-sm btn-danger" data-id="${item.id}" title="desactivar avance">
                                <i class="fas fa-user-minus"></i>
                            </button>
                        `;

                        var barra_periodo = `
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                    style="width: ${item.porcentaje_periodo}%;" 
                                    aria-valuenow="${item.porcentaje_periodo}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                </div>
                            </div>
                        `;

                        var barra_anio = `
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                    style="width: ${item.porcentaje_anio}%;" 
                                    aria-valuenow="${item.porcentaje_anio}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                </div>
                            </div>
                        `;

                        var periodo = item.anio_af + '_' + item.trimestre_af;

                        let porcentajePeriodoHTML = '';

                        if (parseFloat(item.porcentaje_periodo) > 100.00) {
                            porcentajePeriodoHTML = `<div class="text-center">100.00 %${barra_periodo} ${getBadgePorcentajeAvance(item.porcentaje_periodo)}</div>`;
                        } else {
                            porcentajePeriodoHTML = `<div class="text-center">${parseFloat(item.porcentaje_periodo).toFixed(2)} %${barra_periodo} ${getBadgePorcentajeAvance(item.porcentaje_periodo)}</div>`;
                        }

                        let porcentajeAnioHTML = '';

                        if (parseFloat(item.porcentaje_anio) > 100.00) {
                            porcentajeAnioHTML = `<div class="text-center">100.00 %${barra_anio}</div>`;
                        } else {
                            porcentajeAnioHTML = `<div class="text-center">${parseFloat(item.porcentaje_anio).toFixed(2)} %${barra_anio}</div>`;
                        }

                        table.row.add([
                            periodo,
                            porcentajePeriodoHTML,
                            porcentajeAnioHTML,
                            `<b class="badge ${estadoClass}">${estadoText}</b>`,
                            botones
                        ]);
                    });
                    table.draw();

                    var alertaHtml = `
                        <div class="alert ${data[2] === 0 ? 'alert-success' : 'alert-danger'} alert-dismissible fade show text-center h4" role="alert" id="filtro_financieros">
                            <strong id="control_faltan">De un total de ${data[1]} registros financieros, faltan por registrar ${data[2]}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `;

                    // Reemplazar el contenido de la alerta en el DOM
                    $('#alerta_financieros').html(alertaHtml);
                    setTimeout(function() {
                        $("#filtro_financieros").alert('close');
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
            var AnioId = document.getElementById('id_anio_avaf').value;
            var IndId = document.getElementById('id_ip').value;
            var TriId = document.getElementById('id_trimestre_avaf').value;
            var RezId = $(this).val();
            var url = "{{ route('verfinanciero_anio', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId + '_' + RezId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    // Desestructurar los tres valores del JSON
                    var table = $('#avafins').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    data.forEach(function(item) {
                        var estadoClass = item.estado_af == 'Activo' ? 'bg-success' : 'bg-danger';
                        var estadoText = item.estado_af == 'Activo' ? 'Activo' : 'Inactivo';

                        var botones = `
                            <button type="button" class="ver btn btn-sm btn-info" data-id="${item.id}" data-toggle="modal" data-target="#veravancemodal" title="ver avance">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="editar btn btn-sm btn-warning" data-id="${item.id}" data-toggle="modal" data-target="#editaravancemodal" title="modificar avance">
                                <i class="fas fa-user-edit"></i>
                            </button>
                            <button type="button" class="eliminar btn btn-sm btn-danger" data-id="${item.id}" title="desactivar avance">
                                <i class="fas fa-user-minus"></i>
                            </button>
                        `;

                        var barra_periodo = `
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                    style="width: ${item.porcentaje_periodo}%;" 
                                    aria-valuenow="${item.porcentaje_periodo}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                </div>
                            </div>
                        `;

                        var barra_anio = `
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                    style="width: ${item.porcentaje_anio}%;" 
                                    aria-valuenow="${item.porcentaje_anio}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                </div>
                            </div>
                        `;

                        var periodo = item.anio_af + '_' + item.trimestre_af;

                        table.row.add([
                            periodo,
                            `<div class="text-center">${item.porcentaje_periodo} %${barra_periodo} ${getBadgePorcentajeAvance(item.porcentaje_periodo)}</div>`,
                            `<div class="text-center">${item.porcentaje_anio} %${barra_anio}</div>`,
                            `<b class="badge ${estadoClass}">${estadoText}</b>`,
                            botones
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

        $('.agregar').on('click', function () {
            const anio = $(this).data('anio');
            const trim = $(this).data('trim');
            const idpf = $(this).data('idpf');
            
            // Rellenar selects de año y trimestre
            $('#anio_af').val(anio);
            $('#trimestre_af').val(trim);
            $('#id_pf').val(idpf);

            var url = "{{ route('traer_financiero_anio', ['id' => ':id']) }}";
            url = url.replace(':id', idpf);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    const campos = ['ICLD', 'ICDE', 'SGPE', 'SGPS', 'SGPAPSB', 'RPED', 'SGR', 'CR', 'G', 'CO', 'OR'];

                    const formatter = new Intl.NumberFormat('es-CO', {
                        style: 'currency',
                        currency: 'COP',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });

                    campos.forEach(clave => {
                        const nombreCampo = `${clave}_${anio}_${trim}`;
                        let valor = data[0][nombreCampo];

                        // Convertimos a número flotante
                        let numero = parseFloat(valor || 0);

                        // Formateamos y lo colocamos en el input correspondiente
                        $(`#programado_${clave.toLowerCase()}`).val(formatter.format(numero));
                    });
                    
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });

        function limpiarCamposProgramado() {
            const campos = ['icld', 'icde', 'sgpe', 'sgps', 'sgpapsb', 'rped', 'sgr', 'cr', 'g', 'co', 'or'];
            campos.forEach(c => $('#programado_' + c).val(0));
        }

        $(document).on('click', '.ver', function () {
            var AvanceId = $(this).data('id');
            const formatter = new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });

            var url = "{{ route('veravafin', ['id' => ':id']) }}".replace(':id', AvanceId);
            var total_avance = 0;
            var total_programado = 0;

            const campos = ['ICLD', 'ICDE', 'SGPE', 'SGPS', 'SGPAPSB', 'RPED', 'SGR', 'CR', 'G', 'CO', 'OR'];

            // Limpiar campos del modal
            campos.forEach(c => {
                $('#verava' + c.toLowerCase()).text('');
                $('#verpro' + c.toLowerCase()).text('');
            });

            $('#verindicador, #verdependencia, #veranio, #vertrimestre, #verdesc, #vertotava, #vertotpro').text('');

            $.ajax({
                url: url,
                type: 'get',
                success: function (data) {
                    // Reemplazar comas y convertir valores a número (mantener como Number)
                    campos.forEach(campo => {
                        let valor = (data[campo] || "0").replace(/\./g, '').replace(',', '.');
                        data[campo] = parseFloat(valor);
                    });

                    // Sumar avances
                    campos.forEach(campo => {
                        total_avance += data[campo];
                    });

                    // Sumar programado
                    campos.forEach(campo => {
                        const prog = parseFloat(data.avancefin[campo + '_' + data.anio_af + '_' + data.trimestre_af]) || 0;
                        total_programado += prog;
                    });

                    // Cargar información en el modal
                    $('#verindicador').text(data.avancefin.indproducto.codigo_ip + '. ' + data.avancefin.indproducto.nombre_ip);
                    $('#verdependencia').text(data.avancefin.indproducto.dependencia.nombre_d);
                    $('#veranio').text(data.anio_af);
                    $('#vertrimestre').text(data.trimestre_af);

                    campos.forEach(campo => {
                        const avance = data[campo];
                        const programado = parseFloat(data.avancefin[campo + '_' + data.anio_af + '_' + data.trimestre_af]) || 0;
                        $('#verava' + campo.toLowerCase()).text(formatter.format(Math.floor(avance * 100) / 100));
                        $('#verpro' + campo.toLowerCase()).text(formatter.format(Math.floor(programado * 100) / 100));
                    });

                    $('#vertotava').html(
                        formatter.format(Math.floor(total_avance * 100) / 100) +
                        '  (<strong>' +
                        (total_avance / total_programado * 100).toFixed(2) +
                        ' %</strong>)'
                    );
                    $('#vertotpro').text(formatter.format(Math.floor(total_programado * 100) / 100));

                    $('#verdesc').text(data.logro_af);

                    $('#veravancemodal').show();
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        });

        $(document).on('click', '.ver_ip', function() {
            var AvaIdId = $(this).data('id');
            var url = "{{ route('verfinip', ['id' => ':id']) }}";
            url = url.replace(':id', AvaIdId);
            const periodos = [
                                '2024_3', '2024_4', '2025_1', '2025_2', '2025_3', '2025_4',
                                '2026_1', '2026_2', '2026_3', '2026_4', '2027_1', '2027_2',
                                '2027_3', '2027_4'
                            ];
            const anios = ['2024', '2025', '2026', '2027'];                
            const formatter = new Intl.NumberFormat('es-CO', {
                        style: 'currency',
                        currency: 'COP',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data.indproducto[0].resumen_anual);
                    $('#tab-2024_consulta').tab('show');
                    $('#cod_ip').text(data.codigo_ip + '. ' + data.nombre_ip);
                    periodos.forEach(function(periodo) {
                        const resumen = data.indproducto[0].resumen_periodo?.[periodo];

                        if (resumen) {
                            if (resumen.porcentaje != "No programado") {
                                $('#avance_' + periodo).text(formatter.format(Math.floor(resumen.total_avance * 100) / 100));
                                $('#programado_' + periodo).text(formatter.format(Math.floor(resumen.total_programado * 100) / 100));
                                if (resumen.porcentaje > 100.00) {
                                    $('#porcentaje_avance_' + periodo).text('100.00 %');
                                } else {
                                    $('#porcentaje_avance_' + periodo).text(resumen.porcentaje + ' %');
                                }
                                $('#p_avance_' + periodo).text(resumen.porcentaje);
                                $('#por_avance_' + periodo).text(resumen.porcentaje);
                                $('#progress_' + periodo + ' .progress-bar').css('width', resumen.porcentaje + '%');
                                $('#progress_' + periodo).show();
                            } else {
                                $('#avance_' + periodo).text(resumen.total_avance);
                                $('#programado_' + periodo).text(resumen.total_programado);
                                $('#porcentaje_avance_' + periodo).text(resumen.porcentaje);
                                $('#progress_' + periodo).hide();
                            }
                        }
                    });
                    anios.forEach(function(anio) {
                        const resumen_anio = data.indproducto[0].resumen_anual?.[anio];

                        if (resumen_anio) {
                            if (resumen_anio.porcentaje != "No programado") {
                                $('#avance_' + anio).text(formatter.format(Math.floor(resumen_anio.total_avance * 100) / 100));
                                $('#programado_' + anio).text(formatter.format(Math.floor(resumen_anio.total_programado * 100) / 100));
                                if (resumen_anio.porcentaje > 100.00) {
                                    $('#porcentaje_' + anio).text('100.00 %');
                                } else {
                                    $('#porcentaje_' + anio).text(resumen_anio.porcentaje + ' %');
                                }
                                $('#p_avance_' + anio).text(resumen_anio.porcentaje);
                                $('#por_avance_' + anio).text(resumen_anio.porcentaje);
                                $('#progress_' + anio + ' .progress-bar').css('width', resumen_anio.porcentaje + '%');
                                $('#progress_' + anio).show();
                            } else {
                                $('#avance_' + anio).text(resumen_anio.total_avance);
                                $('#programado_' + anio).text(resumen_anio.total_programado);
                                $('#porcentaje_' + anio).text(resumen_anio.porcentaje);
                                $('#progress_' + anio).hide();
                            }
                        }
                    });
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

        $('#desc_fin').on('input', function () {
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
            $('#max_logro_fin').text(el.value.length).removeClass('badge bg-success bg-danger');

            if (el.value.length >= 500) {
                $('#envia_fin').prop('disabled', false);
                $('#max_logro_fin').addClass('badge bg-success');
            } else {
                $('#envia_fin').prop('disabled', true);
                $('#max_logro_fin').addClass('badge bg-danger');
            }
        });



        $('#agregaravancemodal').on('hidden.bs.modal', function () {
            $(this).find('input[type="text"], input[type="number"]').val('0'); // Limpiar textos y números
            $(this).find('.badge').text('').removeClass('bg-success bg-danger bg-warning'); // Limpiar spans con badge
        });

        setTimeout(function() {
            $("#alerta_blade").alert('close');
        }, 5000); // 5000 milisegundos = 5 segundos
    </script>    
@endsection