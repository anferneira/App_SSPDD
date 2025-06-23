<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Estrategia;
use App\Models\Dimension;
use App\Models\Apuesta;
use App\Models\Actividad;
use App\Models\AvanceActividad;
use  App\Models\AvanceEstrategico;
use App\Models\IndicadorProducto;
use App\Models\ProgramarEstrategico;
use App\Models\Dependencia;
use App\Models\Evidencias;
use App\Imports\csvImportAvaAct;
use App\Imports\csvImportLogroIP;
use App\Models\DependenciaApuesta;
use App\Models\DependenciaDimension;
use App\Models\DependenciaEstrategia;
use App\Models\Logro;
use App\Models\LogroIndicador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AvanceActividadController extends Controller
{
    //

    /*public function __construct()
    {
        dd('Se está cargando el controlador AvanceActividadController');
    }*/

    public function listaravaacts() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $dependencias = $dependencias = Dependencia::orderBy('nombre_d')
                                ->where('id', '!=', 1)
                                ->where('id', '!=', 31)
                                ->where('id', '!=', 32)->get();
            $estrategias = Estrategia::orderBy('codigo_e')->get();
            $dimensions = Dimension::orderBy('codigo_d')->get();
            $apuestas = Apuesta::orderBy('codigo_a')->get();
            $ips = Actividad::selectRaw('
                indicador_productos.id as id,
                REPLACE(indicador_productos.codigo_ip, ",", ".") as codigo_ip,
                indicador_productos.nombre_ip as nombre_ip,
                indicador_productos.estado_ip as estado_ip,
                REPLACE(indicador_productos.meta_ip_real, ",", ".") as programadocuatrenio,
                programar_estrategicos.calculo as calculo,                
                SUM(CASE WHEN actividads.anio_a = 2024 THEN CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as programado2024,
                SUM(CASE WHEN actividads.anio_a = 2025 THEN CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as programado2025,
                SUM(CASE WHEN actividads.anio_a = 2026 THEN CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as programado2026,
                SUM(CASE WHEN actividads.anio_a = 2027 THEN CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as programado2027,
                SUM(CASE WHEN avance_actividads.anio_aa = 2024 THEN CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as avance2024,
                SUM(CASE WHEN avance_actividads.anio_aa = 2025 THEN CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as avance2025,
                SUM(CASE WHEN avance_actividads.anio_aa = 2026 THEN CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as avance2026,
                SUM(CASE WHEN avance_actividads.anio_aa = 2027 THEN CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as avance2027
            ')
            ->leftJoin('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
            ->leftJoin('avance_actividads', 'avance_actividads.id_a', '=', 'actividads.id')
            ->leftJoin('programar_estrategicos', 'programar_estrategicos.id_ip', '=', 'indicador_productos.id')
            ->groupBy(
                'indicador_productos.id',
                'programar_estrategicos.calculo'
            )
            ->orderBy('indicador_productos.id', 'asc') // ← aquí agregas la ordenación
            ->get()
            ->map(function ($item) {
                $avance = [
                    (float) $item->avance2024,
                    (float) $item->avance2025,
                    (float) $item->avance2026,
                    (float) $item->avance2027,
                ];
                
                $programado = [
                    (float) $item->programado2024,
                    (float) $item->programado2025,
                    (float) $item->programado2026,
                    (float) $item->programado2027,
                ];

                // Calcular avance total solo considerando los años programados
                $avanceTotal = 0;
                foreach ($avance as $index => $valor) {
                    if ($programado[$index] > 0) {
                        $avanceTotal += $valor;
                    }
                }

                $porcentaje2024 = ($programado[0] > 0) 
                                ? number_format(($avance[0] / $programado[0]) * 100, 2) 
                                : "No programado";
                $porcentaje2025 = ($programado[1] > 0) 
                                ? number_format(($avance[1] / $programado[1]) * 100, 2) 
                                : "No programado";
                $porcentaje2026 = ($programado[2] > 0) 
                                ? number_format(($avance[2] / $programado[2]) * 100, 2) 
                                : "No programado";
                $porcentaje2027 = ($programado[3] > 0) 
                                ? number_format(($avance[3] / $programado[3]) * 100, 2) 
                                : "No programado";                                
                $porcentajecuatrenio = number_format(($item->calculo == 1) 
                        ? ($avanceTotal / $item->programadocuatrenio) * 100 
                        : ($avanceTotal / ($programado[0] + $programado[1] + $programado[2] + $programado[3])) * 100, 2);
                
                if ($porcentaje2024 == "No programado")
                    $desemp2024 = "";
                else {
                    if ($porcentaje2024 >= 0 && $porcentaje2024 < 40)
                        $desemp2024 = "Crítico";
                    else {
                        if ($porcentaje2024 >= 40 && $porcentaje2024 <= 60)
                            $desemp2024 = "Bajo";
                        else {
                            if ($porcentaje2024 > 60 && $porcentaje2024 <= 70)
                                $desemp2024 = "Medio";
                            else {
                                if ($porcentaje2024 > 70 && $porcentaje2024 <= 80)
                                    $desemp2024 = "Satisfactorio";
                                else {
                                    if ($porcentaje2024 > 80 && $porcentaje2024 <= 100)
                                        $desemp2024 = "Sobresaliente";
                                    else
                                        $desemp2024 = "Sobre Ejecutado";
                                }
                            }
                        }
                    }
                }

                if ($porcentaje2025 == "No programado")
                    $desemp2025 = "";
                else {
                    if ($porcentaje2025 >= 0 && $porcentaje2025 < 40)
                        $desemp2025 = "Crítico";
                    else {
                        if ($porcentaje2025 >= 40 && $porcentaje2025 <= 60)
                            $desemp2025 = "Bajo";
                        else {
                            if ($porcentaje2025 > 60 && $porcentaje2025 <= 70)
                                $desemp2025 = "Medio";
                            else {
                                if ($porcentaje2025 > 70 && $porcentaje2025 <= 80)
                                    $desemp2025 = "Satisfactorio";
                                else {
                                    if ($porcentaje2025 > 80 && $porcentaje2025 <= 100)
                                        $desemp2025 = "Sobresaliente";
                                    else
                                        $desemp2025 = "Sobre Ejecutado";
                                }
                            }
                        }
                    }
                }

                if ($porcentaje2026 == "No programado")
                    $desemp2026 = "";
                else {
                    if ($porcentaje2026 >= 0 && $porcentaje2026 < 40)
                        $desemp2026 = "Crítico";
                    else {
                        if ($porcentaje2026 >= 40 && $porcentaje2026 <= 60)
                            $desemp2026 = "Bajo";
                        else {
                            if ($porcentaje2026 > 60 && $porcentaje2026 <= 70)
                                $desemp2026 = "Medio";
                            else {
                                if ($porcentaje2026 > 70 && $porcentaje2026 <= 80)
                                    $desemp2026 = "Satisfactorio";
                                else {
                                    if ($porcentaje2026 > 80 && $porcentaje2026 <= 100)
                                        $desemp2026 = "Sobresaliente";
                                    else
                                        $desemp2026 = "Sobre Ejecutado";
                                }
                            }
                        }
                    }
                }

                if ($porcentaje2027 == "No programado")
                    $desemp2027 = "";
                else {
                    if ($porcentaje2027 >= 0 && $porcentaje2027 < 40)
                        $desemp2027 = "Crítico";
                    else {
                        if ($porcentaje2027 >= 40 && $porcentaje2027 <= 60)
                            $desemp2027 = "Bajo";
                        else {
                            if ($porcentaje2027 > 60 && $porcentaje2027 <= 70)
                                $desemp2027 = "Medio";
                            else {
                                if ($porcentaje2027 > 70 && $porcentaje2027 <= 80)
                                    $desemp2027 = "Satisfactorio";
                                else {
                                    if ($porcentaje2027 > 80 && $porcentaje2027 <= 100)
                                        $desemp2027 = "Sobresaliente";
                                    else
                                        $desemp2027 = "Sobre Ejecutado";
                                }
                            }
                        }
                    }
                }

                if ($porcentajecuatrenio == "No programado")
                    $desempcuatrenio = "";
                else {
                    if ($porcentajecuatrenio >= 0 && $porcentajecuatrenio < 40)
                        $desempcuatrenio = "Crítico";
                    else {
                        if ($porcentajecuatrenio >= 40 && $porcentajecuatrenio <= 60)
                            $desempcuatrenio = "Bajo";
                        else {
                            if ($porcentajecuatrenio > 60 && $porcentajecuatrenio <= 70)
                                $desempcuatrenio = "Medio";
                            else {
                                if ($porcentajecuatrenio > 70 && $porcentajecuatrenio <= 80)
                                    $desempcuatrenio = "Satisfactorio";
                                else {
                                    if ($porcentajecuatrenio > 80 && $porcentajecuatrenio <= 100)
                                        $desempcuatrenio = "Sobresaliente";
                                    else
                                        $desempcuatrenio = "Sobre Ejecutado";
                                }
                            }
                        }
                    }
                }
                
                return (object) [
                    'id' => $item->id,
                    'codigo_ip' => $item->codigo_ip,
                    'nombre_ip' => $item->nombre_ip,
                    'programado2024' => $programado[0],
                    'programado2025' => $programado[1],
                    'programado2026' => $programado[2],
                    'programado2027' => $programado[3],
                    'programadocuatrenio' => (float) $item->programadocuatrenio,
                    'avance2024' => $avance[0],
                    'avance2025' => $avance[1],
                    'avance2026' => $avance[2],
                    'avance2027' => $avance[3],
                    'calculo' => $item->calculo,
                    'cantidad' => $programado[0] + $programado[1] + $programado[2] + $programado[3],
                    'estado_ip' => $item->estado_ip,
                    'porcentaje2024' => $porcentaje2024,
                    'porcentaje2025' => $porcentaje2025,
                    'porcentaje2026' => $porcentaje2026,
                    'porcentaje2027' => $porcentaje2027,
                    'porcentajecuatrenio' => $porcentajecuatrenio,
                    'avancetotal' => $avanceTotal,
                    'desemp2024' => $desemp2024,
                    'desemp2025' => $desemp2025,
                    'desemp2026' => $desemp2026,
                    'desemp2027' => $desemp2027,
                    'desempcuatrenio' => $desempcuatrenio,
                ];
            });
            return view('admin/avaact.index1', compact('usuario', 'nombre', 'rol', 'dependencia', 'ips', 'dependencias', 'estrategias', 'dimensions', 'apuestas'));
        }
        return Redirect::route('login');
    }

    public function cargar_select_e_d_a_d($id) {
        $datosE = DependenciaEstrategia::with('estrategias')->where('id_d', $id)->get();
        $datosD = DependenciaDimension::with('dimensiones')->where('id_dep', $id)->get();
        $datosA = DependenciaApuesta::with('apuestas')->where('id_dep', $id)->get();
        return response()->json([$datosE, $datosD, $datosA]);
    }

    public function dep_indi($id) {
        if ($id == 0) {
            $datos = IndicadorProducto::all()->map(function ($ip) {
                $ip->codigo_ip = str_replace(',', '.', $ip->codigo_ip);
                return $ip;
            })->sortBy('id');
        }
        else
            $datos = IndicadorProducto::where('id_d', $id)
                            ->orderByRaw("CAST(REPLACE(codigo_ip, ',', '.') AS DECIMAL(10,2)) ASC")
                            ->get();
        return response()->json($datos);
    }

    public function agregaravaact($id) {
        $datos = Actividad::with('producto.dependencia')->where('id', $id)->get();
        return response()->json($datos);
    }

    public function guardaravaact(Request $request) {
        $avaact = AvanceActividad::where('id_a', $request->id_a)
                                    ->where('anio_aa', $request->anio)
                                    ->where('trimestre_aa', $request->trimestre)->get();
        if ($avaact->count() > 0)
            return redirect()->route('listaravaacts')->with('error', 'El Avance de la Actividad ya existe en el sistema.');
        
        $request->validate([
            'avance' => 'required',
            'anio' => 'required',
            'trimestre' => 'required',
            'id_a' => 'required|exists:actividads,id'
        ]);
        $avaact = new AvanceActividad();
        $avaact->avance_aa = $request->input('avance');
        $avaact->anio_aa = $request->input('anio');
        $avaact->trimestre_aa = $request->input('trimestre');
        $avaact->id_a = $request->input('id_a');
        $avaact->estado_aa = 'Activo';
        $avaact->save();
        $avance = AvanceActividad::where('id_a', $request->input('id_a'))
                            ->with('actividad.producto')->get();
        foreach ($avance as $ava) {
            $ip = $ava->actividad->producto->codigo_ip;
            $a = $ava->actividad->codigo_a;
            $id = $ava->id;
        }
        $ip = str_replace([',', '.'], '_', $ip);
        $avaest = AvanceEstrategico::where('id_ip', $request->id_ip)
                                    ->where('anio_ae', $request->anio)
                                    ->where('trimestre_ae', $request->trimestre)->get();
        if ($avaest->count() == 0) {
            $avaest1 = new AvanceEstrategico();
            $avaest1->avance_ae = $request->input('avance');
            $avaest1->anio_ae = $request->input('anio');
            $avaest1->trimestre_ae = $request->input('trimestre');
            $avaest1->id_ip = $request->id_ip;
            $avaest1->estado_ae = 'Activo';
            $avaest1->save();
        }
        else {
            
            $avaest1 = AvanceEstrategico::where('id_ip', $request->id_ip)->get();
            if ($avaest1->count() > 0) {
                foreach ($avaest1 as $ae)
                    $anterior = floatval($ae->avance_ae);
                    $actavaest = AvanceEstrategico::find($ae->id);
            }
            $nuevo = floatval($request->input('avance'));
            $actavaest->avance_ae = $anterior + $nuevo;
            $actavaest->anio_ae = $request->input('anio');
            $actavaest->trimestre_ae = $request->input('trimestre');
            $actavaest->id_ip = $request->id_ip;
            $actavaest->estado_ae = 'Activo';
            $actavaest->save();
        }
        $avaact = AvanceActividad::where('id_a', $request->id_a)
                                    ->where('anio_aa', $request->anio)
                                    ->where('trimestre_aa', $request->trimestre)->get();
        foreach ($avaact as $ava) {
            $a = $ava->actividad->codigo_a;
        }
        $id = $request->id_ip;
        return redirect()->route('ver_ind1', ['id' => $id])->with('success', 'Avance de la Actividad creado correctamente para la actividad '.$a.' en el periodo '.$request->anio.'_'.$request->trimestre);
        //return redirect()->route('listaravaacts')->with('success', 'Avance de la Actividad creado correctamente para la actividad '.$a.' en el periodo '.$request->anio.'_'.$request->trimestre);
    }

    public function ind_est_dim_apu($id)
    {
        try {
            $partes = explode('-', $id);
            if (count($partes) < 5) {
                return response()->json(['error' => 'Parámetros incompletos'], 400);
            }

            // Asignación segura
            list($id_dep, $id_est, $id_dim, $id_apu, $sel) = $partes;

            // Valida que sean números si lo necesitas
            // Luego tu lógica...

        } catch (\Exception $e) {
            Log::error('Error en ind_est_dim_apu: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
        
        Log::info("mensaje: ".$id);
        $valor = array_map('trim', explode('-', $id));
        Log::info("datos: ".count($valor));
        $id_dep = $valor[0];
        $id_est = $valor[1];
        $id_dim = $valor[2];
        $id_apu = $valor[3];
        $id_sel = $valor[4];
        if ($id_sel === 'id_e' && $id_est != '0') {
            $id_dim = '0';
            $id_apu = '0';
        }
        else {
            if ($id_sel === 'id_dim' && $id_dim != '0') {
                $id_est = '0';
                $id_apu = '0';
            }
            else {
                if ($id_sel === 'id_a' && $id_apu != '0') {
                    $id_est = '0';
                    $id_dim = '0';
                }
                else {
                    if ($id_sel === 'id_a' && $id_apu === '0') {
                        $id_apu = '0';
                    }
                    else {
                        if ($id_sel === 'id_dim' && $id_dim === '0') {
                            $id_dim = '0';
                            $id_apu = '0';
                        }
                        else {
                            if ($id_sel === 'id_e' && $id_dim === '0') {
                                $id_est = '0';
                                $id_dim = '0';
                                $id_apu = '0';
                            }
                        }
                    }
                }
            }
        }
        $datos = DB::table('estrategias')
            ->leftJoin('dimensions', 'estrategias.id', '=', 'dimensions.id_e')
            ->leftJoin('apuestas', 'dimensions.id', '=', 'apuestas.id_d')
            ->leftJoin('dependencia_estrategias', 'dependencia_estrategias.id_e', '=', 'estrategias.id')
            ->leftJoin('dependencia_dimensions', 'dependencia_dimensions.id_dim', '=', 'dimensions.id')
            ->leftJoin('dependencia_apuestas', 'dependencia_apuestas.id_apu', '=', 'apuestas.id')
            ->select(
                'estrategias.id as estrategia_id',
                'estrategias.codigo_e as estrategia_codigo',
                'estrategias.nombre_e as estrategia_nombre',
                'dimensions.id as dimension_id',
                'dimensions.codigo_d as dimension_codigo',
                'dimensions.nombre_d as dimension_nombre',
                'dimensions.id_e as dimension_id_e',
                'apuestas.id as apuesta_id',
                'apuestas.codigo_a as apuesta_codigo',
                'apuestas.nombre_a as apuesta_nombre'
            )
            ->when($id_est != '0', fn($q) => $q->where('estrategias.id', $id_est))
            ->when($id_dim != '0', fn($q) => $q->where('dimensions.id', $id_dim))
            ->when($id_apu != '0', fn($q) => $q->where('apuestas.id', $id_apu))
            ->when($id_dep != '0' && !in_array($id_dep, ['1', '31', '32']), function ($query) use ($id_dep) {
                $query->where(function ($q) use ($id_dep) {
                    $q->where('dependencia_estrategias.id_d', $id_dep)
                    ->orWhere('dependencia_dimensions.id_dep', $id_dep)
                    ->orWhere('dependencia_apuestas.id_dep', $id_dep);
                });
            })
            ->groupBy(
                'estrategias.id',
                'estrategias.codigo_e',
                'estrategias.nombre_e',
                'dimensions.id',
                'dimensions.codigo_d',
                'dimensions.nombre_d',
                'dimensions.id_e',
                'apuestas.id',
                'apuestas.codigo_a',
                'apuestas.nombre_a'
            )
            ->get();

        // Si no hay datos, responder vacío
        if ($datos->isEmpty()) {
            return response()->json([
                'estrategia_id' => null,
                'estrategia_codigo' => null,
                'estrategia_nombre' => null,
                'dimensiones' => []
            ]);
        }

        // Siempre devolvemos la estrategia relacionada (de la primera fila)
        $resultado = [
            'estrategia_id' => $datos[0]->estrategia_id,
            'estrategia_codigo' => $datos[0]->estrategia_codigo,
            'estrategia_nombre' => $datos[0]->estrategia_nombre,
            'dimensiones' => []
        ];

        $dimensiones = [];
        foreach ($datos as $row) {
            if ($row->dimension_id !== null && !isset($dimensiones[$row->dimension_id])) {
                $dimensiones[$row->dimension_id] = [
                    'dimension_id' => $row->dimension_id,
                    'dimension_codigo' => $row->dimension_codigo,
                    'dimension_nombre' => $row->dimension_nombre,
                    'dimension_id_e' => $row->dimension_id_e,
                    'apuestas' => []
                ];
            }

            if ($row->apuesta_id !== null && isset($dimensiones[$row->dimension_id])) {
                $dimensiones[$row->dimension_id]['apuestas'][] = [
                    'apuesta_id' => $row->apuesta_id,
                    'apuesta_codigo' => $row->apuesta_codigo,
                    'apuesta_nombre' => $row->apuesta_nombre
                ];
            }
        }

        $resultado['dimensiones'] = array_values($dimensiones);

        return response()->json($resultado);
    }

    public function guardarevidenciasip(Request $request) {
        $ip = IndicadorProducto::where('codigo_ip', $request->id_ip)->get();
        foreach ($ip as $i) {
            $id = $i->id;
            $codigo_ip = str_replace([',', '.'], '_', $i->codigo_ip);
        }
        $evi_ip = Evidencias::where('id_ip', $id)
                                    ->where('anio_eip', $request->id_anio)
                                    ->where('trimestre_eip', $request->id_trimestre)->get();
        
        if ($evi_ip->count() == 5)
            return redirect()->route('listaravaacts')->with('error', 'Ya hay 5 evidencias para el indicador '.$codigo_ip.' para el periodo '.$request->id_anio.'_'.$request->id_trimestre);
        $request->validate([
            'id_anio' => 'required',
            'id_trimestre' => 'required',
            'id_ip' => 'required|exists:actividads,id'
        ]);
        $tot = 0;
        // Guarda las evidencias en el disco
        if ($request->hasFile('evidencias')) {
            foreach ($request->file('evidencias') as $archivo) {
                $tot = $tot + 1;
                $nombreArchivo = 'Ind_'.$codigo_ip.'_Periodo_'.$request->id_anio.'_'.$request->id_trimestre.'_'.$archivo->getClientOriginalName();
                $ruta = $archivo->storeAs('evidencias', $nombreArchivo, 'public');
                // Guardar las evidencias en la tabla
                $evid = new Evidencias();
                $evid->evidencia = $ruta;
                $evid->anio_eip = $request->input('id_anio');
                $evid->trimestre_eip = $request->input('id_trimestre');
                $evid->id_ip = $id;
                $evid->estado_e = "Activo";
                $evid->save();
            }
        }
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Se guardaron '.$tot.' evidencias para el indicador '.$codigo_ip.' en el periodo '.$request->id_anio.'_'.$request->id_trimestre,
                'redirect' => route('ver_ind1', ['id' => $id])
            ]);
        }
        return redirect()->route('ver_ind1', ['id' => $id])->with('error', 'No se guardaron las evidencias para el indicador '.$ip->codigo_ip.' en el periodo '.$request->id_anio_eip.'_'.$request->id_trimestre_eip);                
    }

    public function editarevidenciasip($id) {
        $valor = array_map('trim', explode('_', $id));
        if ($valor[1] == '0' || $valor[2] == '0')
            return null;
        $datos = Evidencias::where('id_ip', $valor[0])
                                    ->where('anio_eip', $valor[1])
                                    ->where('trimestre_eip', $valor[2])->get();
        return response()->json($datos);
    }

    public function actualizarevidenciasip(Request $request) {
        $ip = IndicadorProducto::where('codigo_ip', $request->id_ip)->get();
        foreach ($ip as $i) {
            $id = $i->id;
            $codigo_ip = str_replace([',', '.'], '_', $i->codigo_ip);
        }
        $evi_ip = Evidencias::where('id_ip', $id)
                                    ->where('anio_eip', $request->id_anio)
                                    ->where('trimestre_eip', $request->id_trimestre)->get();
        
        if ($evi_ip->count() == 5)
            return redirect()->route('listaravaacts')->with('error', 'Ya hay 5 evidencias para el indicador '.$codigo_ip.' para el periodo '.$request->id_anio.'_'.$request->id_trimestre);
        $request->validate([
            'id_anio' => 'required',
            'id_trimestre' => 'required',
            'id_ip' => 'required|exists:actividads,id'
        ]);
        $tot = 0;
        // Guarda las evidencias en el disco
        if ($request->hasFile('evidencias')) {
            foreach ($request->file('evidencias') as $archivo) {
                $tot = $tot + 1;
                $nombreArchivo = 'Ind_'.$codigo_ip.'_Periodo_'.$request->id_anio.'_'.$request->id_trimestre.'_'.$archivo->getClientOriginalName();
                $ruta = $archivo->storeAs('evidencias', $nombreArchivo, 'public');
                // Guardar las evidencias en la tabla
                $evid = new Evidencias();
                $evid->evidencia = $ruta;
                $evid->anio_eip = $request->input('id_anio');
                $evid->trimestre_eip = $request->input('id_trimestre');
                $evid->id_ip = $id;
                $evid->estado_e = "Activo";
                $evid->save();
            }
        }
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Se guardaron '.$tot.' evidencias para el indicador '.$codigo_ip.' en el periodo '.$request->id_anio.'_'.$request->id_trimestre,
                'redirect' => route('ver_ind1', ['id' => $id])
            ]);
        }
        return redirect()->route('ver_ind1', ['id' => $id])->with('error', 'No se guardaron las evidencias para el indicador '.$ip->codigo_ip.' en el periodo '.$request->id_anio_eip.'_'.$request->id_trimestre_eip);                
    }

    public function guardarlogroip(Request $request) {
        //return response()->json($request);
        $request->validate([
            'id_anio' => 'required',
            'id_trimestre' => 'required',
            'id_ip' => 'required|exists:actividads,id',
            'logro_ip' => 'required',
        ]);
        $ip = IndicadorProducto::where('codigo_ip', $request->id_ip)->get();
        foreach ($ip as $i) {
            $id = $i->id;
            $codigo_ip = str_replace([',', '.'], '_', $i->codigo_ip);
        }
        $logro_ip = LogroIndicador::where('id_ip', $id)
                                    ->where('anio_lip', $request->id_anio)
                                    ->where('trimestre_lip', $request->id_trimestre)->get();
        
        foreach ($logro_ip as $lip) {
            $id_l = $lip->id;
        }
        if ($logro_ip->count() == 1)
            $logro_ip = LogroIndicador::find($id_l);
        else {
            $logro_ip = new LogroIndicador();
        }
        $logro_ip->logro = $request->input('logro_ip');
        $logro_ip->anio_lip = $request->input('id_anio');
        $logro_ip->trimestre_lip = $request->input('id_trimestre');
        $logro_ip->id_ip = $request->input('id_ip');
        $logro_ip->estado_lip = 'Activo';
        $logro_ip->save();
        return redirect()->route('ver_ind1', ['id' => $id])->with('success', 'Se guardó el logro para el indicador '.$codigo_ip.' en el periodo '.$request->id_anio.'_'.$request->id_trimestre);
    }

    public function editarlogroip($id) {
        $valor = array_map('trim', explode('_', $id));
        if ($valor[1] == '0' || $valor[2] == '0')
            return null;
        $dato = LogroIndicador::where('id_ip', $valor[0])
                                    ->where('anio_lip', $valor[1])
                                    ->where('trimestre_lip', $valor[2])->get();
        return response()->json($dato);
    }

    public function actualizarlogroip(Request $request) {
        $request->validate([
            'id_anio' => 'required',
            'id_trimestre' => 'required',
            'id_ip' => 'required|exists:actividads,id',
            'logro_ip' => 'required',
        ]);
        $ip = IndicadorProducto::find($request->input('id_ip'));
        $logro_ip = LogroIndicador::where('id_ip', $request->id_ip)
                                    ->where('anio_lip', $request->id_anio)
                                    ->where('trimestre_lip', $request->id_trimestre)->get();
        foreach ($logro_ip as $l_ip) {
            $l_ip->logro = $request->logro_ip;
            $l_ip->anio_lip = $request->id_anio;
            $l_ip->trimestre_lip = $request->id_trimestre;
            $l_ip->id_ip = $request->id_ip;
            $l_ip->save();
        }
        return redirect()->route('ver_ind1', ['id' => $request->id_ip])->with('success', 'Se actualizó el logro para el indicador '.$ip->codigo_ip.' en el periodo '.$request->id_anio.'_'.$request->id_trimestre);
    }

    public function ver_ind1($id) {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $dependencias = Dependencia::where('id', '!=' , 1)
                                        ->where('id', '!=', 31)
                                        ->where('id', '!=', 32)
                                        ->orderBy('nombre_d')->get();
           
            $acts = DB::table('actividads')
                ->leftJoin('avance_actividads', 'actividads.id', '=', 'avance_actividads.id_a')
                ->leftJoin('indicador_productos', 'actividads.id_ip', '=', 'indicador_productos.id')
                ->leftJoin(DB::raw('
                    (
                        SELECT 
                            id_ip,
                            anio_a,
                            trimestre_a,
                            SUM(CAST(REPLACE(aporte_a, ",", ".") AS DECIMAL(10,2))) AS total_aporte_periodo
                        FROM actividads
                        GROUP BY id_ip, anio_a, trimestre_a
                    ) AS sumas_periodo
                '), function($join) {
                    $join->on('actividads.id_ip', '=', 'sumas_periodo.id_ip')
                        ->on('actividads.anio_a', '=', 'sumas_periodo.anio_a')
                        ->on('actividads.trimestre_a', '=', 'sumas_periodo.trimestre_a');
                })
                ->leftJoin(DB::raw('
                    (
                        SELECT 
                            id_ip,
                            anio_a,
                            SUM(CAST(REPLACE(aporte_a, ",", ".") AS DECIMAL(10,2))) AS total_aporte_anio
                        FROM actividads
                        GROUP BY id_ip, anio_a
                    ) AS sumas_anio
                '), function($join) {
                    $join->on('actividads.id_ip', '=', 'sumas_anio.id_ip')
                        ->on('actividads.anio_a', '=', 'sumas_anio.anio_a');
                })
                ->select(
                    'actividads.*',
                    DB::raw('COALESCE(SUM(CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2))), 0) as avance_total'),
                    DB::raw('
                        COALESCE(
                            CASE 
                                WHEN sumas_periodo.total_aporte_periodo > 0 
                                THEN ROUND(SUM(CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2))) / sumas_periodo.total_aporte_periodo * 100, 2)
                                ELSE 0
                            END, 0.00
                        ) as porcentaje_periodo
                    '),

                    DB::raw('
                        COALESCE(
                            CASE 
                                WHEN sumas_anio.total_aporte_anio > 0 
                                THEN ROUND(SUM(CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2))) / sumas_anio.total_aporte_anio * 100, 2)
                                ELSE 0
                            END, 0.00
                        ) as porcentaje_anio
                    '),
                    
                    DB::raw('
                        COALESCE(
                            CASE 
                                WHEN REPLACE(actividads.aporte_a, ",", ".") != "" AND CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) > 0 
                                THEN ROUND(SUM(CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2))) / CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) * 100, 2)
                                ELSE 0
                            END, 0.00
                        ) as porcentaje_avance
                    '),
                    DB::raw('IF(COUNT(avance_actividads.id) > 0, 1, 0) as avance')
                )
                ->where('actividads.id_ip', $id)
                ->whereNotNull('actividads.trimestre_a')
                ->groupBy(
                    'actividads.id',
                    'actividads.codigo_a',
                    'actividads.nombre_a',
                    'actividads.anio_a',
                    'actividads.trimestre_a',
                    'actividads.aporte_a',
                    'sumas_periodo.total_aporte_periodo',
                    'sumas_anio.total_aporte_anio'
                )
                ->orderBy('actividads.codigo_a')
                ->get();

                //return response()->json($acts);
            
            // Contar los avances
            $faltan = $acts->where('avance', 0)->count();
            $total = $acts->count();
            $ip = IndicadorProducto::find($id);
            $evidencias = Evidencias::where('id_ip', $id)->get();
            foreach ($evidencias as $evi) {
                $partes = explode('_', $evi->evidencia);
                $evi->texto_evidencia = implode('_', array_slice($partes, 5));
            }
            return view('admin/avaact.index2', compact('usuario', 'nombre', 'rol', 'dependencia', 'acts', 'ip', 'dependencias', 'faltan', 'total', 'evidencias'));
        }
        return Redirect::route('login');
    }

    // Función para convertir el código en un valor numérico
    function ordenarCodigo($codigo)
    {
        // Convertir el código a un valor numérico basado en la longitud de las letras
        $valor = 0;
        $longitud = strlen($codigo);

        // Iteramos sobre el código, cada carácter se convierte en su código ASCII y se multiplica por la posición
        for ($i = 0; $i < $longitud; $i++) {
            $valor += ord($codigo[$i]) * pow(100, $longitud - $i - 1);
        }

        return $valor;
    }

    public function veractividades_anio1($id) {
        $valor = array_map('trim', explode('_', $id));
        $anio = $valor[0];
        $trim = $valor[1];
        $ind = $valor[2];
        $rez = $valor[3];
        $datos = DB::table('actividads')
                ->leftJoin('avance_actividads', 'actividads.id', '=', 'avance_actividads.id_a')
                ->leftJoin('indicador_productos', 'actividads.id_ip', '=', 'indicador_productos.id')
                ->leftJoin(DB::raw('
                    (
                        SELECT 
                            id_ip,
                            anio_a,
                            trimestre_a,
                            SUM(CAST(REPLACE(aporte_a, ",", ".") AS DECIMAL(10,2))) AS total_aporte_periodo
                        FROM actividads
                        GROUP BY id_ip, anio_a, trimestre_a
                    ) AS sumas_periodo
                '), function($join) {
                    $join->on('actividads.id_ip', '=', 'sumas_periodo.id_ip')
                        ->on('actividads.anio_a', '=', 'sumas_periodo.anio_a')
                        ->on('actividads.trimestre_a', '=', 'sumas_periodo.trimestre_a');
                })
                ->leftJoin(DB::raw('
                    (
                        SELECT 
                            id_ip,
                            anio_a,
                            SUM(CAST(REPLACE(aporte_a, ",", ".") AS DECIMAL(10,2))) AS total_aporte_anio
                        FROM actividads
                        GROUP BY id_ip, anio_a
                    ) AS sumas_anio
                '), function($join) {
                    $join->on('actividads.id_ip', '=', 'sumas_anio.id_ip')
                        ->on('actividads.anio_a', '=', 'sumas_anio.anio_a');
                })
                ->select(
                    'actividads.*',
                    DB::raw('COALESCE(SUM(CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2))), 0) as avance_total'),
                    DB::raw('
                        COALESCE(
                            CASE 
                                WHEN sumas_periodo.total_aporte_periodo > 0 
                                THEN ROUND(SUM(CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2))) / sumas_periodo.total_aporte_periodo * 100, 2)
                                ELSE 0
                            END, 0.00
                        ) as porcentaje_periodo
                    '),

                    DB::raw('
                        COALESCE(
                            CASE 
                                WHEN sumas_anio.total_aporte_anio > 0 
                                THEN ROUND(SUM(CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2))) / sumas_anio.total_aporte_anio * 100, 2)
                                ELSE 0
                            END, 0.00
                        ) as porcentaje_anio
                    '),
                    
                    DB::raw('
                        COALESCE(
                            CASE 
                                WHEN REPLACE(actividads.aporte_a, ",", ".") != "" AND CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) > 0 
                                THEN ROUND(SUM(CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2))) / CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) * 100, 2)
                                ELSE 0
                            END, 0.00
                        ) as porcentaje_avance
                    '),
                    DB::raw('IF(COUNT(avance_actividads.id) > 0, 1, 0) as avance')
                )
                ->where('actividads.id_ip', $ind)
                ->when($anio != 0, function ($query) use ($anio) {
                    $query->where('actividads.anio_a', $anio);
                })
                ->when($trim != 0, function ($query) use ($trim) {
                    $query->where('actividads.trimestre_a', $trim);
                })
                ->whereNotNull('actividads.trimestre_a')
                ->groupBy(
                    'actividads.id',
                    'actividads.codigo_a',
                    'actividads.nombre_a',
                    'actividads.anio_a',
                    'actividads.trimestre_a',
                    'actividads.aporte_a',
                    'sumas_periodo.total_aporte_periodo',
                    'sumas_anio.total_aporte_anio'
                )
                ->orderBy('actividads.id', 'asc')
                ->when($rez != 1, function ($query) use ($rez) {
                    if ($rez === '0') {
                        $query->having('porcentaje_avance', '>=', 0);
                    } elseif ($rez === '2') {
                        $query->having('porcentaje_avance', '=', 100);
                    } elseif ($rez === '3') {
                        $query->having('porcentaje_avance', '>', 0)
                              ->having('porcentaje_avance', '<', 100);
                    } elseif ($rez === '4') {
                        $query->having('porcentaje_avance', '=', 0);
                    } elseif ($rez === '5') {
                        $query->having('porcentaje_avance', '>=', 0)
                              ->having('porcentaje_avance', '<', 40);
                    } elseif ($rez === '6') {
                        $query->having('porcentaje_avance', '>=', 40)
                              ->having('porcentaje_avance', '<=', 60);
                    } elseif ($rez === '7') {
                        $query->having('porcentaje_avance', '>', 60)
                              ->having('porcentaje_avance', '<=', 70);
                    } elseif ($rez === '8') {
                        $query->having('porcentaje_avance', '>', 70)
                              ->having('porcentaje_avance', '<=', 80);
                    } elseif ($rez === '9') {
                        $query->having('porcentaje_avance', '>', 80)
                              ->having('porcentaje_avance', '<=', 100);
                    } elseif ($rez === '10') {
                        $query->having('porcentaje_avance', '>', 100);
                    }
                })->get();
        // Contar los avances
        $faltan = $datos->where('avance', 0)->count();
        $total = $datos->count();
        return response()->json([$datos,$faltan,$total]);
    }

    public function veravaact($id) {
        $avaact = Actividad::join('avance_actividads', 'actividads.id', '=', 'avance_actividads.id_a')
                            ->join('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
                            ->join('dependencias', 'dependencias.id', '=', 'indicador_productos.id_d')
                            ->leftJoin(DB::raw('
                                (
                                    SELECT 
                                        id_ip,
                                        anio_a,
                                        trimestre_a,
                                        SUM(CAST(REPLACE(aporte_a, ",", ".") AS DECIMAL(10,2))) AS total_aporte_periodo
                                    FROM actividads
                                    GROUP BY id_ip, anio_a, trimestre_a
                                ) AS sumas_periodo
                            '), function($join) {
                                $join->on('actividads.id_ip', '=', 'sumas_periodo.id_ip')
                                    ->on('actividads.anio_a', '=', 'sumas_periodo.anio_a')
                                    ->on('actividads.trimestre_a', '=', 'sumas_periodo.trimestre_a');
                            })
                            ->leftJoin(DB::raw('
                                (
                                    SELECT 
                                        id_ip,
                                        anio_a,
                                        SUM(CAST(REPLACE(aporte_a, ",", ".") AS DECIMAL(10,2))) AS total_aporte_anio
                                    FROM actividads
                                    GROUP BY id_ip, anio_a
                                ) AS sumas_anio
                            '), function($join) {
                                $join->on('actividads.id_ip', '=', 'sumas_anio.id_ip')
                                    ->on('actividads.anio_a', '=', 'sumas_anio.anio_a');
                            })
                            ->select('actividads.codigo_a as codigo_a', 'actividads.nombre_a as nombre_a', 'indicador_productos.codigo_ip as codigo_ip', 'indicador_productos.nombre_ip as nombre_ip', 'dependencias.nombre_d as nombre_d', 'avance_actividads.anio_aa as anio', 'avance_actividads.trimestre_aa as trimestre', 'actividads.aporte_a as aporte', 'avance_actividads.avance_aa as avance', 'avance_actividads.estado_aa as estado', 'avance_actividads.created_at as created_at', 'avance_actividads.updated_at as updated_at', 'avance_actividads.logro_aa as logro',
                                DB::raw('COALESCE(SUM(CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2))), 0) as avance_total'),
                                DB::raw('
                                    COALESCE(
                                        CASE 
                                            WHEN sumas_periodo.total_aporte_periodo > 0 
                                            THEN ROUND(SUM(CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2))) / sumas_periodo.total_aporte_periodo * 100, 2)
                                            ELSE 0
                                        END, 0.00
                                    ) as porcentaje_periodo
                                '),

                                DB::raw('
                                    COALESCE(
                                        CASE 
                                            WHEN sumas_anio.total_aporte_anio > 0 
                                            THEN ROUND(SUM(CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2))) / sumas_anio.total_aporte_anio * 100, 2)
                                            ELSE 0
                                        END, 0.00
                                    ) as porcentaje_anio
                                '),
                                
                                DB::raw('
                                    COALESCE(
                                        CASE 
                                            WHEN REPLACE(actividads.aporte_a, ",", ".") != "" AND CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) > 0 
                                            THEN ROUND(SUM(CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2))) / CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) * 100, 2)
                                            ELSE 0
                                        END, 0.00
                                    ) as porcentaje_avance
                                '),
                                // 🔹 Reemplaza "," por "." en el campo `aporte_a`
                                DB::raw('REPLACE(actividads.aporte_a, ",", ".") as aporte'),
                                'avance_actividads.avance_aa as avance',
                            )
                            ->where('actividads.id', $id)
                            ->groupBy(
                                'indicador_productos.id',
                                'actividads.codigo_a',
                                'actividads.nombre_a',
                                'indicador_productos.codigo_ip',
                                'indicador_productos.nombre_ip',
                                'dependencias.nombre_d',
                                'avance_actividads.anio_aa',
                                'avance_actividads.trimestre_aa',
                                'actividads.aporte_a',
                                'avance_actividads.avance_aa',
                                'avance_actividads.logro_aa',
                                'sumas_periodo.total_aporte_periodo',
                                'sumas_anio.total_aporte_anio',
                                'avance_actividads.estado_aa',
                                'avance_actividads.created_at',
                                'avance_actividads.updated_at'
                            )
                            ->get();
                            /*Log::info('Consulta de avance de actividad', [
                                'actividad_id' => $id,
                                'resultado' => $avaact
                            ]);*/
        return response()->json($avaact);
    }

    public function veravaest($id) {
        $datos = IndicadorProducto::with(['indproducto2', 'indproducto3'])->findOrFail($id);
        $evidencias = Evidencias::where('id_ip', $id)->get();

        $datos->evidencias = $evidencias;
        foreach ($datos->indproducto2 as $item) {
            // 1. Asegurar que los campos de programación sean numéricos
            $camposProgramacion = [
                'p2024_3', 'p2024_4',
                'p2025_1', 'p2025_2', 'p2025_3', 'p2025_4',
                'p2026_1', 'p2026_2', 'p2026_3', 'p2026_4',
                'p2027_1', 'p2027_2', 'p2027_3', 'p2027_4',
            ];
            
            foreach ($camposProgramacion as $campo) {
                $item->$campo = isset($item->$campo) ? (float) str_replace(',', '.', $item->$campo) : 0;
            }

            // 2. Sumar programación por año
            $item->p2024 = $item->p2024_3 + $item->p2024_4;
            $item->p2025 = $item->p2025_1 + $item->p2025_2 + $item->p2025_3 + $item->p2025_4;
            $item->p2026 = $item->p2026_1 + $item->p2026_2 + $item->p2026_3 + $item->p2026_4;
            $item->p2027 = $item->p2027_1 + $item->p2027_2 + $item->p2027_3 + $item->p2027_4;

            // 3. Calcular programación del cuatrienio
            if ($item->calculo == 1) { // suma
                $item->pcuatrenio = $item->p2024 + $item->p2025 + $item->p2026 + $item->p2027;
            } elseif ($item->calculo == 2) { // promedio
                $programaciones = array_filter([$item->p2024, $item->p2025, $item->p2026, $item->p2027], function ($val) {
                    return $val > 0;
                });
                $item->pcuatrenio = count($programaciones) > 0 ? array_sum($programaciones) / count($programaciones) : 0;
            }

            // 4. Inicializar avances anuales
            $avance2024 = $avance2025 = $avance2026 = $avance2027 = 0;

            // 5. Inicializar avances por periodo
            $periodos = [
                '2024_3', '2024_4',
                '2025_1', '2025_2', '2025_3', '2025_4',
                '2026_1', '2026_2', '2026_3', '2026_4',
                '2027_1', '2027_2', '2027_3', '2027_4',
            ];
            foreach ($periodos as $periodo) {
                $item->{'total_' . $periodo} = 0;
            }

            // 6. Recorrer avances
            foreach ($datos->indproducto3 as $avance) {
                if ($avance->id_ip == $item->id_ip) {
                    // Avances por año
                    switch ($avance->anio_ae) {
                        case '2024':
                            $avance2024 += $avance->avance_ae;
                            break;
                        case '2025':
                            $avance2025 += $avance->avance_ae;
                            break;
                        case '2026':
                            $avance2026 += $avance->avance_ae;
                            break;
                        case '2027':
                            $avance2027 += $avance->avance_ae;
                            break;
                    }

                    // Avances por periodo
                    $campoTotalPeriodo = 'total_' . $avance->anio_ae . '_' . $avance->trimestre_ae;
                    if (isset($item->$campoTotalPeriodo)) {
                        $item->$campoTotalPeriodo += $avance->avance_ae;
                    } else {
                        $item->$campoTotalPeriodo = $avance->avance_ae;
                    }
                }
            }

            // 7. Evaluar por cada periodo si debe ser "No programado"
            foreach ($periodos as $periodo) {
                $anio = substr($periodo, 0, 4);
                $trimestre = substr($periodo, 5);
                $campoProgramado = 'p' . $periodo;
                $campoTotal = 'total_' . $periodo;
                
                // Si el campo programado para ese periodo es 0, ponemos el total como "No programado"
                if (isset($item->$campoProgramado) && $item->$campoProgramado == 0) {
                    $item->$campoTotal = 'No programado';
                }
            }

            // 8. Guardar totales de avance anual
            $item->total_2024 = $avance2024;
            $item->total_2025 = $avance2025;
            $item->total_2026 = $avance2026;
            $item->total_2027 = $avance2027;

            // 9. Calcular total de avance cuatrienio
            if ($item->calculo == 1) { // suma
                $item->total_cuatrenio = $avance2024 + $avance2025 + $avance2026 + $avance2027;
            } elseif ($item->calculo == 2) { // promedio
                $avances = array_filter([$avance2024, $avance2025, $avance2026, $avance2027], function ($val) {
                    return $val > 0;
                });
                $item->total_cuatrenio = count($avances) > 0 ? array_sum($avances) / count($avances) : 0;
            }

            // 10. Calcular porcentaje de avance anual
            if ($item->p2024 > 0) {
                $item->porcentaje_2024 = number_format(($item->total_2024 / $item->p2024) * 100, 2);
            } else {
                $item->porcentaje_2024 = 'No programado';
            }

            if ($item->p2025 > 0) {
                $item->porcentaje_2025 = number_format(($item->total_2025 / $item->p2025) * 100, 2);
            } else {
                $item->porcentaje_2025 = 'No programado';
            }

            if ($item->p2026 > 0) {
                $item->porcentaje_2026 = number_format(($item->total_2026 / $item->p2026) * 100, 2);
            } else {
                $item->porcentaje_2026 = 'No programado';
            }

            if ($item->p2027 > 0) {
                $item->porcentaje_2027 = number_format(($item->total_2027 / $item->p2027) * 100, 2);
            } else {
                $item->porcentaje_2027 = 'No programado';
            }

            // 11. Calcular porcentaje cuatrienio
            if ($item->pcuatrenio > 0) {
                $item->porcentaje_cuatrenio = number_format(($item->total_cuatrenio / $item->pcuatrenio) * 100, 2);
            } else {
                $item->porcentaje_cuatrenio = 'No programado';
            }

            // 12. Calcular porcentaje por periodo (porcentaje_anio_trimestre)
            foreach ($periodos as $periodo) {
                $anio = substr($periodo, 0, 4);
                $trimestre = substr($periodo, 5);
                $campoTotal = 'total_' . $periodo;
                $campoProgramado = 'p' . $periodo;
                $campoPorcentaje = 'porcentaje_' . $periodo;
                
                // Si el campo programado no es 0, calcular porcentaje
                if (isset($item->$campoProgramado) && $item->$campoProgramado > 0) {
                    $item->$campoPorcentaje = number_format(($item->$campoTotal / $item->$campoProgramado) * 100, 2);
                } else {
                    $item->$campoPorcentaje = 'No programado';
                }
            }

            // 13. Evaluar si todos los trimestres son "No programado"
            $totalAnualEsNoProgramado = true;
            foreach ($periodos as $periodo) {
                $campoTotal = 'total_' . $periodo;
                if ($item->$campoTotal !== 'No programado') {
                    $totalAnualEsNoProgramado = false;
                    break;
                }
            }

            // Si todos los trimestres son "No programado", establecer el total anual como "No programado"
            if ($totalAnualEsNoProgramado) {
                $item->total_2024 = 'No programado';
                $item->total_2025 = 'No programado';
                $item->total_2026 = 'No programado';
                $item->total_2027 = 'No programado';
            }

            $logros = LogroIndicador::where('id_ip', $id)->get();
            
            
            $datos = (object) $datos->toArray();
            
            $datos->logros = [
                '2024' => [],
                '2025' => [],
                '2026' => [],
                '2027' => [],
            ];
            foreach ($logros as $logro) {
                if (in_array($logro->anio_lip, ['2024', '2025', '2026', '2027'])) {
                    $datos->logros[$logro->anio_lip][] = [
                        'logro' => $logro->logro,
                        'anio_lip' => $logro->anio_lip,
                        'trimestre_lip' => $logro->trimestre_lip,
                    ];
                }
            }
        }
        
        return response()->json($datos);
    }

    public function editaravaact($id) {
        $avaact = Actividad::join('avance_actividads', 'actividads.id', '=', 'avance_actividads.id_a')
                            ->join('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
                            ->join('dependencias', 'dependencias.id', '=', 'indicador_productos.id_d')
                            ->select('avance_actividads.id as id', 'avance_actividads.logro_aa as logro_aa', 'indicador_productos.id as id_ip', 'indicador_productos.codigo_ip as codigo_ip', 'dependencias.id as id_d', 'dependencias.nombre_d as nombre_d', 'avance_actividads.avance_aa as avance_aa', 'actividads.aporte_a as aporte_a', 'actividads.id as id_a', 'actividads.codigo_a as codigo_a', 'actividads.anio_a as anio', 'actividads.trimestre_a as trimestre', 'avance_actividads.estado_aa as estado')
                            ->where('actividads.id', $id)
                            ->groupBy(
                                'avance_actividads.id',
                                'indicador_productos.id',
                                'dependencias.id',
                                'avance_actividads.avance_aa',
                                'avance_actividads.logro_aa',
                                'actividads.aporte_a',
                                'actividads.id',
                                'actividads.anio_a',
                                'actividads.trimestre_a',
                                'avance_actividads.estado_aa'
                            )
                            ->get();
        return response()->json($avaact);
    }

    public function actualizaravaact(Request $request) {
        //return response()->json($request);
        $request->validate([    
            'estado' => 'required',
            'avance' => 'required',
            'avance_oculto' => 'required',
            'anio' => 'required',
            'trimestre' => 'required',
            'desc_act' => 'required',
            'id_a' => 'required|exists:actividads,id'
        ]);
        $avance = AvanceActividad::where('id_a', $request->input('id_a'))
                            ->with('actividad.producto')->get();
        foreach ($avance as $ava) {
            $ip = $ava->actividad->producto->codigo_ip;
            $a = $ava->actividad->codigo_a;
            $id = $ava->id;
        }
        $ip = str_replace([',', '.'], '_', $ip);
        $tot = 0;
        
        //return response()->json($request);
        $avaact = AvanceActividad::find($request->input('id'));
        $avaact->avance_aa = $request->input('avance');
        $avaact->anio_aa = $request->input('anio');
        $avaact->trimestre_aa = $request->input('trimestre');
        $avaact->id_a = $request->input('id_a');
        $avaact->logro_aa = $request->input('desc_act');
        $avaact->estado_aa = $request->input('estado');
        $avaact->save();
        
        $avaest1 = AvanceEstrategico::where('id_ip', $request->id_ip)->get();
        if ($avaest1->count() > 0) {
            foreach ($avaest1 as $ae)
                $actual = floatval($ae->avance_ae);
                $actavaest = AvanceEstrategico::find($ae->id);
        }
        $nuevo = floatval($request->input('avance'));
        $anterior = floatval($request->input('avance_oculto'));
        $avancequitar = $actual - $anterior;
        $actavaest->avance_ae = $avancequitar + $nuevo;
        $actavaest->save();
        $id = $request->id_ip;
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Avance de la Actividad modificado correctamente',
                'redirect' => route('ver_ind1', ['id' => $id])
            ]);
        }
        return redirect()->route('ver_ind1', ['id' => $id])->with('success', 'Avance de la Actividad modificado correctamente');
        //return redirect()->route('listaravaacts')->with('success', 'Avance de la Actividad actualizado correctamente y se agregaron '.$tot.' evidencias');
    }

    public function eliminaravaact($id) {
        $avaact = AvanceActividad::find($id);
        if ($avaact) {
            $avaact->estado_aa = "Inactivo";
            $avaact->save();
            return response()->json(['success' => true, 'message' => 'Avance de la Actividad Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Avance de la Actividad no encontrado']);
    }

    public function eliminarevidact($id) {
        
        $evidact = Evidencias::find($id);
        if ($evidact) {
            // Obtener la ruta del archivo para eliminarlo del disco
            $rutaArchivo = $evidact->evidencia;
            // Verificar si el archivo existe en el almacenamiento
            if (Storage::disk('public')->exists($rutaArchivo)) {
                // Eliminar el archivo del almacenamiento
                Storage::disk('public')->delete($rutaArchivo);
            }
            $evidact->delete();
            return response()->json(['success' => true, 'message' => 'Evidencia de la Actividad Eliminada correctamente']);
        }
        return response()->json(['error' => true, 'message' => 'Evidencia de la Actividad no encontrada']);
    }

    public function csvavaacts(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['id_a', 'avance_aa', 'anio_aa', 'trimestre_aa', 'logro_aa', 'estado_aa'];

        $encabezadosLeidos = array_map('trim', $headings[0][0]);
        sort($encabezadosLeidos);
        sort($encabezadosEsperados);

        //dd($encabezadosEsperados, $encabezadosLeidos);

        // Verificar si los encabezados coinciden
        // Comparamos si los encabezados obtenidos coinciden con los esperados
        if ($encabezadosLeidos !== $encabezadosEsperados) {
            return redirect()->back()->with('error', 'La estructura del archivo no es válida. Verifica los encabezados.');
        }

        // Continuar con la importación si todo está bien
        // Crear la instancia de la clase de importación
        $importar = new csvImportAvaAct;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todos los Avances de Actividades ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevos Avances de Actividades importados correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }

    public function csvlogros(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['logro', 'anio_lip', 'trimestre_lip', 'id_ip', 'estado_lip'];

        $encabezadosLeidos = array_map('trim', $headings[0][0]);
        sort($encabezadosLeidos);
        sort($encabezadosEsperados);

        //dd($encabezadosEsperados, $encabezadosLeidos);

        // Verificar si los encabezados coinciden
        // Comparamos si los encabezados obtenidos coinciden con los esperados
        if ($encabezadosLeidos !== $encabezadosEsperados) {
            return redirect()->back()->with('error', 'La estructura del archivo no es válida. Verifica los encabezados.');
        }

        // Continuar con la importación si todo está bien
        // Crear la instancia de la clase de importación
        $importar = new csvImportLogroIP;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todos los Avances de Actividades ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevos Avances de Actividades importados correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }

    public function ind_dep1($id) {
        $ind = IndicadorProducto::join('dependencias', 'dependencias.id', '=', 'indicador_productos.id_d')
                                ->selectRaw('indicador_productos.id as id, indicador_productos.codigo_ip')
                                ->where('dependencias.id', $id)
                                ->get();
        return response()->json($ind);
    }

    public function ind_act($id) {
        $acts = Actividad::join('indicador_productos', 'actividads.id_ip', '=', 'indicador_productos.id')
                            ->join('dependencias', 'dependencias.id', '=', 'indicador_productos.id_d')
                                ->selectRaw('actividads.id as id, actividads.codigo_a, actividads.nombre_a')
                                ->where('indicador_productos.id', $id)
                                ->get();
        foreach ($acts as $act) {
            $act->nombre_a = Str::limit($act->nombre_a, 60, '...');
        }
        return response()->json($acts);
    }

    public function rezago_ind_dep($id) {
        Log::info('Datos recibidos en rezago_ind_dep:', ['id' => $id]);      
        $valor = array_map('trim', explode('-', $id));
        $rez = $valor[0];
        $id_d = $valor[1];
        $id_est = $valor[2];
        $id_dim = $valor[3];
        $id_apu = $valor[4];
        $query = Actividad::selectRaw('
                indicador_productos.id as id,
                REPLACE(indicador_productos.codigo_ip, ",", ".") as codigo_ip,
                indicador_productos.nombre_ip as nombre_ip,
                indicador_productos.estado_ip as estado_ip,
                REPLACE(indicador_productos.meta_ip_real, ",", ".") as programadocuatrenio,
                programar_estrategicos.calculo as calculo,                
                SUM(CASE WHEN actividads.anio_a = 2024 THEN CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as programado2024,
                SUM(CASE WHEN actividads.anio_a = 2025 THEN CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as programado2025,
                SUM(CASE WHEN actividads.anio_a = 2026 THEN CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as programado2026,
                SUM(CASE WHEN actividads.anio_a = 2027 THEN CAST(REPLACE(actividads.aporte_a, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as programado2027,
                SUM(CASE WHEN avance_actividads.anio_aa = 2024 THEN CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as avance2024,
                SUM(CASE WHEN avance_actividads.anio_aa = 2025 THEN CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as avance2025,
                SUM(CASE WHEN avance_actividads.anio_aa = 2026 THEN CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as avance2026,
                SUM(CASE WHEN avance_actividads.anio_aa = 2027 THEN CAST(REPLACE(avance_actividads.avance_aa, ",", ".") AS DECIMAL(10,2)) ELSE 0 END) as avance2027
            ')
            ->leftJoin('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
            ->leftJoin('avance_actividads', 'avance_actividads.id_a', '=', 'actividads.id')
            ->leftJoin('programar_estrategicos', 'programar_estrategicos.id_ip', '=', 'indicador_productos.id')
            ->leftJoin('apuestas', 'apuestas.id', '=', 'indicador_productos.id_a')
            ->leftJoin('dimensions', 'dimensions.id', '=', 'apuestas.id_d')
            ->leftJoin('estrategias', 'estrategias.id', '=', 'dimensions.id_e')
            ->leftJoin('dependencias', 'dependencias.id', '=', 'indicador_productos.id_d');

            // ✅ Aplicar filtro por dependencia, solo si $id_d es diferente de 0
            if ($id_d != '0') {
                $query->where('dependencias.id', $id_d);
            }
            // ✅ Aplicar filtro por estrategia, solo si $id_est es diferente de 0
            if ($id_est != '0') {
                $query->where('estrategias.id', (int)$id_est);
            }
            // ✅ Aplicar filtro por dimensión, solo si $id_dim es diferente de 0
            if ($id_dim != '0') {
                $query->where('dimensions.id', (int)$id_dim);
            }
            // ✅ Aplicar filtro por apuesta, solo si $id_apu es diferente de 0
            if ($id_apu != '0') {
                $query->where('apuestas.id', (int)$id_apu);
            }
            $ips = $query
                ->groupBy(
                    'indicador_productos.id',
                    'programar_estrategicos.calculo'
                )
                ->get()
                ->map(function ($item) use ($id_d, $valor) {
                    $avance = [
                        (float) $item->avance2024,
                        (float) $item->avance2025,
                        (float) $item->avance2026,
                        (float) $item->avance2027,
                    ];
                    
                    $programado = [
                        (float) $item->programado2024,
                        (float) $item->programado2025,
                        (float) $item->programado2026,
                        (float) $item->programado2027,
                    ];

                    // Calcular avance total solo considerando los años programados
                    $avanceTotal = 0;
                    foreach ($avance as $index => $valor) {
                        if ($programado[$index] > 0) {
                            $avanceTotal += $valor;
                        }
                    }

                    $porcentaje2024 = ($programado[0] > 0) 
                                    ? number_format(($avance[0] / $programado[0]) * 100, 2) 
                                    : "No programado";
                    $porcentaje2025 = ($programado[1] > 0) 
                                    ? number_format(($avance[1] / $programado[1]) * 100, 2) 
                                    : "No programado";
                    $porcentaje2026 = ($programado[2] > 0) 
                                    ? number_format(($avance[2] / $programado[2]) * 100, 2) 
                                    : "No programado";
                    $porcentaje2027 = ($programado[3] > 0) 
                                    ? number_format(($avance[3] / $programado[3]) * 100, 2) 
                                    : "No programado";                                
                    $porcentajecuatrenio = number_format(($item->calculo == 1) 
                            ? ($avanceTotal / $item->programadocuatrenio) * 100 
                            : ($avanceTotal / ($programado[0] + $programado[1] + $programado[2] + $programado[3])) * 100, 2);
                    
                    if ($porcentaje2024 == "No programado")
                        $desemp2024 = "";
                    else {
                        if ($porcentaje2024 >= 0 && $porcentaje2024 < 40)
                            $desemp2024 = "Crítico";
                        else {
                            if ($porcentaje2024 >= 40 && $porcentaje2024 <= 60)
                                $desemp2024 = "Bajo";
                            else {
                                if ($porcentaje2024 > 60 && $porcentaje2024 <= 70)
                                    $desemp2024 = "Medio";
                                else {
                                    if ($porcentaje2024 > 70 && $porcentaje2024 <= 80)
                                        $desemp2024 = "Satisfactorio";
                                    else {
                                        if ($porcentaje2024 > 80 && $porcentaje2024 <= 100)
                                            $desemp2024 = "Sobresaliente";
                                        else
                                            $desemp2024 = "Sobre Ejecutado";
                                    }
                                }
                            }
                        }
                    }

                    if ($porcentaje2025 == "No programado")
                        $desemp2025 = "";
                    else {
                        if ($porcentaje2025 >= 0 && $porcentaje2025 < 40)
                            $desemp2025 = "Crítico";
                        else {
                            if ($porcentaje2025 >= 40 && $porcentaje2025 <= 60)
                                $desemp2025 = "Bajo";
                            else {
                                if ($porcentaje2025 > 60 && $porcentaje2025 <= 70)
                                    $desemp2025 = "Medio";
                                else {
                                    if ($porcentaje2025 > 70 && $porcentaje2025 <= 80)
                                        $desemp2025 = "Satisfactorio";
                                    else {
                                        if ($porcentaje2025 > 80 && $porcentaje2025 <= 100)
                                            $desemp2025 = "Sobresaliente";
                                        else
                                            $desemp2025 = "Sobre Ejecutado";
                                    }
                                }
                            }
                        }
                    }

                    if ($porcentaje2026 == "No programado")
                        $desemp2026 = "";
                    else {
                        if ($porcentaje2026 >= 0 && $porcentaje2026 < 40)
                            $desemp2026 = "Crítico";
                        else {
                            if ($porcentaje2026 >= 40 && $porcentaje2026 <= 60)
                                $desemp2026 = "Bajo";
                            else {
                                if ($porcentaje2026 > 60 && $porcentaje2026 <= 70)
                                    $desemp2026 = "Medio";
                                else {
                                    if ($porcentaje2026 > 70 && $porcentaje2026 <= 80)
                                        $desemp2026 = "Satisfactorio";
                                    else {
                                        if ($porcentaje2026 > 80 && $porcentaje2026 <= 100)
                                            $desemp2026 = "Sobresaliente";
                                        else
                                            $desemp2026 = "Sobre Ejecutado";
                                    }
                                }
                            }
                        }
                    }

                    if ($porcentaje2027 == "No programado")
                        $desemp2027 = "";
                    else {
                        if ($porcentaje2027 >= 0 && $porcentaje2027 < 40)
                            $desemp2027 = "Crítico";
                        else {
                            if ($porcentaje2027 >= 40 && $porcentaje2027 <= 60)
                                $desemp2027 = "Bajo";
                            else {
                                if ($porcentaje2027 > 60 && $porcentaje2027 <= 70)
                                    $desemp2027 = "Medio";
                                else {
                                    if ($porcentaje2027 > 70 && $porcentaje2027 <= 80)
                                        $desemp2027 = "Satisfactorio";
                                    else {
                                        if ($porcentaje2027 > 80 && $porcentaje2027 <= 100)
                                            $desemp2027 = "Sobresaliente";
                                        else
                                            $desemp2027 = "Sobre Ejecutado";
                                    }
                                }
                            }
                        }
                    }

                    if ($porcentajecuatrenio == "No programado")
                        $desempcuatrenio = "";
                    else {
                        if ($porcentajecuatrenio >= 0 && $porcentajecuatrenio < 40)
                            $desempcuatrenio = "Crítico";
                        else {
                            if ($porcentajecuatrenio >= 40 && $porcentajecuatrenio <= 60)
                                $desempcuatrenio = "Bajo";
                            else {
                                if ($porcentajecuatrenio > 60 && $porcentajecuatrenio <= 70)
                                    $desempcuatrenio = "Medio";
                                else {
                                    if ($porcentajecuatrenio > 70 && $porcentajecuatrenio <= 80)
                                        $desempcuatrenio = "Satisfactorio";
                                    else {
                                        if ($porcentajecuatrenio > 80 && $porcentajecuatrenio <= 100)
                                            $desempcuatrenio = "Sobresaliente";
                                        else
                                            $desempcuatrenio = "Sobre Ejecutado";
                                    }
                                }
                            }
                        }
                    }
                    
                    return (object) [
                        'id' => $item->id,
                        'id_d' => $id_d,
                        'codigo_ip' => $item->codigo_ip,
                        'nombre_ip' => $item->nombre_ip,
                        'programado2024' => $programado[0],
                        'programado2025' => $programado[1],
                        'programado2026' => $programado[2],
                        'programado2027' => $programado[3],
                        'programadocuatrenio' => (float) $item->programadocuatrenio,
                        'avance2024' => $avance[0],
                        'avance2025' => $avance[1],
                        'avance2026' => $avance[2],
                        'avance2027' => $avance[3],
                        'calculo' => $item->calculo,
                        'cantidad' => $programado[0] + $programado[1] + $programado[2] + $programado[3],
                        'estado_ip' => $item->estado_ip,
                        'porcentaje2024' => $porcentaje2024,
                        'porcentaje2025' => $porcentaje2025,
                        'porcentaje2026' => $porcentaje2026,
                        'porcentaje2027' => $porcentaje2027,
                        'porcentajecuatrenio' => $porcentajecuatrenio,
                        'avancetotal' => $avanceTotal,
                        'desemp2024' => $desemp2024,
                        'desemp2025' => $desemp2025,
                        'desemp2026' => $desemp2026,
                        'desemp2027' => $desemp2027,
                        'desempcuatrenio' => $desempcuatrenio,
                    ];
                })
                ->filter(function ($item) use ($rez) {
                    // Caso 1: Mostrar todos los indicadores
                    if ($rez == 0 || $rez == 1) {
                        return true; // No filtrar por dependencia ni rezago
                    }
                    $anio = preg_replace('/_\d$/', '', $rez);
                    if (substr($rez, -1) >= 0 && substr($rez, -1) <= 3) {
                        $campo = "porcentaje{$anio}";    
                    }
                    else
                        $campo = "desemp{$anio}";                    
                    if (str_ends_with($rez, '_1')) {
                        // Caso "1": solo mostrar los que tienen "No programado"
                        return $item->$campo === "No programado";
                    }
                    elseif (str_ends_with($rez, '_2')) {
                        // Caso "2": solo mostrar los que se han ejecutado 100%"
                        return $item->$campo === "100.00";
                    }
                    elseif (str_ends_with($rez, '_3')) {
                        // Caso "3": solo mostrar los que no se han ejecutado"
                        return $item->$campo === "0.00";
                    }
                    elseif (str_ends_with($rez, '_0')) {
                        $valor = $item->$campo;
                        Log::info("Campo: $campo, Valor: $valor");
                        // Caso "4": solo mostrar los que tienen rezago"
                        return floatval(str_replace(',', '.', $item->$campo)) > 0 && floatval(str_replace(',', '.', $item->$campo)) < 100;
                    }
                    elseif (str_ends_with($rez, '_4')) {
                        // Caso "5": solo mostrar los que tienen desempeño crítico"
                        return $item->$campo === "Crítico";
                    }
                    elseif (str_ends_with($rez, '_5')) {
                        // Caso "6": solo mostrar los que tienen desempeño bajo"
                        return $item->$campo === "Bajo";
                    }
                    elseif (str_ends_with($rez, '_6')) {
                        // Caso "7": solo mostrar los que tienen desempeño medio"
                        return $item->$campo === "Medio";
                    }
                    elseif (str_ends_with($rez, '_7')) {
                        // Caso "8": solo mostrar los que tienen desempeño satisfactorio"
                        return $item->$campo === "Satisfactorio";
                    }
                    elseif (str_ends_with($rez, '_8')) {
                        // Caso "9": solo mostrar los que tienen desempeño sobresaliente"
                        return $item->$campo === "Sobresaliente";
                    }
                    else {
                        // Caso "10": solo mostrar los que tienen desempeño sobre ejecutado"
                        return $item->$campo === "Sobre Ejecutado";
                    }
                })
                ->values(); // Reindexa los resultados después del filter
                return response()->json($ips);
    }

    public function rezago1($id) {
        // Dividir el string por el carácter '_'
        $partes = explode('_', $id);
        // Asignar las partes a variables
        $id_a = $partes[0]; // Primera parte (id de la actividad)
        $anio = $partes[2]; // Segunda parte (Anio)
        $trimestre = $partes[3]; // Tercera parte (Trimestre)
        $id_dep = $partes[4]; // Quinta parte (Dependencia)
        $pro = AvanceActividad::where('id_a', $id_a)
                                ->where('anio_aa', $anio)
                                ->where('trimestre_aa', $trimestre)->get();
        if ($pro->count() == 0 && $partes[5] == 0) {
            $ava = Actividad::select('actividads.aporte_a as valor_programado')
                                ->where('actividads.anio_a', $anio)
                                ->where('actividads.trimestre_a', $trimestre)
                                ->where('actividads.id_dep', $id_dep)
                                ->where('actividads.id', $id_a)
                                ->get();
            if ($ava->count() == 0) {
                return response()->json('El periodo no fué programado');
            }
            return response()->json($ava);
        }
        else {
            if ($partes[5] == 1) {
                $ava = Actividad::select('aporte_a as valor_programado')
                                    ->where('id', $id_a)
                                    ->get();
                return response()->json($ava);
            }
            else
                return response()->json('El periodo ya fué programado');
        }
    }
}

