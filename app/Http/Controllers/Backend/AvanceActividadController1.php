<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\AvanceActividad;
use  App\Models\AvanceEstrategico;
use App\Models\IndicadorProducto;
use App\Models\ProgramarEstrategico;
use App\Models\Dependencia;
use App\Models\Evidencias;
use App\Imports\csvImportAvaAct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AvanceActividadController extends Controller
{
    //
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

            return view('admin/avaact.index1', compact('usuario', 'nombre', 'rol', 'dependencia', 'ips', 'dependencias'));
        }
        return Redirect::route('login');
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
        $tot = 0;
        // Guarda las evidencias en el disco
        if ($request->hasFile('evidencias')) {
            /*return response()->json([
                'success' => true,
                'message' => 'Archivos recibidos correctamente',
                'files' => $request->file('evidencias')
            ]);*/
            //dd($request->file('evidencias')); // 👈 Verifica qué está recibiendo
            foreach ($request->file('evidencias') as $archivo) {
            //$archivos = $request->file('evidencias');
            //$tot = is_array($archivos) ? count($archivos) : 1;
            
            // Asegurarse de que $archivos sea siempre un array
            //foreach ((is_array($archivos) ? $archivos : [$archivos]) as $archivo) {
                $tot = $tot + 1;
                $nombreArchivo = 'Ind_'.$ip.'_Act_'.$a.'_'.$archivo->getClientOriginalName();
                $ruta = $archivo->storeAs('evidencias', $nombreArchivo, 'public');

                /*if (!$ruta) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Hubo un error al guardar la evidencia'
                    ]);
                }*/
    
                // Guardar las evidencias en la tabla
                
                $evid = new Evidencias();
                $evid->evidencia = $ruta;
                $evid->anio_a = $request->input('anio');
                $evid->trimestre_a = $request->input('trimestre');
                $evid->id_aa = $id;
                $evid->estado_e = "Activo";
                $evid->save();
            }
        }
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

        $id = $request->id_ip;
        //return redirect()->route('listaravaacts')->with('success', 'Avance de la Actividad creado correctamente, con '.$tot.' evidencias');
        /*return request()->ajax()
                ? response()->json(['success' => true, 'message' => 'Avance de la Actividad creado correctamente, con '.$tot.' evidencias'])
                : redirect()->route('listaravaacts')->with('success', 'Avance de la Actividad creado correctamente, con '.$tot.' evidencias');*/
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Avance de la Actividad creado correctamente con '.$tot.' evidencias',
                'redirect' => route('ver_ind1', ['id' => $id])
            ]);
        }
        return redirect()->route('listaravaacts')->with('success', 'Avance de la Actividad creado correctamente, con '.$tot.' evidencias');                
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
            /*$acts = Actividad::where('actividads.id_ip', $id)->get();*/
            $acts = Actividad::leftJoin('avance_actividads', 'actividads.id', '=', 'avance_actividads.id_a')
                            ->select('actividads.*', DB::raw('IF(COUNT(avance_actividads.id) > 0, 1, 0) as avance'))
                            ->where('actividads.id_ip', $id)
                            ->groupBy('actividads.id'); // Agregado para evitar errores con COUNT()
            /*// Ordenar las actividades según el código 'codigo_a'
            $acts = $acts->sortBy(function ($actividad) {
                return $this->ordenarCodigo($actividad->codigo_a);
            });
            $faltan = 0;
            $total = 0;
            foreach ($acts as $act) {
                if ($act->avance == 0)
                    $faltan++;
                $total++;
            }*/
            // Obtener los datos
            $acts = $acts->orderBy('actividads.codigo_a')->get(); // OPTIMIZADO: Ordenar en la consulta

            // Contar los avances
            $faltan = $acts->where('avance', 0)->count();
            $total = $acts->count();
            //return response()->json($acts);
            $ip = IndicadorProducto::find($id);
            return view('admin/avaact.index2', compact('usuario', 'nombre', 'rol', 'dependencia', 'acts', 'ip', 'dependencias', 'faltan', 'total'));
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
        // Construir la consulta base
        $query = Actividad::leftJoin('avance_actividads', 'actividads.id', '=', 'avance_actividads.id_a')
                            ->select('actividads.*', DB::raw('IF(EXISTS(SELECT 1 FROM avance_actividads WHERE avance_actividads.id_a = actividads.id), 1, 0) as avance'))
                            ->where('actividads.id_ip', $ind) // CORREGIDO: Se usa $ind en lugar de $id
                            ->groupBy('actividads.id');

        // Aplicar filtros según el año y el trimestre
        if ($anio != 0) {
            $query->where('actividads.anio_a', $anio);
        }
        if ($trim != 0) {
            $query->where('actividads.trimestre_a', $trim);
        }

        // Obtener los datos
        $datos = $query->orderBy('actividads.codigo_a')->get(); // OPTIMIZADO: Ordenar en la consulta

        // Contar los avances
        $faltan = $datos->where('avance', 0)->count();
        $total = $datos->count();
        /*if ($anio != 0 and $trim != 0) {
            $datos = Actividad::leftJoin('avance_actividads', 'actividads.id', '=', 'avance_actividads.id_a')
                            ->select('actividads.*', DB::raw('IF(COUNT(avance_actividads.id) > 0, 1, 0) as avance'))
                            ->where('actividads.id_ip', $ind)
                            ->where('actividads.anio_a', $anio)
                            ->where('actividads.trimestre_a', $trim)
                            ->groupBy('actividads.id') // Agregado para evitar errores con COUNT()
                            ->get();
            // Ordenar las actividades según el código 'codigo_a'
            $datos = $datos->sortBy(function ($actividad) {
                return $this->ordenarCodigo($actividad->codigo_a);
            });
            /*$datos = Actividad::where('id_ip', $ind)
                                ->where('anio_a', $anio)
                                ->where('trimestre_a', $trim)
                                ->get();*/
        /*}
        else {
            if ($anio != 0 and $trim == 0) {
                $datos = Actividad::leftJoin('avance_actividads', 'actividads.id', '=', 'avance_actividads.id_a')
                            ->select('actividads.*', DB::raw('IF(COUNT(avance_actividads.id) > 0, 1, 0) as avance'))
                            ->where('actividads.id_ip', $ind)
                            ->where('actividads.anio_a', $anio)
                            ->groupBy('actividads.id') // Agregado para evitar errores con COUNT()
                            ->get();
                // Ordenar las actividades según el código 'codigo_a'
                $datos = $datos->sortBy(function ($actividad) {
                    return $this->ordenarCodigo($actividad->codigo_a);
                });
                /*$datos = Actividad::where('id_ip', $ind)
                                    ->where('anio_a', $anio)
                                    ->get();*/
            /*}
            else {
                if ($anio == 0 and $trim != 0) {
                    $datos = Actividad::leftJoin('avance_actividads', 'actividads.id', '=', 'avance_actividads.id_a')
                            ->select('actividads.*', DB::raw('IF(COUNT(avance_actividads.id) > 0, 1, 0) as avance'))
                            ->where('actividads.id_ip', $ind)
                            ->where('actividads.trimestre_a', $trim)
                            ->groupBy('actividads.id') // Agregado para evitar errores con COUNT()
                            ->get();
                    // Ordenar las actividades según el código 'codigo_a'
                    $datos = $datos->sortBy(function ($actividad) {
                        return $this->ordenarCodigo($actividad->codigo_a);
                    });
                    /*$datos = Actividad::where('id_ip', $ind)
                                        ->where('trimestre_a', $trim)
                                        ->get();*/
                /*}
                else {
                    $datos = Actividad::leftJoin('avance_actividads', 'actividads.id', '=', 'avance_actividads.id_a')
                            ->select('actividads.*', DB::raw('IF(COUNT(avance_actividads.id) > 0, 1, 0) as avance'))
                            ->where('actividads.id_ip', $ind)
                            ->groupBy('actividads.id') // Agregado para evitar errores con COUNT()
                            ->get();
                    // Ordenar las actividades según el código 'codigo_a'
                    $datos = $datos->sortBy(function ($actividad) {
                        return $this->ordenarCodigo($actividad->codigo_a);
                    });
                    //$datos = Actividad::where('id_ip', $ind)->get();
                }
            }
        }
        $faltan = 0;
        $total = 0;
        foreach ($datos as $dato) {
            if ($dato->avance == 0)
                $faltan++;
            $total++;
        }*/
        return response()->json([$datos,$faltan,$total]);
    }
    
    public function veravaact($id) {
        $avaact = Actividad::join('avance_actividads', 'actividads.id', '=', 'avance_actividads.id_a')
                            ->join('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
                            ->join('dependencias', 'dependencias.id', '=', 'indicador_productos.id_d')
                            ->leftjoin('evidencias', 'avance_actividads.id', '=', 'evidencias.id_aa')
                            ->select('actividads.codigo_a as codigo_a', 'actividads.nombre_a as nombre_a', 'indicador_productos.codigo_ip as codigo_ip', 'indicador_productos.nombre_ip as nombre_ip', 'dependencias.nombre_d as nombre_d', 'avance_actividads.anio_aa as anio', 'avance_actividads.trimestre_aa as trimestre', 'actividads.aporte_a as aporte', 'avance_actividads.avance_aa as avance', DB::raw('GROUP_CONCAT(evidencias.evidencia SEPARATOR "|") as evidencias'), 'avance_actividads.estado_aa as estado', 'avance_actividads.created_at as created_at', 'avance_actividads.updated_at as updated_at', DB::raw('(SELECT SUM(CAST(REPLACE(aporte_a, ",", ".") AS DECIMAL(10,2))) FROM actividads) AS total_aporte_cuatrenio'), DB::raw('(SELECT COUNT(*) FROM actividads) AS total_registros_cuatrenio'),
                            // 🔹 Reemplaza "," por "." en el campo `aporte_a`
                            DB::raw('REPLACE(actividads.aporte_a, ",", ".") as aporte'),

                            'avance_actividads.avance_aa as avance',
                            // 🔹 Suma del aporte para el mismo año del avance (`anio_aa`)
                            DB::raw('(SELECT SUM(CAST(REPLACE(aporte_a, ",", ".") AS DECIMAL(10,2))) FROM actividads 
                                    INNER JOIN avance_actividads AS aa ON actividads.id = aa.id_a
                                    WHERE aa.anio_aa = avance_actividads.anio_aa) AS total_aporte_anio'),

                            // 🔹 Contar el total de registros para el mismo año del avance (`anio_aa`)
                            DB::raw('(SELECT COUNT(*) FROM actividads 
                                    INNER JOIN avance_actividads AS aa ON actividads.id = aa.id_a
                                    WHERE aa.anio_aa = avance_actividads.anio_aa) AS total_registros_anio'))
                            ->where('actividads.id', $id)
                            ->groupBy(
                                'actividads.codigo_a',
                                'actividads.nombre_a',
                                'indicador_productos.codigo_ip',
                                'indicador_productos.nombre_ip',
                                'dependencias.nombre_d',
                                'avance_actividads.anio_aa',
                                'avance_actividads.trimestre_aa',
                                'actividads.aporte_a',
                                'avance_actividads.avance_aa',
                                'avance_actividads.estado_aa',
                                'avance_actividads.created_at',
                                'avance_actividads.updated_at'
                            )
                            ->get();
        return response()->json($avaact);
    }

    public function editaravaact($id) {
        $avaact = Actividad::join('avance_actividads', 'actividads.id', '=', 'avance_actividads.id_a')
                            ->join('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
                            ->join('dependencias', 'dependencias.id', '=', 'indicador_productos.id_d')
                            ->leftjoin('evidencias', 'avance_actividads.id', '=', 'evidencias.id_aa')
                            ->select('avance_actividads.id as id', 'indicador_productos.id as id_ip', 'dependencias.id as id_d', 'avance_actividads.avance_aa as avance_aa', 'actividads.aporte_a as aporte_a', 'actividads.id as id_a', 'actividads.anio_a as anio', 'actividads.trimestre_a as trimestre', 'avance_actividads.estado_aa as estado', DB::raw('GROUP_CONCAT(evidencias.id, ",", evidencias.evidencia SEPARATOR "|") as evidencias'))
                            ->where('avance_actividads.id', $id)
                            ->groupBy(
                                'avance_actividads.id',
                                'indicador_productos.id',
                                'dependencias.id',
                                'avance_actividads.avance_aa',
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
            'anio' => 'required',
            'trimestre' => 'required',
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
        // Guarda las evidencias en el disco
        if ($request->hasFile('evidencias')) {
            foreach ($request->file('evidencias') as $archivo) {
                $tot = $tot + 1;
                $nombreArchivo = 'Ind_'.$ip.'_Act_'.$a.'_'.$archivo->getClientOriginalName();
                $ruta = $archivo->storeAs('evidencias', $nombreArchivo, 'public');
    
                // Guardar las evidencias en la tabla
                
                $evid = new Evidencias();
                $evid->evidencia = $ruta;
                $evid->anio_a = $request->input('anio');
                $evid->trimestre_a = $request->input('trimestre');
                $evid->id_aa = $id;
                $evid->estado_e = "Activo";
                $evid->save();
            }
        }
        //return response()->json($request);
        $avaact = AvanceActividad::find($request->input('id'));
        $avaact->avance_aa = $request->input('avance');
        $avaact->anio_aa = $request->input('anio');
        $avaact->trimestre_aa = $request->input('trimestre');
        $avaact->id_a = $request->input('id_a');
        $avaact->estado_aa = $request->input('estado');
        $avaact->save();
        return redirect()->route('listaravaacts')->with('success', 'Avance de la Actividad actualizado correctamente y se agregaron '.$tot.' evidencias');
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
        $encabezadosEsperados = ['id_a', 'avance_aa', 'anio_aa', 'trimestre_aa', 'estado_aa'];

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
