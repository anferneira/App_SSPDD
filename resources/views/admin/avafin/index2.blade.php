@extends('Layouts.plantilla')

@section('titulo', 'Avances Financieros')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>Avances Financieros
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregaravancemodal" title="nuevo avance">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importaravancemodal" title="cargar avances">
                            <i class="fas fa-cloud-upload"></i>
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
                            <table class="table w-100" id="a">
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
                            <table class="table w-100" id="avance">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th class="text-center">No</th>
                                        <th class="text-center">Código Dane</th>
                                        <th class="text-center" width="35%">Municipio</th>
                                        <th class="text-center" width="35%">Grupo Poblacional</th>
                                        <th class="text-center" style="display: none;">Periodo</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
        
                                <tbody class="text-justify">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($avafins as $ava)
                                        <tr class="text-center" id="ava-row-{{ $ava->id }}">
                                            <td class="text-center">
                                                {{ $i++ }}
                                            </td>
                                            <td class="text-center">
                                                {{ $ava->municipios->codigo_m }}
                                            </td>
                                            <td class="text-start" with="35%">
                                                {{ $ava->municipios->nombre_m }}
                                            </td>
                                            <td class="text-start" width="35%">
                                                {{ $ava->poblacion->codigo_gp.'. '.$ava->poblacion->nombre_gp }}
                                            </td>
                                            <th class="text-center" style="display: none;">
                                                {{ $ava->anio_af.'_'.$ava->trimestre_af }}
                                            </th>
                                            <td class="text-center">
                                                @if ($ava->estado_af == 'Activo')
                                                    <b class="badge bg-success estado">
                                                        {{ $ava->estado_af }}
                                                    </b>
                                                @else
                                                    <b class="badge bg-danger">
                                                        {{ $ava->estado_af }}
                                                    </b>
                                                @endif
                                            </td>
                                            @php
                                                if ($ava->estado_af == 'Inactivo')
                                                    $est = 'disabled';
                                                else
                                                    $est = '';
                                            @endphp
                                            <td class="text-center">
                                                <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $ava->id }}" data-toggle="modal" data-target="#veravancemodal" title="ver avance">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $ava->id }}" data-toggle="modal" data-target="#editaravancemodal" title="modificar avance">
                                                    <i class="fas fa-user-edit"></i>
                                                </button>
                                                <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $ava->id }}" title="desactivar avance">
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
                        <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Avance Financiero</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('guardaract') }}" method="POST">
                            @csrf
                            <div class="form-group m-2">
                                <label for="id_mun">Municipio <b class="text-danger"> * </b></label>
                                <select name="id_mun" id="id_mun" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
                                    @foreach ($muns as $m)
                                        <option value="{{ $m->id }}">{{ $m->nombre_m }}</option>
                                    @endforeach
                                </select>
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
                                <label for="ICLD">ICLD <b class="text-danger"> * </b></label>
                                <input type="text" name="ICLD" id="ICLD" value="0" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="ICDE">ICDE <b class="text-danger"> * </b></label>
                                <input type="text" name="ICDE" id="ICDE" value="0" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="SGPE">SGP Educación <b class="text-danger"> * </b></label>
                                <input type="text" name="SGPE" id="SGPE" value="0" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="SGPS">SGP Salud <b class="text-danger"> * </b></label>
                                <input type="text" name="SGPS" id="SGPS" value="0" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="SGPAPSB">SGP APSB <b class="text-danger"> * </b></label>
                                <input type="text" name="SGPAPSB" id="SGPAPSB" value="0" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="RPED">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                <input type="text" name="RPED" id="RPED" value="0" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="SGR">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                <input type="text" name="SGR" id="SGR" value="0" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="CR">Créditos <b class="text-danger"> * </b></label>
                                <input type="text" name="CR" id="CR" value="0" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="G">Gestión <b class="text-danger"> * </b></label>
                                <input type="text" name="G" id="G" value="0" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="CO">Cofinanciación <b class="text-danger"> * </b></label>
                                <input type="text" name="CO" id="CO" value="0" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="OR">Otros Recursos <b class="text-danger"> * </b></label>
                                <input type="text" name="OR" id="OR" value="0" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="id_gp">Grupo Poblacional <b class="text-danger"> * </b></label>
                                <select name="id_gp" id="id_gp" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
                                    @foreach ($gp as $g)
                                        <option value="{{ $g->id }}">{{ $g->codigo_gp.'. '.$g->nombre_gp }}.</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group m-2">
                                <label for="m_0_5">Mujeres entre 0 y 5 años <b class="text-danger"> * </b></label>
                                <input type="text" name="m_0_5" id="m_0_5" value="0" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="m_6_12">Mujeres entre 6 y 12 años <b class="text-danger"> * </b></label>
                                <input type="text" name="m_6_12" id="m_6_12" value="0" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="m_13_17">Mujeres entre 13 y 17 años <b class="text-danger"> * </b></label>
                                <input type="text" name="m_13_17" id="m_13_17" value="0" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="m_18_29">Mujeres entre 18 y 29 años <b class="text-danger"> * </b></label>
                                <input type="text" name="m_18_29" id="m_18_29" value="0" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="m_30_59">Mujeres entre 30 y 59 años <b class="text-danger"> * </b></label>
                                <input type="text" name="m_30_59" id="m_30_59" value="0" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="m_60">Mujeres desde los 60 años <b class="text-danger"> * </b></label>
                                <input type="text" name="m_60" id="m_60" value="0" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            
                            <div class="form-group m-2">
                                <label for="h_0_5">Hombres entre 0 y 5 años <b class="text-danger"> * </b></label>
                                <input type="text" name="h_0_5" id="h_0_5" value="0" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="h_6_12">Hombres entre 6 y 12 años <b class="text-danger"> * </b></label>
                                <input type="text" name="h_6_12" id="h_6_12" value="0" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="h_13_17">Hombres entre 13 y 17 años <b class="text-danger"> * </b></label>
                                <input type="text" name="h_13_17" id="h_13_17" value="0" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="h_18_29">Hombres entre 18 y 29 años <b class="text-danger"> * </b></label>
                                <input type="text" name="h_18_29" id="h_18_29" value="0" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="h_30_59">Hombres entre 30 y 59 años <b class="text-danger"> * </b></label>
                                <input type="text" name="h_30_59" id="h_30_59" value="0" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="h_60">Hombres desde los 60 años <b class="text-danger"> * </b></label>
                                <input type="text" name="h_60" id="h_60" value="0" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>

                            <div class="form-group m-2">
                                <label for="beneficio">Beneficio <b class="text-danger"> * </b></label>
                                <input type="text" name="beneficio" id="beneficio" class="form-control"
                                    placeholder="Ingrese el beneficio" required>
                            </div>

                            <div class="form-group m-2">
                                <label for="cantidad">Cantidad ejecutada (unidades) <b class="text-danger"> * </b></label>
                                <input type="text" name="cantidad" id="cantidad" value="0" class="form-control"
                                    placeholder="Ingrese la cantidad de unidades en el municipio" required>
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
    
        
    
        <div class="modal fade" id="editaravancemodal">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos del Avance Financiero</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('actualizaravafin') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="id_editar">
                            <input type="hidden" name="id_ip" id="id_ip_editar">
                            <div class="form-group m-2">
                                <label for="anio">Año <b class="text-danger"> * </b></label>
                                <select name="anio" id="anio_af_editar" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                </select>
                            </div>
    
                            <div class="form-group m-2">
                                <label for="trimestre">Trimestre <b class="text-danger"> * </b></label>
                                <select name="trimestre" id="trimestre_af_editar" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="form-group m-2">
                                <label for="id_mun">Municipio <b class="text-danger"> * </b></label>
                                <select name="id_mun" id="id_mun_editar" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
                                    @foreach ($muns as $m)
                                        <option value="{{ $m->id }}">{{ $m->nombre_m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group m-2">
                                <label for="ICLD">ICLD <b class="text-danger"> * </b></label>
                                <input type="text" name="ICLD" id="ICLD_editar" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="ICDE">ICDE <b class="text-danger"> * </b></label>
                                <input type="text" name="ICDE" id="ICDE_editar" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="SGPE">SGP Educación <b class="text-danger"> * </b></label>
                                <input type="text" name="SGPE" id="SGPE_editar" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="SGPS">SGP Salud <b class="text-danger"> * </b></label>
                                <input type="text" name="SGPS" id="SGPS_editar" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="SGPAPSB">SGP APSB <b class="text-danger"> * </b></label>
                                <input type="text" name="SGPAPSB" id="SGPAPSB_editar" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="RPED">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                <input type="text" name="RPED" id="RPED_editar" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="SGR">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                <input type="text" name="SGR" id="SGR_editar" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="CR">Créditos <b class="text-danger"> * </b></label>
                                <input type="text" name="CR" id="CR_editar" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="G">Gestión <b class="text-danger"> * </b></label>
                                <input type="text" name="G" id="G_editar" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="CO">Cofinanciación <b class="text-danger"> * </b></label>
                                <input type="text" name="CO" id="CO_editar" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="OR">Otros Recursos <b class="text-danger"> * </b></label>
                                <input type="text" name="OR" id="OR_editar" class="form-control"
                                    placeholder="Digite el avance" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="id_gp">Grupo Poblacional <b class="text-danger"> * </b></label>
                                <select name="id_gp" id="id_gp_editar" class="form-control">
                                    <option value="" disabled selected>Seleccionar</option>
                                    @foreach ($gp as $g)
                                        <option value="{{ $g->id }}">{{ $g->codigo_gp.'. '.$g->nombre_gp }}.</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group m-2">
                                <label for="m_0_5">Mujeres entre 0 y 5 años <b class="text-danger"> * </b></label>
                                <input type="text" name="m_0_5" id="m_0_5_editar" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="m_6_12">Mujeres entre 6 y 12 años <b class="text-danger"> * </b></label>
                                <input type="text" name="m_6_12" id="m_6_12_editar" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="m_13_17">Mujeres entre 13 y 17 años <b class="text-danger"> * </b></label>
                                <input type="text" name="m_13_17" id="m_13_17_editar" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="m_18_29">Mujeres entre 18 y 29 años <b class="text-danger"> * </b></label>
                                <input type="text" name="m_18_29" id="m_18_29_editar" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="m_30_59">Mujeres entre 30 y 59 años <b class="text-danger"> * </b></label>
                                <input type="text" name="m_30_59" id="m_30_59_editar" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="m_60">Mujeres desde los 60 años <b class="text-danger"> * </b></label>
                                <input type="text" name="m_60" id="m_60_editar" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            
                            <div class="form-group m-2">
                                <label for="h_0_5">Hombres entre 0 y 5 años <b class="text-danger"> * </b></label>
                                <input type="text" name="h_0_5" id="h_0_5_editar" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="h_6_12">Hombres entre 6 y 12 años <b class="text-danger"> * </b></label>
                                <input type="text" name="h_6_12" id="h_6_12_editar" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="h_13_17">Hombres entre 13 y 17 años <b class="text-danger"> * </b></label>
                                <input type="text" name="h_13_17" id="h_13_17_editar" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="h_18_29">Hombres entre 18 y 29 años <b class="text-danger"> * </b></label>
                                <input type="text" name="h_18_29" id="h_18_29_editar" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="h_30_59">Hombres entre 30 y 59 años <b class="text-danger"> * </b></label>
                                <input type="text" name="h_30_59" id="h_30_59_editar" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>
                            <div class="form-group m-2">
                                <label for="h_60">Hombres desde los 60 años <b class="text-danger"> * </b></label>
                                <input type="text" name="h_60" id="h_60_editar" class="form-control"
                                    placeholder="Ingrese la cantidad" required>
                            </div>

                            <div class="form-group m-2">
                                <label for="beneficio">Beneficio <b class="text-danger"> * </b></label>
                                <input type="text" name="beneficio" id="beneficio_editar" class="form-control"
                                    placeholder="Ingrese el beneficio" required>
                            </div>

                            <div class="form-group m-2">
                                <label for="cantidad">Cantidad ejecutada (unidades) <b class="text-danger"> * </b></label>
                                <input type="text" name="cantidad" id="cantidad_editar" class="form-control"
                                    placeholder="Ingrese la cantidad de unidades en el municipio" required>
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
    
        <div class="modal fade" id="importaravancemodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Cargar Avances Financieros (Archivo CSV)</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('csvavafins') }}" method="POST" enctype="multipart/form-data">
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
                        <h5 class="modal-title" id="exampleModalLabel">Ver Datos del Avance Financiero</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Municipio: </strong><span id="vermun"></span></p>
                        <p><strong>Periodo: </strong><span id="verperiodo"></span></p>
                        <p><strong>ICLD: </strong><span id="vericld"></span></p>
                        <p><strong>ICDE: </strong><span id="vericde"></span></p>
                        <p><strong>SGP Educación: </strong><span id="versgpe"></span></p>
                        <p><strong>SGPE Salúd: </strong><span id="versgps"></span></p>
                        <p><strong>SGP APSB: </strong><span id="versgpapsb"></span></p>
                        <p><strong>Recursos Própios Descentralizados: </strong><span id="verrped"></span></p>
                        <p><strong>Sistema General de Regalias: </strong><span id="versgr"></span></p>
                        <p><strong>Creditos: </strong><span id="vercr"></span></p>
                        <p><strong>Gestión: </strong><span id="verg"></span></p>
                        <p><strong>Cofinanciación: </strong><span id="verco"></span></p>
                        <p><strong>Otros Recursos: </strong><span id="veror"></span></p>
                        <p><strong>Mujeres de 0 a 5 años: </strong><span id="verm_0_5"></span></p>
                        <p><strong>Mujeres de 6 a 12 años: </strong><span id="verm_6_12"></span></p>
                        <p><strong>Mujeres de 13 a 17 años: </strong><span id="verm_13_17"></span></p>
                        <p><strong>Mujeres de 18 a 29 años: </strong><span id="verm_18_29"></span></p>
                        <p><strong>Mujeres de 30 a 59 años: </strong><span id="verm_30_59"></span></p>
                        <p><strong>Mujeres desde los 60 años: </strong><span id="verm_60"></span></p>
                        <p><strong>Total Mujeres Etario: </strong><span id="verm"></span></p>
                        <p><strong>Hombres de 0 a 5 años: </strong><span id="verh_0_5"></span></p>
                        <p><strong>Hombres de 6 a 12 años: </strong><span id="verh_6_12"></span></p>
                        <p><strong>Hombres de 13 a 17 años: </strong><span id="verh_13_17"></span></p>
                        <p><strong>Hombres de 18 a 29 años: </strong><span id="verh_18_29"></span></p>
                        <p><strong>Hombres de 30 a 59 años: </strong><span id="verh_30_59"></span></p>
                        <p><strong>Hombres desde los 60 años: </strong><span id="verh_60"></span></p>
                        <p><strong>Total Hombres Etario: </strong><span id="verh"></span></p>
                        <p><strong>Total Etario: </strong><span id="veretario"></span></p>
                        <p><strong>Beneficio: </strong><span id="verben"></span></p>
                        <p><strong>Cantidad: </strong><span id="vercant"></span></p>
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
        // Muestra el selector de archivos al hacer clic en el botón
        document.getElementById('customFileBtn').addEventListener('click', function () {
            document.getElementById('archivo_csv').click(); // Simula el clic en el input de archivo oculto
        });

        // Muestra el nombre del archivo seleccionado
        document.getElementById('archivo_csv').addEventListener('change', function () {
            const fileName = this.files[0] ? this.files[0].name : 'No se ha seleccionado ningún archivo';
            document.getElementById('fileName').textContent = fileName;
        });
        document.getElementById('ICLD').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('ICDE').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('SGPE').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('SGPS').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('SGPAPSB').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('RPED').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('SGR').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('CR').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('G').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('CO').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('OR').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('cantidad').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('ICLD_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('ICDE_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('SGPE_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('SGPS_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('SGPAPSB_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('RPED_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('SGR_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('CR_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('G_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('CO_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('OR_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        document.getElementById('cantidad_editar').addEventListener('input', function (e) {
            // Reemplaza cualquier carácter que no sea un número.
            e.target.value = e.target.value.replace(/[^0-9.]/g, ''); // Permite números y puntos.
        });
        

        $(document).ready(function() {
            // Inicializar DataTable
            $('#avance').DataTable({
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
                    { orderable: false, targets: 3 } // Desactivar ordenación en la columna de acciones
                ]
            });
        });

        $(document).on('click', '.ver', function() {
            var AvanceId = $(this).data('id');
            var url = "{{ route('veravafin', ['id' => ':id']) }}";
            url = url.replace(':id', AvanceId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    $('#vermun').text(data.municipios.codigo_m + '. ' + data.municipios.nombre_m);
                    $('#verperiodo').text(data.anio_af + '_' + data.trimestre_af);
                    $('#vericld').text(data.ICLD);
                    $('#vericde').text(data.ICDE);
                    $('#versgpe').text(data.SGPE);
                    $('#versgps').text(data.SGPS);
                    $('#versgpapsb').text(data.SGPAPSB);
                    $('#verrped').text(data.RPED);
                    $('#versgr').text(data.SGR);
                    $('#vercr').text(data.CR);
                    $('#verg').text(data.G);
                    $('#verco').text(data.CO);
                    $('#veror').text(data.OR);
                    $('#verm_0_5').text(data.m_0_5.replace(',', '.'));
                    $('#verm_6_12').text(data.m_6_12.replace(',', '.'));
                    $('#verm_13_17').text(data.m_13_17.replace(',', '.'));
                    $('#verm_18_29').text(data.m_18_29.replace(',', '.'));
                    $('#verm_30_59').text(data.m_30_59.replace(',', '.'));
                    $('#verm_60').text(data.m_60.replace(',', '.'));
                    $('#verh_0_5').text(data.h_0_5.replace(',', '.'));
                    $('#verh_6_12').text(data.h_6_12.replace(',', '.'));
                    $('#verh_13_17').text(data.h_13_17.replace(',', '.'));
                    $('#verh_18_29').text(data.h_18_29.replace(',', '.'));
                    $('#verh_30_59').text(data.h_30_59.replace(',', '.'));
                    $('#verh_60').text(data.h_60.replace(',', '.'));
                    $('#vergp').text(data.poblacion.codigo_gp + '. ' + data.poblacion.nombre_gp);
                    $('#verben').text(data.beneficio);
                    $('#vercant').text(data.cantidad.replace(',', '.'));
                    var m = Number(data.m_0_5.replace(',', '.')) + Number(data.m_6_12.replace(',', '.'))  + Number(data.m_13_17.replace(',', '.')) + Number(data.m_18_29.replace(',', '.')) + Number(data.m_30_59.replace(',', '.')) + Number(data.m_60.replace(',', '.'));
                    $('#verm').text(m);
                    var h = Number(data.h_0_5.replace(',', '.')) + Number(data.h_6_12.replace(',', '.'))  + Number(data.h_13_17.replace(',', '.')) + Number(data.h_18_29.replace(',', '.')) + Number(data.h_30_59.replace(',', '.')) + Number(data.h_60.replace(',', '.'));
                    $('#verh').text(h);
                    var et = m + h;
                    $('#veretario').text(et);
                    $('#verestado').text(data.estado_af).removeClass().addClass('badge').addClass(data.estado_af === 'Activo' ? 'bg-success' : 'bg-danger');
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
                    $('#veravancemodal').show();
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    
                }
            });
        });
        $(document).on('click', '.editar', function() {
            var AvaFinId = $(this).data('id');
            var url = "{{ route('editaravafin', ['id' => ':id']) }}";
            url = url.replace(':id', AvaFinId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    console.log(data);
                    $('#id_editar').val(data.id);
                    $('#id_ip_editar').val(data.id_ip);
                    $('#ICLD_editar').val(data.ICLD.replace(',', '.'));
                    $('#ICDE_editar').val(data.ICDE.replace(',', '.'));
                    $('#SGPE_editar').val(data.SGPE.replace(',', '.'));
                    $('#SGPS_editar').val(data.SGPS.replace(',', '.'));
                    $('#SGPAPSB_editar').val(data.SGPAPSB.replace(',', '.'));
                    $('#RPED_editar').val(data.RPED.replace(',', '.'));
                    $('#SGR_editar').val(data.SGR.replace(',', '.'));
                    $('#CR_editar').val(data.CR.replace(',', '.'));
                    $('#G_editar').val(data.G.replace(',', '.'));
                    $('#CO_editar').val(data.CO.replace(',', '.'));
                    $('#OR_editar').val(data.OR.replace(',', '.'));
                    $('#m_0_5_editar').val(data.m_0_5.replace(',', '.'));
                    $('#m_6_12_editar').val(data.m_6_12.replace(',', '.'));
                    $('#m_13_17_editar').val(data.m_13_17.replace(',', '.'));
                    $('#m_18_29_editar').val(data.m_18_29.replace(',', '.'));
                    $('#m_30_59_editar').val(data.m_30_59.replace(',', '.'));
                    $('#m_60_editar').val(data.m_60.replace(',', '.'));
                    $('#h_0_5_editar').val(data.h_0_5.replace(',', '.'));
                    $('#h_6_12_editar').val(data.h_6_12.replace(',', '.'));
                    $('#h_13_17_editar').val(data.h_13_17.replace(',', '.'));
                    $('#h_18_29_editar').val(data.h_18_29.replace(',', '.'));
                    $('#h_30_59_editar').val(data.h_30_59.replace(',', '.'));
                    $('#h_60_editar').val(data.h_60.replace(',', '.'));
                    $('#id_gp_editar').val(data.id_gp).trigger('change');
                    $('#beneficio_editar').val(data.beneficio);
                    $('#cantidad_editar').val(data.cantidad);
                    $('#id_mun_editar').val(data.id_mun).trigger('change');
                    //$('#evidencia_editar').html(data.evidencia);
                    $('#anio_af_editar').val(data.anio_af).trigger('change');
                    $('#trimestre_af_editar').val(data.trimestre_af).trigger('change');
                    $('#estado').val(data.estado_af);
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
            var url = "{{ route('eliminaravafin', ['id' => ':id']) }}";
            url = url.replace(':id', AvanceId);
            Swal.fire({
                title: "Esta seguro de desactivar el Avance Financiero?",
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
                                    text: "El Avance Financiero ha sido desactivado.",
                                    icon: "success"
                                });
                                $('#ava-row-' + AvanceId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#ava-row-' + AvanceId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#acts').DataTable().row('#ava-row-' + AvanceId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "El Avance Financiero no ha sido desactivado.",
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
            var url = "{{ route('veravances_anio', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var table = $('#acts').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    var i = 1;
                    data.forEach(function(item) {
                        // Definir la clase para el estado basado en el valor
                        var estadoClass = item.estado_a == 'Activo' ? 'bg-success' : 'bg-danger';
                        var estadoText = item.estado_a == 'Activo' ? 'Activo' : 'Inactivo';

                        // Agregar los datos a la tabla
                        table.row.add([
                            i++, // Número
                            item.codigo_a, // Código
                            item.nombre_a, // Nombre de la actividad
                            `<b class="badge ${estadoClass}">${estadoText}</b>`, // Estado
                            // Opciones: Agregar botones con las clases y atributos adecuados
                            `<button type="button" class="ver btn btn-sm btn-info" data-id="${item.id}" data-toggle="modal" data-target="#veractmodal" title="ver avance">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="editar btn btn-sm btn-warning" data-id="${item.id}" data-toggle="modal" data-target="#editaractmodal" title="modificar avance">
                                <i class="fas fa-user-edit"></i>
                            </button>
                            <button type="button" class="eliminar btn btn-sm btn-danger ${est}" data-id="${item.id}" title="desactivar avance">
                                <i class="fas fa-user-minus"></i>
                            </button>`
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
            var AnioId = document.getElementById('id_anio').value;
            var IndId = document.getElementById('id_ip').value;
            var TriId = $(this).val();
            var url = "{{ route('veravances_anio', ['id' => ':id']) }}";
            url = url.replace(':id', AnioId + '_' + TriId + '_' + IndId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    var table = $('#acts').DataTable(); // Obtén la instancia actual de DataTable
                    table.clear();
                    var i = 1;
                    data.forEach(function(item) {
                        // Definir la clase para el estado basado en el valor
                        var estadoClass = item.estado_a == 'Activo' ? 'bg-success' : 'bg-danger';
                        var estadoText = item.estado_a == 'Activo' ? 'Activo' : 'Inactivo';

                        // Agregar los datos a la tabla
                        table.row.add([
                            i++, // Número
                            item.codigo_a, // Código
                            item.nombre_a, // Nombre de la actividad
                            `<b class="badge ${estadoClass}">${estadoText}</b>`, // Estado
                            // Opciones: Agregar botones con las clases y atributos adecuados
                            `<button type="button" class="ver btn btn-sm btn-info" data-id="${item.id}" data-toggle="modal" data-target="#veractemodal" title="ver avance">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="editar btn btn-sm btn-warning" data-id="${item.id}" data-toggle="modal" data-target="#editaractmodal" title="modificar avance">
                                <i class="fas fa-user-edit"></i>
                            </button>
                            <button type="button" class="eliminar btn btn-sm btn-danger ${est}" data-id="${item.id}" title="desactivar avance">
                                <i class="fas fa-user-minus"></i>
                            </button>`
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