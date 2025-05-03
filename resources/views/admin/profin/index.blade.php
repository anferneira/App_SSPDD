@extends('Layouts.plantilla')

@section('titulo', 'Programación Financiera')

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Programación Financiera
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
                        <li class="breadcrumb-item active">Programación Financiera</li>
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
                    <table class="display" id="profin" style="width: 100%;">
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
                            @foreach ($profins as $pf)
                                <tr class="text-center" id="profin{{ $pf->id }}">
                                    <td class="text-center">
                                        {{ $i++ }}
                                    </td>
                                    <td class="text-start">
                                        {{ $pf->indproducto->codigo_ip.'. '.$pf->indproducto->nombre_ip }}
                                    </td>
                                    <td class="text-center">
                                        @if ($pf->estado_pf == 'Activo')
                                            <b class="badge bg-success estado">
                                                {{ $pf->estado_pf }}
                                            </b>
                                        @else
                                            <b class="badge bg-danger">
                                                {{ $pf->estado_pf }}
                                            </b>
                                        @endif
                                    </td>
                                    @php
                                        if ($pf->estado_pf == 'Inactivo')
                                            $est = 'disabled';
                                        else
                                            $est = '';
                                    @endphp
                                    <td class="text-center">
                                        <button type="button" class="ver btn btn-sm btn-info" data-id="{{ $pf->id }}" data-toggle="modal" data-target="#verprogramacionmodal" title="ver programación">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="editar btn btn-sm btn-warning" data-id="{{ $pf->id }}" data-toggle="modal" data-target="#editarprogramacionmodal" title="modificar programación">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button type="button" class="eliminar btn btn-sm btn-danger" @php echo $est; @endphp data-id="{{ $pf->id }}" title="desactivar programación">
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
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nueva Programación Financiera</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guardarprofin') }}" method="POST">
                        @csrf
    
                        <!-- Pestañas de navegación -->
                        <ul class="nav nav-tabs" id="tab-programacion" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-2024-3" data-toggle="tab" href="#content-2024-3" role="tab" aria-controls="content-2024-3" aria-selected="true">2024_3</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2024-4" data-toggle="tab" href="#content-2024-4" role="tab" aria-controls="content-2024-4" aria-selected="false">2024_4</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2025-1" data-toggle="tab" href="#content-2025-1" role="tab" aria-controls="content-2025-1" aria-selected="false">2025_1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2025-2" data-toggle="tab" href="#content-2025-2" role="tab" aria-controls="content-2025-2" aria-selected="false">2025_2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2025-3" data-toggle="tab" href="#content-2025-3" role="tab" aria-controls="content-2025-3" aria-selected="false">2025_3</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2025-4" data-toggle="tab" href="#content-2025-4" role="tab" aria-controls="content-2025-4" aria-selected="false">2025_4</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2026-1" data-toggle="tab" href="#content-2026-1" role="tab" aria-controls="content-2026-1" aria-selected="false">2026_1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2026-2" data-toggle="tab" href="#content-2026-2" role="tab" aria-controls="content-2026-2" aria-selected="false">2026_2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2026-3" data-toggle="tab" href="#content-2026-3" role="tab" aria-controls="content-2026-3" aria-selected="false">2026_3</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2026-4" data-toggle="tab" href="#content-2026-4" role="tab" aria-controls="content-2026-4" aria-selected="false">2026_4</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2027-1" data-toggle="tab" href="#content-2027-1" role="tab" aria-controls="content-2027-1" aria-selected="false">2027_1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2027-2" data-toggle="tab" href="#content-2027-2" role="tab" aria-controls="content-2027-2" aria-selected="false">2027_2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2027-3" data-toggle="tab" href="#content-2027-3" role="tab" aria-controls="content-2027-3" aria-selected="false">2027_3</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2027-4" data-toggle="tab" href="#content-2027-4" role="tab" aria-controls="content-2027-4" aria-selected="false">2027_4</a>
                            </li>
                        </ul>
    
                        <!-- Contenido de las pfstañas -->
                        <div class="tab-content mt-3" id="tab-content-programacion">
                            <!-- Contenido para 2024 -->
                            <div class="tab-pane fade show active" id="content-2024-3" role="tabpanel" aria-labelledby="tab-2024-3">
                                <div class="form-group m-2">
                                    <label for="ICLD_2024_3">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2024_3" id="ICLD_2024_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2024_3">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2024_3" id="ICDE_2024_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2024_3">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2024_3" id="SGPE_2024_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2024_3">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2024_3" id="SGPS_2024_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2024_3">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2024_3" id="SGPAPSB_2024_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2024_3">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2024_3" id="RPED_2024_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2024_3">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2024_3" id="SGR_2024_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2024_3">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2024_3" id="CR_2024_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2024_3">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2024_3" id="G_2024_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2024_3">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2024_3" id="CO_2024_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2024_3">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2024_3" id="OR_2024_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2024-4" role="tabpanel" aria-labelledby="tab-2024-4">
                                <div class="form-group m-2">
                                    <label for="ICLD_2024_4">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2024_4" id="ICLD_2024_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2024_4">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2024_4" id="ICDE_2024_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2024_4">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2024_4" id="SGPE_2024_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2024_4">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2024_4" id="SGPS_2024_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2024_4">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2024_4" id="SGPAPSB_2024_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2024_4">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2024_4" id="RPED_2024_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2024_4">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2024_4" id="SGR_2024_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2024_4">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2024_4" id="CR_2024_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2024_4">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2024_4" id="G_2024_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2024_4">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2024_4" id="CO_2024_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2024_4">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2024_4" id="OR_2024_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2025-1" role="tabpanel" aria-labelledby="tab-2025-1">
                                <div class="form-group m-2">
                                    <label for="ICLD_2025_1">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2025_1" id="ICLD_2025_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2025_1">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2025_1" id="ICDE_2025_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2025_1">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2025_1" id="SGPE_2025_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2025_1">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2025_1" id="SGPS_2025_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2025_1">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2025_1" id="SGPAPSB_2025_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2025_1">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2025_1" id="RPED_2025_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2025_1">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2025_1" id="SGR_2025_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2025_1">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2025_1" id="CR_2025_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2025_1">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2025_1" id="G_2025_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2025_1">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2025_1" id="CO_2025_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2025_1">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2025_1" id="OR_2025_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2025-2" role="tabpanel" aria-labelledby="tab-2025-2">
                                <div class="form-group m-2">
                                    <label for="ICLD_2025_2">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2025_2" id="ICLD_2025_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2025_2">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2025_2" id="ICDE_2025_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2025_2">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2025_2" id="SGPE_2025_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2025_2">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2025_2" id="SGPS_2025_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2025_2">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2025_2" id="SGPAPSB_2025_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2025_2">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2025_2" id="RPED_2025_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2025_2">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2025_2" id="SGR_2025_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2025_2">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2025_2" id="CR_2025_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2025_2">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2025_2" id="G_2025_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2025_2">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2025_2" id="CO_2025_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2025_2">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2025_2" id="OR_2025_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2025-3" role="tabpanel" aria-labelledby="tab-2025-3">
                                <div class="form-group m-2">
                                    <label for="ICLD_2025_3">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2025_3" id="ICLD_2025_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2025_3">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2025_3" id="ICDE_2025_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2025_3">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2025_3" id="SGPE_2025_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2025_3">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2025_3" id="SGPS_2025_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2025_3">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2025_3" id="SGPAPSB_2025_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2025_3">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2025_3" id="RPED_2025_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2025_3">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2025_3" id="SGR_2025_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2025_3">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2025_3" id="CR_2025_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2025_3">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2025_3" id="G_2025_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2025_3">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2025_3" id="CO_2025_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2025_3">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2025_3" id="OR_2025_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2025-4" role="tabpanel" aria-labelledby="tab-2025-4">
                                <div class="form-group m-2">
                                    <label for="ICLD_2025_4">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2025_4" id="ICLD_2025_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2025_4">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2025_4" id="ICDE_2025_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2025_4">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2025_4" id="SGPE_2025_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2025_4">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2025_4" id="SGPS_2025_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2025_4">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2025_4" id="SGPAPSB_2025_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2025_4">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2025_4" id="RPED_2025_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2025_4">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2025_4" id="SGR_2025_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2025_4">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2025_4" id="CR_2025_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2025_4">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2025_4" id="G_2025_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2025_4">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2025_4" id="CO_2025_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2025_4">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2025_4" id="OR_2025_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2026-1" role="tabpanel" aria-labelledby="tab-2026-1">
                                <div class="form-group m-2">
                                    <label for="ICLD_2026_1">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2026_1" id="ICLD_2026_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2026_1">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2026_1" id="ICDE_2026_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2026_1">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2026_1" id="SGPE_2026_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2026_1">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2026_1" id="SGPS_2026_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2026_1">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2026_1" id="SGPAPSB_2026_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2026_1">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2026_1" id="RPED_2026_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2026_1">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2026_1" id="SGR_2026_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2026_1">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2026_1" id="CR_2026_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2026_1">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2026_1" id="G_2026_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2026_1">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2026_1" id="CO_2026_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2026_1">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2026_1" id="OR_2026_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2026-2" role="tabpanel" aria-labelledby="tab-2026-2">
                                <div class="form-group m-2">
                                    <label for="ICLD_2026_2">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2026_2" id="ICLD_2026_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2026_2">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2026_2" id="ICDE_2026_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2026_2">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2026_2" id="SGPE_2026_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2026_2">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2026_2" id="SGPS_2026_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2026_2">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2026_2" id="SGPAPSB_2026_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2026_2">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2026_2" id="RPED_2026_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2026_2">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2026_2" id="SGR_2026_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2026_2">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2026_2" id="CR_2026_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2026_2">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2026_2" id="G_2026_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2026_2">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2026_2" id="CO_2026_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2026_2">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2026_2" id="OR_2026_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2026-3" role="tabpanel" aria-labelledby="tab-2026-3">
                                <div class="form-group m-2">
                                    <label for="ICLD_2026_3">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2026_3" id="ICLD_2026_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2026_3">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2026_3" id="ICDE_2026_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2026_3">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2026_3" id="SGPE_2026_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2026_3">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2026_3" id="SGPS_2026_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2026_3">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2026_3" id="SGPAPSB_2026_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2026_3">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2026_3" id="RPED_2026_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2026_3">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2026_3" id="SGR_2026_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2026_3">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2026_3" id="CR_2026_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2026_3">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2026_3" id="G_2026_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2026_3">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2026_3" id="CO_2026_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2026_3">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2026_3" id="OR_2026_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2026-4" role="tabpanel" aria-labelledby="tab-2026-4">
                                <div class="form-group m-2">
                                    <label for="ICLD_2026_4">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2026_4" id="ICLD_2026_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2026_4">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2026_4" id="ICDE_2026_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2026_4">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2026_4" id="SGPE_2026_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2026_4">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2026_4" id="SGPS_2026_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2026_4">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2026_4" id="SGPAPSB_2026_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2026_4">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2026_4" id="RPED_2026_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2026_4">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2026_4" id="SGR_2026_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2026_4">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2026_4" id="CR_2026_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2026_4">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2026_4" id="G_2026_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2026_4">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2026_4" id="CO_2026_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2026_4">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2026_4" id="OR_2026_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2027-1" role="tabpanel" aria-labelledby="tab-2027-1">
                                <div class="form-group m-2">
                                    <label for="ICLD_2027_1">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2027_1" id="ICLD_2027_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2027_1">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2027_1" id="ICDE_2027_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2027_1">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2027_1" id="SGPE_2027_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2027_1">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2027_1" id="SGPS_2027_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2027_1">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2027_1" id="SGPAPSB_2027_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2027_1">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2027_1" id="RPED_2027_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2027_1">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2027_1" id="SGR_2027_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2027_1">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2027_1" id="CR_2027_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2027_1">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2027_1" id="G_2027_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2027_1">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2027_1" id="CO_2027_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2027_1">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2027_1" id="OR_2027_1" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2027-2" role="tabpanel" aria-labelledby="tab-2027-2">
                                <div class="form-group m-2">
                                    <label for="ICLD_2027_2">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2027_2" id="ICLD_2027_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2027_2">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2027_2" id="ICDE_2027_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2027_2">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2027_2" id="SGPE_2027_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2027_2">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2027_2" id="SGPS_2027_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2027_2">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2027_2" id="SGPAPSB_2027_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2027_2">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2027_2" id="RPED_2027_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2027_2">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2027_2" id="SGR_2027_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2027_2">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2027_2" id="CR_2027_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2027_2">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2027_2" id="G_2027_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2027_2">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2027_2" id="CO_2027_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2027_2">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2027_2" id="OR_2027_2" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2027-3" role="tabpanel" aria-labelledby="tab-2027-3">
                                <div class="form-group m-2">
                                    <label for="ICLD_2027_3">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2027_3" id="ICLD_2027_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2027_3">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2027_3" id="ICDE_2027_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2027_3">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2027_3" id="SGPE_2027_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2027_3">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2027_3" id="SGPS_2027_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2027_3">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2027_3" id="SGPAPSB_2027_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2027_3">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2027_3" id="RPED_2027_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2027_3">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2027_3" id="SGR_2027_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2027_3">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2027_3" id="CR_2027_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2027_3">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2027_3" id="G_2027_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2027_3">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2027_3" id="CO_2027_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2027_3">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2027_3" id="OR_2027_3" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2027-4" role="tabpanel" aria-labelledby="tab-2027-4">
                                <div class="form-group m-2">
                                    <label for="ICLD_2027_4">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2027_4" id="ICLD_2027_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2027_4">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2027_4" id="ICDE_2027_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2027_4">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2027_4" id="SGPE_2027_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2027_4">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2027_4" id="SGPS_2027_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2027_4">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2027_4" id="SGPAPSB_2027_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2027_4">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2027_4" id="RPED_2027_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2027_4">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2027_4" id="SGR_2027_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2027_4">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2027_4" id="CR_2027_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2027_4">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2027_4" id="G_2027_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2027_4">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2027_4" id="CO_2027_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2027_4">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2027_4" id="OR_2027_4" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
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
                            <a class="nav-link active" id="tab-2024-3-consulta" data-toggle="tab" href="#content-2024-3-consulta" role="tab" aria-controls="content-2024-3-consulta" aria-selected="true">2024_3</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2024-4-consulta" data-toggle="tab" href="#content-2024-4-consulta" role="tab" aria-controls="content-2024-4-consulta" aria-selected="false">2024_4</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2025-1-consulta" data-toggle="tab" href="#content-2025-1-consulta" role="tab" aria-controls="content-2025-1-consulta" aria-selected="false">2025_1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2025-2-consulta" data-toggle="tab" href="#content-2025-2-consulta" role="tab" aria-controls="content-2025-2-consulta" aria-selected="false">2025_2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2025-3-consulta" data-toggle="tab" href="#content-2025-3-consulta" role="tab" aria-controls="content-2025-3-consulta" aria-selected="false">2025_3</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2025-4-consulta" data-toggle="tab" href="#content-2025-4-consulta" role="tab" aria-controls="content-2025-4-consulta" aria-selected="false">2025_4</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2026-1-consulta" data-toggle="tab" href="#content-2026-1-consulta" role="tab" aria-controls="content-2026-1-consulta" aria-selected="false">2026_1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2026-2-consulta" data-toggle="tab" href="#content-2026-2-consulta" role="tab" aria-controls="content-2026-2-consulta" aria-selected="false">2026_2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2026-3-consulta" data-toggle="tab" href="#content-2026-3-consulta" role="tab" aria-controls="content-2026-3-consulta" aria-selected="false">2026_3</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2026-4-consulta" data-toggle="tab" href="#content-2026-4-consulta" role="tab" aria-controls="content-2026-4-consulta" aria-selected="false">2026_4</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2027-1-consulta" data-toggle="tab" href="#content-2027-1-consulta" role="tab" aria-controls="content-2027-1-consulta" aria-selected="false">2027_1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2027-2-consulta" data-toggle="tab" href="#content-2027-2-consulta" role="tab" aria-controls="content-2027-2-consulta" aria-selected="false">2027_2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2027-3-consulta" data-toggle="tab" href="#content-2027-3-consulta" role="tab" aria-controls="content-2027-3-consulta" aria-selected="false">2027_3</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2027-4-consulta" data-toggle="tab" href="#content-2027-4-consulta" role="tab" aria-controls="content-2027-4-consulta" aria-selected="false">2027_4</a>
                        </li>
                    </ul>

                    <!-- Contenido de las pestañas -->
                    <div class="tab-content mt-3" id="tab-content-programacion">
                        <!-- Contenido para 2024 -->
                        <div class="tab-pane fade show active" id="content-2024-3-consulta" role="tabpanel" aria-labelledby="tab-2024-3-consulta">
                            <p><strong>ICDL: </strong><span id="2"></span></p>
                            <p><strong>ICDE: </strong><span id="3"></span></p>
                            <p><strong>SGP Educación: </strong><span id="4"></span></p>
                            <p><strong>SGP Salud: </strong><span id="5"></span></p>
                            <p><strong>SGP APSB: </strong><span id="6"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="7"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="8"></span></p>
                            <p><strong>Crédito: </strong><span id="9"></span></p>
                            <p><strong>Gestión: </strong><span id="10"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="11"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="12"></span></p>
                        </div>
                        <div class="tab-pane fade" id="content-2024-4-consulta" role="tabpanel" aria-labelledby="tab-2024-4-consulta">
                            <p><strong>ICDL: </strong><span id="13"></span></p>
                            <p><strong>ICDE: </strong><span id="14"></span></p>
                            <p><strong>SGP Educación: </strong><span id="15"></span></p>
                            <p><strong>SGP Salud: </strong><span id="16"></span></p>
                            <p><strong>SGP APSB: </strong><span id="17"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="18"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="19"></span></p>
                            <p><strong>Crédito: </strong><span id="20"></span></p>
                            <p><strong>Gestión: </strong><span id="21"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="22"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="23"></span></p>
                        </div>
                        <div class="tab-pane fade" id="content-2025-1-consulta" role="tabpanel" aria-labelledby="tab-2025-1-consulta">
                            <p><strong>ICDL: </strong><span id="24"></span></p>
                            <p><strong>ICDE: </strong><span id="25"></span></p>
                            <p><strong>SGP Educación: </strong><span id="26"></span></p>
                            <p><strong>SGP Salud: </strong><span id="27"></span></p>
                            <p><strong>SGP APSB: </strong><span id="28"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="29"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="30"></span></p>
                            <p><strong>Crédito: </strong><span id="31"></span></p>
                            <p><strong>Gestión: </strong><span id="32"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="33"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="34"></span></p>
                        </div>
                        <div class="tab-pane fade" id="content-2025-2-consulta" role="tabpanel" aria-labelledby="tab-2025-2-consulta">
                            <p><strong>ICDL: </strong><span id="35"></span></p>
                            <p><strong>ICDE: </strong><span id="36"></span></p>
                            <p><strong>SGP Educación: </strong><span id="37"></span></p>
                            <p><strong>SGP Salud: </strong><span id="38"></span></p>
                            <p><strong>SGP APSB: </strong><span id="39"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="40"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="41"></span></p>
                            <p><strong>Crédito: </strong><span id="42"></span></p>
                            <p><strong>Gestión: </strong><span id="43"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="44"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="45"></span></p>
                        </div>
                        <div class="tab-pane fade" id="content-2025-3-consulta" role="tabpanel" aria-labelledby="tab-2025-3-consulta">
                            <p><strong>ICDL: </strong><span id="46"></span></p>
                            <p><strong>ICDE: </strong><span id="47"></span></p>
                            <p><strong>SGP Educación: </strong><span id="48"></span></p>
                            <p><strong>SGP Salud: </strong><span id="49"></span></p>
                            <p><strong>SGP APSB: </strong><span id="50"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="51"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="52"></span></p>
                            <p><strong>Crédito: </strong><span id="53"></span></p>
                            <p><strong>Gestión: </strong><span id="54"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="55"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="56"></span></p>
                        </div>
                        <div class="tab-pane fade" id="content-2025-4-consulta" role="tabpanel" aria-labelledby="tab-2025-4-consulta">
                            <p><strong>ICDL: </strong><span id="57"></span></p>
                            <p><strong>ICDE: </strong><span id="58"></span></p>
                            <p><strong>SGP Educación: </strong><span id="59"></span></p>
                            <p><strong>SGP Salud: </strong><span id="60"></span></p>
                            <p><strong>SGP APSB: </strong><span id="61"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="62"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="63"></span></p>
                            <p><strong>Crédito: </strong><span id="64"></span></p>
                            <p><strong>Gestión: </strong><span id="65"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="66"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="67"></span></p>
                        </div>
                        <div class="tab-pane fade" id="content-2026-1-consulta" role="tabpanel" aria-labelledby="tab-2026-1-consulta">
                            <p><strong>ICDL: </strong><span id="68"></span></p>
                            <p><strong>ICDE: </strong><span id="69"></span></p>
                            <p><strong>SGP Educación: </strong><span id="70"></span></p>
                            <p><strong>SGP Salud: </strong><span id="71"></span></p>
                            <p><strong>SGP APSB: </strong><span id="72"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="73"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="74"></span></p>
                            <p><strong>Crédito: </strong><span id="75"></span></p>
                            <p><strong>Gestión: </strong><span id="76"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="77"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="78"></span></p>
                        </div>
                        <div class="tab-pane fade" id="content-2026-2-consulta" role="tabpanel" aria-labelledby="tab-2026-2-consulta">
                            <p><strong>ICDL: </strong><span id="79"></span></p>
                            <p><strong>ICDE: </strong><span id="80"></span></p>
                            <p><strong>SGP Educación: </strong><span id="81"></span></p>
                            <p><strong>SGP Salud: </strong><span id="82"></span></p>
                            <p><strong>SGP APSB: </strong><span id="83"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="84"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="85"></span></p>
                            <p><strong>Crédito: </strong><span id="86"></span></p>
                            <p><strong>Gestión: </strong><span id="87"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="88"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="89"></span></p>
                        </div>
                        <div class="tab-pane fade" id="content-2026-3-consulta" role="tabpanel" aria-labelledby="tab-2026-3-consulta">
                            <p><strong>ICDL: </strong><span id="90"></span></p>
                            <p><strong>ICDE: </strong><span id="91"></span></p>
                            <p><strong>SGP Educación: </strong><span id="92"></span></p>
                            <p><strong>SGP Salud: </strong><span id="93"></span></p>
                            <p><strong>SGP APSB: </strong><span id="94"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="95"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="96"></span></p>
                            <p><strong>Crédito: </strong><span id="97"></span></p>
                            <p><strong>Gestión: </strong><span id="98"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="99"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="100"></span></p>
                        </div>
                        <div class="tab-pane fade" id="content-2026-4-consulta" role="tabpanel" aria-labelledby="tab-2026-4-consulta">
                            <p><strong>ICDL: </strong><span id="101"></span></p>
                            <p><strong>ICDE: </strong><span id="102"></span></p>
                            <p><strong>SGP Educación: </strong><span id="103"></span></p>
                            <p><strong>SGP Salud: </strong><span id="104"></span></p>
                            <p><strong>SGP APSB: </strong><span id="105"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="106"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="107"></span></p>
                            <p><strong>Crédito: </strong><span id="108"></span></p>
                            <p><strong>Gestión: </strong><span id="109"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="110"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="111"></span></p>
                        </div>
                        <div class="tab-pane fade" id="content-2027-1-consulta" role="tabpanel" aria-labelledby="tab-2027-1-consulta">
                            <p><strong>ICDL: </strong><span id="112"></span></p>
                            <p><strong>ICDE: </strong><span id="113"></span></p>
                            <p><strong>SGP Educación: </strong><span id="114"></span></p>
                            <p><strong>SGP Salud: </strong><span id="115"></span></p>
                            <p><strong>SGP APSB: </strong><span id="116"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="117"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="118"></span></p>
                            <p><strong>Crédito: </strong><span id="119"></span></p>
                            <p><strong>Gestión: </strong><span id="120"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="121"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="122"></span></p>
                        </div>
                        <div class="tab-pane fade" id="content-2027-2-consulta" role="tabpanel" aria-labelledby="tab-2027-2-consulta">
                            <p><strong>ICDL: </strong><span id="123"></span></p>
                            <p><strong>ICDE: </strong><span id="124"></span></p>
                            <p><strong>SGP Educación: </strong><span id="125"></span></p>
                            <p><strong>SGP Salud: </strong><span id="126"></span></p>
                            <p><strong>SGP APSB: </strong><span id="127"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="128"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="129"></span></p>
                            <p><strong>Crédito: </strong><span id="130"></span></p>
                            <p><strong>Gestión: </strong><span id="131"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="132"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="133"></span></p>
                        </div>
                        <div class="tab-pane fade" id="content-2027-3-consulta" role="tabpanel" aria-labelledby="tab-2027-3-consulta">
                            <p><strong>ICDL: </strong><span id="134"></span></p>
                            <p><strong>ICDE: </strong><span id="135"></span></p>
                            <p><strong>SGP Educación: </strong><span id="136"></span></p>
                            <p><strong>SGP Salud: </strong><span id="137"></span></p>
                            <p><strong>SGP APSB: </strong><span id="138"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="139"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="140"></span></p>
                            <p><strong>Crédito: </strong><span id="141"></span></p>
                            <p><strong>Gestión: </strong><span id="142"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="143"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="144"></span></p>
                        </div>
                        <div class="tab-pane fade" id="content-2027-4-consulta" role="tabpanel" aria-labelledby="tab-2027-4-consulta">
                            <p><strong>ICDL: </strong><span id="145"></span></p>
                            <p><strong>ICDE: </strong><span id="146"></span></p>
                            <p><strong>SGP Educación: </strong><span id="147"></span></p>
                            <p><strong>SGP Salud: </strong><span id="148"></span></p>
                            <p><strong>SGP APSB: </strong><span id="149"></span></p>
                            <p><strong>Sistema General de Regalías: </strong><span id="150"></span></p>
                            <p><strong>Recursos Própios Descentralizados: </strong><span id="151"></span></p>
                            <p><strong>Crédito: </strong><span id="152"></span></p>
                            <p><strong>Gestión: </strong><span id="153"></span></p>
                            <p><strong>Cofinanciación: </strong><span id="154"></span></p>
                            <p><strong>Otros Recursos: </strong><span id="155"></span></p>
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
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Datos de la Programación Financiera</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizarprofin') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="id_ip" id="id_ip">
                        <!-- Pestañas de navegación -->
                        <ul class="nav nav-tabs" id="tab-programacion" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-2024-3-editar" data-toggle="tab" href="#content-2024-3-editar" role="tab" aria-controls="content-2024-3-editar" aria-selected="true">2024_3</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2024-4-editar" data-toggle="tab" href="#content-2024-4-editar" role="tab" aria-controls="content-2024-4-editar" aria-selected="false">2024_4</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2025-1-editar" data-toggle="tab" href="#content-2025-1-editar" role="tab" aria-controls="content-2025-1-editar" aria-selected="false">2025_1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2025-2-editar" data-toggle="tab" href="#content-2025-2-editar" role="tab" aria-controls="content-2025-2-editar" aria-selected="false">2025_2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2025-3-editar" data-toggle="tab" href="#content-2025-3-editar" role="tab" aria-controls="content-2025-3-editar" aria-selected="false">2025_3</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2025-4-editar" data-toggle="tab" href="#content-2025-4-editar" role="tab" aria-controls="content-2025-4-editar" aria-selected="false">2025_4</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2026-1-editar" data-toggle="tab" href="#content-2026-1-editar" role="tab" aria-controls="content-2026-1-editar" aria-selected="false">2026_1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2026-2-editar" data-toggle="tab" href="#content-2026-2-editar" role="tab" aria-controls="content-2026-2-editar" aria-selected="false">2026_2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2026-3-editar" data-toggle="tab" href="#content-2026-3-editar" role="tab" aria-controls="content-2026-3-editar" aria-selected="false">2026_3</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2026-4-editar" data-toggle="tab" href="#content-2026-4-editar" role="tab" aria-controls="content-2026-4-editar" aria-selected="false">2026_4</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2027-1-editar" data-toggle="tab" href="#content-2027-1-editar" role="tab" aria-controls="content-2027-1-editar" aria-selected="false">2027_1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2027-2-editar" data-toggle="tab" href="#content-2027-2-editar" role="tab" aria-controls="content-2027-2-editar" aria-selected="false">2027_2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2027-3-editar" data-toggle="tab" href="#content-2027-3-editar" role="tab" aria-controls="content-2027-3-editar" aria-selected="false">2027_3</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2027-4-editar" data-toggle="tab" href="#content-2027-4-editar" role="tab" aria-controls="content-2027-4-editar" aria-selected="false">2027_4</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-estado" data-toggle="tab" href="#content-estado" role="tab" aria-controls="content-estado" aria-selected="false">Estado</a>
                            </li>
                        </ul>
    
                        <!-- Contenido de las pfstañas -->
                        <div class="tab-content mt-3" id="tab-content-programacion">
                            <!-- Contenido para 2024 -->
                            <div class="tab-pane fade show active" id="content-2024-3-editar" role="tabpanel" aria-labelledby="tab-2024-3-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2024_3">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2024_3" id="ICLD_2024_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2024_3">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2024_3" id="ICDE_2024_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2024_3">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2024_3" id="SGPE_2024_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2024_3">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2024_3" id="SGPS_2024_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2024_3">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2024_3" id="SGPAPSB_2024_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2024_3">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2024_3" id="RPED_2024_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2024_3">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2024_3" id="SGR_2024_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2024_3">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2024_3" id="CR_2024_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2024_3">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2024_3" id="G_2024_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2024_3">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2024_3" id="CO_2024_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2024_3">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2024_3" id="OR_2024_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2024-4-editar" role="tabpanel" aria-labelledby="tab-2024-4-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2024_4">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2024_4" id="ICLD_2024_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2024_4">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2024_4" id="ICDE_2024_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2024_4">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2024_4" id="SGPE_2024_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2024_4">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2024_4" id="SGPS_2024_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2024_4">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2024_4" id="SGPAPSB_2024_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2024_4">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2024_4" id="RPED_2024_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2024_4">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2024_4" id="SGR_2024_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2024_4">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2024_4" id="CR_2024_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2024_4">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2024_4" id="G_2024_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2024_4">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2024_4" id="CO_2024_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2024_4">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2024_4" id="OR_2024_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2025-1_editar" role="tabpanel" aria-labelledby="tab-2025-1-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2025_1">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2025_1" id="ICLD_2025_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2025_1">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2025_1" id="ICDE_2025_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2025_1">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2025_1" id="SGPE_2025_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2025_1">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2025_1" id="SGPS_2025_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2025_1">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2025_1" id="SGPAPSB_2025_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2025_1">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2025_1" id="RPED_2025_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2025_1">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2025_1" id="SGR_2025_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2025_1">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2025_1" id="CR_2025_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2025_1">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2025_1" id="G_2025_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2025_1">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2025_1" id="CO_2025_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2025_1">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2025_1" id="OR_2025_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2025-2-editar" role="tabpanel" aria-labelledby="tab-2025-2-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2025_2">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2025_2" id="ICLD_2025_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2025_2">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2025_2" id="ICDE_2025_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2025_2">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2025_2" id="SGPE_2025_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2025_2">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2025_2" id="SGPS_2025_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2025_2">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2025_2" id="SGPAPSB_2025_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2025_2">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2025_2" id="RPED_2025_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2025_2">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2025_2" id="SGR_2025_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2025_2">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2025_2" id="CR_2025_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2025_2">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2025_2" id="G_2025_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2025_2">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2025_2" id="CO_2025_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2025_2">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2025_2" id="OR_2025_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2025-3-editar" role="tabpanel" aria-labelledby="tab-2025-3-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2025_3">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2025_3" id="ICLD_2025_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2025_3">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2025_3" id="ICDE_2025_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2025_3">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2025_3" id="SGPE_2025_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2025_3">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2025_3" id="SGPS_2025_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2025_3">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2025_3" id="SGPAPSB_2025_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2025_3">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2025_3" id="RPED_2025_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2025_3">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2025_3" id="SGR_2025_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2025_3">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2025_3" id="CR_2025_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2025_3">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2025_3" id="G_2025_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2025_3">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2025_3" id="CO_2025_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2025_3">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2025_3" id="OR_2025_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2025-4-editar" role="tabpanel" aria-labelledby="tab-2025-4-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2025_4">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2025_4" id="ICLD_2025_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2025_4">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2025_4" id="ICDE_2025_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2025_4">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2025_4" id="SGPE_2025_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2025_4">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2025_4" id="SGPS_2025_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2025_4">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2025_4" id="SGPAPSB_2025_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2025_4">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2025_4" id="RPED_2025_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2025_4">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2025_4" id="SGR_2025_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2025_4">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2025_4" id="CR_2025_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2025_4">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2025_4" id="G_2025_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2025_4">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2025_4" id="CO_2025_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2025_4">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2025_4" id="OR_2025_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2026-1-editar" role="tabpanel" aria-labelledby="tab-2026-1-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2026_1">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2026_1" id="ICLD_2026_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2026_1">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2026_1" id="ICDE_2026_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2026_1">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2026_1" id="SGPE_2026_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2026_1">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2026_1" id="SGPS_2026_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2026_1">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2026_1" id="SGPAPSB_2026_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2026_1">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2026_1" id="RPED_2026_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2026_1">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2026_1" id="SGR_2026_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2026_1">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2026_1" id="CR_2026_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2026_1">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2026_1" id="G_2026_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2026_1">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2026_1" id="CO_2026_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2026_1">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2026_1" id="OR_2026_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2026-2-editar" role="tabpanel" aria-labelledby="tab-2026-2-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2026_2">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2026_2" id="ICLD_2026_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2026_2">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2026_2" id="ICDE_2026_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2026_2">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2026_2" id="SGPE_2026_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2026_2">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2026_2" id="SGPS_2026_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2026_2">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2026_2" id="SGPAPSB_2026_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2026_2">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2026_2" id="RPED_2026_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2026_2">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2026_2" id="SGR_2026_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2026_2">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2026_2" id="CR_2026_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2026_2">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2026_2" id="G_2026_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2026_2">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2026_2" id="CO_2026_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2026_2">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2026_2" id="OR_2026_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2026-3-editar" role="tabpanel" aria-labelledby="tab-2026-3-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2026_3">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2026_3" id="ICLD_2026_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2026_3">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2026_3" id="ICDE_2026_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2026_3">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2026_3" id="SGPE_2026_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2026_3">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2026_3" id="SGPS_2026_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2026_3">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2026_3" id="SGPAPSB_2026_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2026_3">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2026_3" id="RPED_2026_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2026_3">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2026_3" id="SGR_2026_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2026_3">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2026_3" id="CR_2026_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2026_3">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2026_3" id="G_2026_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2026_3">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2026_3" id="CO_2026_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2026_3">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2026_3" id="OR_2026_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2026-4-editar" role="tabpanel" aria-labelledby="tab-2026-4-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2026_4">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2026_4" id="ICLD_2026_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2026_4">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2026_4" id="ICDE_2026_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2026_4">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2026_4" id="SGPE_2026_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2026_4">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2026_4" id="SGPS_2026_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2026_4">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2026_4" id="SGPAPSB_2026_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2026_4">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2026_4" id="RPED_2026_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2026_4">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2026_4" id="SGR_2026_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2026_4">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2026_4" id="CR_2026_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2026_4">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2026_4" id="G_2026_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2026_4">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2026_4" id="CO_2026_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2026_4">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2026_4" id="OR_2026_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2027-1-editar" role="tabpanel" aria-labelledby="tab-2027-1-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2027_1">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2027_1" id="ICLD_2027_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2027_1">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2027_1" id="ICDE_2027_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2027_1">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2027_1" id="SGPE_2027_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2027_1">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2027_1" id="SGPS_2027_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2027_1">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2027_1" id="SGPAPSB_2027_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2027_1">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2027_1" id="RPED_2027_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2027_1">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2027_1" id="SGR_2027_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2027_1">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2027_1" id="CR_2027_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2027_1">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2027_1" id="G_2027_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2027_1">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2027_1" id="CO_2027_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2027_1">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2027_1" id="OR_2027_1_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2027-2_editar" role="tabpanel" aria-labelledby="tab-2027-2-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2027_2">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2027_2" id="ICLD_2027_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2027_2">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2027_2" id="ICDE_2027_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2027_2">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2027_2" id="SGPE_2027_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2027_2">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2027_2" id="SGPS_2027_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2027_2">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2027_2" id="SGPAPSB_2027_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2027_2">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2027_2" id="RPED_2027_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2027_2">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2027_2" id="SGR_2027_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2027_2">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2027_2" id="CR_2027_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2027_2">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2027_2" id="G_2027_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2027_2">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2027_2" id="CO_2027_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2027_2">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2027_2" id="OR_2027_2_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2027-3-editar" role="tabpanel" aria-labelledby="tab-2027-3-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2027_3">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2027_3" id="ICLD_2027_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2027_3">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2027_3" id="ICDE_2027_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2027_3">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2027_3" id="SGPE_2027_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2027_3">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2027_3" id="SGPS_2027_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2027_3">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2027_3" id="SGPAPSB_2027_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2027_3">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2027_3" id="RPED_2027_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2027_3">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2027_3" id="SGR_2027_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2027_3">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2027_3" id="CR_2027_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2027_3">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2027_3" id="G_2027_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2027_3">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2027_3" id="CO_2027_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2027_3">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2027_3" id="OR_2027_3_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="content-2027-4-editar" role="tabpanel" aria-labelledby="tab-2027-4-editar">
                                <div class="form-group m-2">
                                    <label for="ICLD_2027_4">ICLD <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICLD_2027_4" id="ICLD_2027_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="ICDE_2027_4">ICDE <b class="text-danger"> * </b></label>
                                    <input type="text" name="ICDE_2027_4" id="ICDE_2027_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPE_2027_4">SGP Educación <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPE_2027_4" id="SGPE_2027_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPS_2027_4">SGP Salud <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPS_2027_4" id="SGPS_2027_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGPAPSB_2027_4">SGP APSB <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGPAPSB_2027_4" id="SGPAPSB_2027_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="RPED_2027_4">Recursos Própios Descentralizados <b class="text-danger"> * </b></label>
                                    <input type="text" name="RPED_2027_4" id="RPED_2027_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="SGR_2027_4">Sistema General de Regalias <b class="text-danger"> * </b></label>
                                    <input type="text" name="SGR_2027_4" id="SGR_2027_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CR_2027_4">Créditos <b class="text-danger"> * </b></label>
                                    <input type="text" name="CR_2027_4" id="CR_2027_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="G_2027_4">Gestión <b class="text-danger"> * </b></label>
                                    <input type="text" name="G_2027_4" id="G_2027_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="CO_2027_4">Cofinanciación <b class="text-danger"> * </b></label>
                                    <input type="text" name="CO_2027_4" id="CO_2027_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
                                <div class="form-group m-2">
                                    <label for="OR_2027_4">Otros Recursos <b class="text-danger"> * </b></label>
                                    <input type="text" name="OR_2027_4" id="OR_2027_4_editar" value="0" class="form-control"
                                        placeholder="Digite la Programación" required>
                                </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Cargar Programaciones Financieras (Archivo CSV)</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('csvprofins') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <!-- Botón pfrsonalizado -->
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
            $('#profin').DataTable({
                paging: true, // Activar paginación
                searching: true, // Activar barra de búsqueda
                ordering: true, // Activar ordenación de columnas
                pagingTypf: 'full_numbers', // Pagina completa: << < 1 2 3 > >>
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
            var url = "{{ route('verprofin', ['id' => ':id']) }}";
            url = url.replace(':id', ProIdId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#tab-2024-3-consulta').tab('show');
                    $('#1').text(data.indproducto.codigo_ip + '. ' + data.indproducto.nombre_ip); 
                    $('#2').text(data.ICLD_2024_3);
                    $('#3').text(data.ICDE_2024_3);
                    $('#4').text(data.SGPE_2024_3);
                    $('#5').text(data.SGPS_2024_3);
                    $('#6').text(data.SGPAPSB_2024_3);
                    $('#7').text(data.RPED_2024_3);
                    $('#8').text(data.SGR_2024_3);
                    $('#9').text(data.CR_2024_3);
                    $('#10').text(data.G_2024_3);
                    $('#11').text(data.CO_2024_3);
                    $('#12').text(data.OR_2024_3);
                    $('#13').text(data.ICLD_2024_4);
                    $('#14').text(data.ICDE_2024_4);
                    $('#15').text(data.SGPE_2024_4);
                    $('#16').text(data.SGPS_2024_4);
                    $('#17').text(data.SGPAPSB_2024_4);
                    $('#18').text(data.RPED_2024_4);
                    $('#19').text(data.SGR_2024_4);
                    $('#20').text(data.CR_2024_4);
                    $('#21').text(data.G_2024_4);
                    $('#22').text(data.CO_2024_4);
                    $('#23').text(data.OR_2024_4);
                    $('#24').text(data.ICLD_2025_1);
                    $('#25').text(data.ICDE_2025_1);
                    $('#26').text(data.SGPE_2025_1);
                    $('#27').text(data.SGPS_2025_1);
                    $('#28').text(data.SGPAPSB_2025_1);
                    $('#29').text(data.RPED_2025_1);
                    $('#30').text(data.SGR_2025_1);
                    $('#31').text(data.CR_2025_1);
                    $('#32').text(data.G_2025_1);
                    $('#33').text(data.CO_2025_1);
                    $('#34').text(data.OR_2025_1);
                    $('#35').text(data.ICLD_2025_2);
                    $('#36').text(data.ICDE_2025_2);
                    $('#37').text(data.SGPE_2025_2);
                    $('#38').text(data.SGPS_2025_2);
                    $('#39').text(data.SGPAPSB_2025_2);
                    $('#40').text(data.RPED_2025_2);
                    $('#41').text(data.SGR_2025_2);
                    $('#42').text(data.CR_2025_2);
                    $('#43').text(data.G_2025_2);
                    $('#44').text(data.CO_2025_2);
                    $('#45').text(data.OR_2025_2);
                    $('#46').text(data.ICLD_2025_3);
                    $('#47').text(data.ICDE_2025_3);
                    $('#48').text(data.SGPE_2025_3);
                    $('#49').text(data.SGPS_2025_3);
                    $('#50').text(data.SGPAPSB_2025_3);
                    $('#51').text(data.RPED_2025_3);
                    $('#52').text(data.SGR_2025_3);
                    $('#53').text(data.CR_2025_3);
                    $('#54').text(data.G_2025_3);
                    $('#55').text(data.CO_2025_3);
                    $('#56').text(data.OR_2025_3);
                    $('#57').text(data.ICLD_2025_4);
                    $('#58').text(data.ICDE_2025_4);
                    $('#59').text(data.SGPE_2025_4);
                    $('#60').text(data.SGPS_2025_4);
                    $('#61').text(data.SGPAPSB_2025_4);
                    $('#62').text(data.RPED_2025_4);
                    $('#63').text(data.SGR_2025_4);
                    $('#64').text(data.CR_2025_4);
                    $('#65').text(data.G_2025_4);
                    $('#66').text(data.CO_2025_4);
                    $('#67').text(data.OR_2025_4);
                    $('#68').text(data.ICLD_2026_1);
                    $('#69').text(data.ICDE_2026_1);
                    $('#70').text(data.SGPE_2026_1);
                    $('#71').text(data.SGPS_2026_1);
                    $('#72').text(data.SGPAPSB_2026_1);
                    $('#73').text(data.RPED_2026_1);
                    $('#74').text(data.SGR_2026_1);
                    $('#75').text(data.CR_2026_1);
                    $('#76').text(data.G_2026_1);
                    $('#77').text(data.CO_2026_1);
                    $('#78').text(data.OR_2026_1);
                    $('#79').text(data.ICLD_2026_2);
                    $('#80').text(data.ICDE_2026_2);
                    $('#81').text(data.SGPE_2026_2);
                    $('#82').text(data.SGPS_2026_2);
                    $('#83').text(data.SGPAPSB_2026_2);
                    $('#84').text(data.RPED_2026_2);
                    $('#85').text(data.SGR_2026_2);
                    $('#86').text(data.CR_2026_2);
                    $('#87').text(data.G_2026_2);
                    $('#88').text(data.CO_2026_2);
                    $('#89').text(data.OR_2026_2);
                    $('#90').text(data.ICLD_2026_3);
                    $('#91').text(data.ICDE_2026_3);
                    $('#92').text(data.SGPE_2026_3);
                    $('#93').text(data.SGPS_2026_3);
                    $('#94').text(data.SGPAPSB_2026_3);
                    $('#95').text(data.RPED_2026_3);
                    $('#96').text(data.SGR_2026_3);
                    $('#97').text(data.CR_2026_3);
                    $('#98').text(data.G_2026_3);
                    $('#99').text(data.CO_2026_3);
                    $('#100').text(data.OR_2026_3);
                    $('#101').text(data.ICLD_2026_4);
                    $('#102').text(data.ICDE_2026_4);
                    $('#103').text(data.SGPE_2026_4);
                    $('#104').text(data.SGPS_2026_4);
                    $('#105').text(data.SGPAPSB_2026_4);
                    $('#106').text(data.RPED_2026_4);
                    $('#107').text(data.SGR_2026_4);
                    $('#108').text(data.CR_2026_4);
                    $('#109').text(data.G_2026_4);
                    $('#110').text(data.CO_2026_4);
                    $('#111').text(data.OR_2026_4);
                    $('#112').text(data.ICLD_2027_1);
                    $('#113').text(data.ICDE_2027_1);
                    $('#114').text(data.SGPE_2027_1);
                    $('#115').text(data.SGPS_2027_1);
                    $('#116').text(data.SGPAPSB_2027_1);
                    $('#117').text(data.RPED_2027_1);
                    $('#118').text(data.SGR_2027_1);
                    $('#119').text(data.CR_2027_1);
                    $('#120').text(data.G_2027_1);
                    $('#121').text(data.CO_2027_1);
                    $('#122').text(data.OR_2027_1);
                    $('#123').text(data.ICLD_2027_2);
                    $('#124').text(data.ICDE_2027_2);
                    $('#125').text(data.SGPE_2027_2);
                    $('#126').text(data.SGPS_2027_2);
                    $('#127').text(data.SGPAPSB_2027_2);
                    $('#128').text(data.RPED_2027_2);
                    $('#129').text(data.SGR_2027_2);
                    $('#130').text(data.CR_2027_2);
                    $('#131').text(data.G_2027_2);
                    $('#132').text(data.CO_2027_2);
                    $('#133').text(data.OR_2027_2);
                    $('#134').text(data.ICLD_2027_3);
                    $('#135').text(data.ICDE_2027_3);
                    $('#136').text(data.SGPE_2027_3);
                    $('#137').text(data.SGPS_2027_3);
                    $('#138').text(data.SGPAPSB_2027_3);
                    $('#139').text(data.RPED_2027_3);
                    $('#140').text(data.SGR_2027_3);
                    $('#141').text(data.CR_2027_3);
                    $('#142').text(data.G_2027_3);
                    $('#143').text(data.CO_2027_3);
                    $('#144').text(data.OR_2027_3);
                    $('#145').text(data.ICLD_2027_4);
                    $('#146').text(data.ICDE_2027_4);
                    $('#147').text(data.SGPE_2027_4);
                    $('#148').text(data.SGPS_2027_4);
                    $('#149').text(data.SGPAPSB_2027_4);
                    $('#150').text(data.RPED_2027_4);
                    $('#151').text(data.SGR_2027_4);
                    $('#152').text(data.CR_2027_4);
                    $('#153').text(data.G_2027_4);
                    $('#154').text(data.CO_2027_4);
                    $('#155').text(data.OR_2027_4);
                    $('#verestado').text(data.estado_pf).removeClass().addClass('badge').addClass(data.estado_pf === 'Activo' ? 'bg-success' : 'bg-danger');
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
            var url = "{{ route('editarprofin', ['id' => ':id']) }}";
            url = url.replace(':id', ProIdId);
            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    $('#id').val(data.id);
                    $('#id_ip').val(data.id_ip);
                    $('#ICLD_2024_3_editar').val(data.ICLD_2024_3);
                    $('#ICDE_2024_3_editar').val(data.ICDE_2024_3);
                    $('#SGPE_2024_3_editar').val(data.SGPE_2024_3);
                    $('#SGPS_2024_3_editar').val(data.SGPS_2024_3);
                    $('#SGPAPSB_2024_3_editar').val(data.SGPAPSB_2024_3);
                    $('#RPED_2024_3_editar').val(data.RPED_2024_3);
                    $('#SGR_2024_3_editar').val(data.SGR_2024_3);
                    $('#CR_2024_3_editar').val(data.CR_2024_3);
                    $('#G_2024_3_editar').val(data.G_2024_3);
                    $('#CO_2024_3_editar').val(data.CO_2024_3);
                    $('#OR_2024_3_editar').val(data.OR_2024_3);
                    $('#ICLD_2024_4_editar').val(data.ICLD_2024_4);
                    $('#ICDE_2024_4_editar').val(data.ICDE_2024_4);
                    $('#SGPE_2024_4_editar').val(data.SGPE_2024_4);
                    $('#SGPS_2024_4_editar').val(data.SGPS_2024_4);
                    $('#SGPAPSB_2024_4_editar').val(data.SGPAPSB_2024_4);
                    $('#RPED_2024_4_editar').val(data.RPED_2024_4);
                    $('#SGR_2024_4_editar').val(data.SGR_2024_4);
                    $('#CR_2024_4_editar').val(data.CR_2024_4);
                    $('#G_2024_4_editar').val(data.G_2024_4);
                    $('#CO_2024_4_editar').val(data.CO_2024_4);
                    $('#OR_2024_4_editar').val(data.OR_2024_4);
                    $('#ICLD_2025_1_editar').val(data.ICLD_2025_1);
                    $('#ICDE_2025_1_editar').val(data.ICDE_2025_1);
                    $('#SGPE_2025_1_editar').val(data.SGPE_2025_1);
                    $('#SGPS_2025_1_editar').val(data.SGPS_2025_1);
                    $('#SGPAPSB_2025_1_editar').val(data.SGPAPSB_2025_1);
                    $('#RPED_2025_1_editar').val(data.RPED_2025_1);
                    $('#SGR_2025_1_editar').val(data.SGR_2025_1);
                    $('#CR_2025_1_editar').val(data.CR_2025_1);
                    $('#G_2025_1_editar').val(data.G_2025_1);
                    $('#CO_2025_1_editar').val(data.CO_2025_1);
                    $('#OR_2025_1_editar').val(data.OR_2025_1);
                    $('#ICLD_2025_2_editar').val(data.ICLD_2025_2);
                    $('#ICDE_2025_2_editar').val(data.ICDE_2025_2);
                    $('#SGPE_2025_2_editar').val(data.SGPE_2025_2);
                    $('#SGPS_2025_2_editar').val(data.SGPS_2025_2);
                    $('#SGPAPSB_2025_2_editar').val(data.SGPAPSB_2025_2);
                    $('#RPED_2025_2_editar').val(data.RPED_2025_2);
                    $('#SGR_2025_2_editar').val(data.SGR_2025_2);
                    $('#CR_2025_2_editar').val(data.CR_2025_2);
                    $('#G_2025_2_editar').val(data.G_2025_2);
                    $('#CO_2025_2_editar').val(data.CO_2025_2);
                    $('#OR_2025_2_editar').val(data.OR_2025_2);
                    $('#ICLD_2025_3_editar').val(data.ICLD_2025_3);
                    $('#ICDE_2025_3_editar').val(data.ICDE_2025_3);
                    $('#SGPE_2025_3_editar').val(data.SGPE_2025_3);
                    $('#SGPS_2025_3_editar').val(data.SGPS_2025_3);
                    $('#SGPAPSB_2025_3_editar').val(data.SGPAPSB_2025_3);
                    $('#RPED_2025_3_editar').val(data.RPED_2025_3);
                    $('#SGR_2025_3_editar').val(data.SGR_2025_3);
                    $('#CR_2025_3_editar').val(data.CR_2025_3);
                    $('#G_2025_3_editar').val(data.G_2025_3);
                    $('#CO_2025_3_editar').val(data.CO_2025_3);
                    $('#OR_2025_3_editar').val(data.OR_2025_3);
                    $('#ICLD_2025_4_editar').val(data.ICLD_2025_4);
                    $('#ICDE_2025_4_editar').val(data.ICDE_2025_4);
                    $('#SGPE_2025_4_editar').val(data.SGPE_2025_4);
                    $('#SGPS_2025_4_editar').val(data.SGPS_2025_4);
                    $('#SGPAPSB_2025_4_editar').val(data.SGPAPSB_2025_4);
                    $('#RPED_2025_4_editar').val(data.RPED_2025_4);
                    $('#SGR_2025_4_editar').val(data.SGR_2025_4);
                    $('#CR_2025_4_editar').val(data.CR_2025_4);
                    $('#G_2025_4_editar').val(data.G_2025_4);
                    $('#CO_2025_4_editar').val(data.CO_2025_4);
                    $('#OR_2025_4_editar').val(data.OR_2025_4);
                    $('#ICLD_2026_1_editar').val(data.ICLD_2026_1);
                    $('#ICDE_2026_1_editar').val(data.ICDE_2026_1);
                    $('#SGPE_2026_1_editar').val(data.SGPE_2026_1);
                    $('#SGPS_2026_1_editar').val(data.SGPS_2026_1);
                    $('#SGPAPSB_2026_1_editar').val(data.SGPAPSB_2026_1);
                    $('#RPED_2026_1_editar').val(data.RPED_2026_1);
                    $('#SGR_2026_1_editar').val(data.SGR_2026_1);
                    $('#CR_2026_1_editar').val(data.CR_2026_1);
                    $('#G_2026_1_editar').val(data.G_2026_1);
                    $('#CO_2026_1_editar').val(data.CO_2026_1);
                    $('#OR_2026_1_editar').val(data.OR_2026_1);
                    $('#ICLD_2026_2_editar').val(data.ICLD_2026_2);
                    $('#ICDE_2026_2_editar').val(data.ICDE_2026_2);
                    $('#SGPE_2026_2_editar').val(data.SGPE_2026_2);
                    $('#SGPS_2026_2_editar').val(data.SGPS_2026_2);
                    $('#SGPAPSB_2026_2_editar').val(data.SGPAPSB_2026_2);
                    $('#RPED_2026_2_editar').val(data.RPED_2026_2);
                    $('#SGR_2026_2_editar').val(data.SGR_2026_2);
                    $('#CR_2026_2_editar').val(data.CR_2026_2);
                    $('#G_2026_2_editar').val(data.G_2026_2);
                    $('#CO_2026_2_editar').val(data.CO_2026_2);
                    $('#OR_2026_2_editar').val(data.OR_2026_2);
                    $('#ICLD_2026_3_editar').val(data.ICLD_2026_3);
                    $('#ICDE_2026_3_editar').val(data.ICDE_2026_3);
                    $('#SGPE_2026_3_editar').val(data.SGPE_2026_3);
                    $('#SGPS_2026_3_editar').val(data.SGPS_2026_3);
                    $('#SGPAPSB_2026_3_editar').val(data.SGPAPSB_2026_3);
                    $('#RPED_2026_3_editar').val(data.RPED_2026_3);
                    $('#SGR_2026_3_editar').val(data.SGR_2026_3);
                    $('#CR_2026_3_editar').val(data.CR_2026_3);
                    $('#G_2026_3_editar').val(data.G_2026_3);
                    $('#CO_2026_3_editar').val(data.CO_2026_3);
                    $('#OR_2026_3_editar').val(data.OR_2026_3);
                    $('#ICLD_2026_4_editar').val(data.ICLD_2026_4);
                    $('#ICDE_2026_4_editar').val(data.ICDE_2026_4);
                    $('#SGPE_2026_4_editar').val(data.SGPE_2026_4);
                    $('#SGPS_2026_4_editar').val(data.SGPS_2026_4);
                    $('#SGPAPSB_2026_4_editar').val(data.SGPAPSB_2026_4);
                    $('#RPED_2026_4_editar').val(data.RPED_2026_4);
                    $('#SGR_2026_4_editar').val(data.SGR_2026_4);
                    $('#CR_2026_4_editar').val(data.CR_2026_4);
                    $('#G_2026_4_editar').val(data.G_2026_4);
                    $('#CO_2026_4_editar').val(data.CO_2026_4);
                    $('#OR_2026_4_editar').val(data.OR_2026_4);
                    $('#ICLD_2027_1_editar').val(data.ICLD_2027_1);
                    $('#ICDE_2027_1_editar').val(data.ICDE_2027_1);
                    $('#SGPE_2027_1_editar').val(data.SGPE_2027_1);
                    $('#SGPS_2027_1_editar').val(data.SGPS_2027_1);
                    $('#SGPAPSB_2027_1_editar').val(data.SGPAPSB_2027_1);
                    $('#RPED_2027_1_editar').val(data.RPED_2027_1);
                    $('#SGR_2027_1_editar').val(data.SGR_2027_1);
                    $('#CR_2027_1_editar').val(data.CR_2027_1);
                    $('#G_2027_1_editar').val(data.G_2027_1);
                    $('#CO_2027_1_editar').val(data.CO_2027_1);
                    $('#OR_2027_1_editar').val(data.OR_2027_1);
                    $('#ICLD_2027_2_editar').val(data.ICLD_2027_2);
                    $('#ICDE_2027_2_editar').val(data.ICDE_2027_2);
                    $('#SGPE_2027_2_editar').val(data.SGPE_2027_2);
                    $('#SGPS_2027_2_editar').val(data.SGPS_2027_2);
                    $('#SGPAPSB_2027_2_editar').val(data.SGPAPSB_2027_2);
                    $('#RPED_2027_2_editar').val(data.RPED_2027_2);
                    $('#SGR_2027_2_editar').val(data.SGR_2027_2);
                    $('#CR_2027_2_editar').val(data.CR_2027_2);
                    $('#G_2027_2_editar').val(data.G_2027_2);
                    $('#CO_2027_2_editar').val(data.CO_2027_2);
                    $('#OR_2027_2_editar').val(data.OR_2027_2);
                    $('#ICLD_2027_3_editar').val(data.ICLD_2027_3);
                    $('#ICDE_2027_3_editar').val(data.ICDE_2027_3);
                    $('#SGPE_2027_3_editar').val(data.SGPE_2027_3);
                    $('#SGPS_2027_3_editar').val(data.SGPS_2027_3);
                    $('#SGPAPSB_2027_3_editar').val(data.SGPAPSB_2027_3);
                    $('#RPED_2027_3_editar').val(data.RPED_2027_3);
                    $('#SGR_2027_3_editar').val(data.SGR_2027_3);
                    $('#CR_2027_3_editar').val(data.CR_2027_3);
                    $('#G_2027_3_editar').val(data.G_2027_3);
                    $('#CO_2027_3_editar').val(data.CO_2027_3);
                    $('#OR_2027_3_editar').val(data.OR_2027_3);
                    $('#ICLD_2027_4_editar').val(data.ICLD_2027_4);
                    $('#ICDE_2027_4_editar').val(data.ICDE_2027_4);
                    $('#SGPE_2027_4_editar').val(data.SGPE_2027_4);
                    $('#SGPS_2027_4_editar').val(data.SGPS_2027_4);
                    $('#SGPAPSB_2027_4_editar').val(data.SGPAPSB_2027_4);
                    $('#RPED_2027_4_editar').val(data.RPED_2027_4);
                    $('#SGR_2027_4_editar').val(data.SGR_2027_4);
                    $('#CR_2027_4_editar').val(data.CR_2027_4);
                    $('#G_2027_4_editar').val(data.G_2027_4);
                    $('#CO_2027_4_editar').val(data.CO_2027_4);
                    $('#OR_2027_4_editar').val(data.OR_2027_4);
                    $('#estado').val(data.estado_pf);
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
            var url = "{{ route('eliminarprofin', ['id' => ':id']) }}";
            url = url.replace(':id', ProId);
            Swal.fire({
                title: "Esta seguro de desactivar la Programación Financiera?",
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
                                    text: "La Programación Financiera ha sido desactivada.",
                                    icon: "success"
                                });
                                $('#profin' + ProId).find('.estado').text('Inactivo').removeClass('bg-success').addClass('bg-danger');
                                $('#profin' + ProId).find('.eliminar').prop('disabled', true);
                                // Redibujar DataTable para reflejar los cambios
                                $('#profin').DataTable().row('#profin' + ProId).invalidate().draw();
                            }
                            else {
                                Swal.fire({
                                    title: "¡Error!",
                                    text: "La Programación Financiera no ha sido desactivada.",
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