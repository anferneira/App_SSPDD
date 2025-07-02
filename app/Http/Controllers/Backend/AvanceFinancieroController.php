<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Estrategia;
use App\Models\Dimension;
use App\Models\Apuesta;
use App\Models\AvanceFinanciero;
use App\Models\IndicadorProducto;
use App\Models\Municipio;
use App\Models\GrupoPoblacional;
use App\Models\Dependencia;
use App\Imports\csvImportAvaFin;
use App\Models\DependenciaDimension;
use App\Models\DependenciaEstrategia;
use App\Models\GrupoPoblacion;
use App\Models\ProgramarFinanciero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Support\Str;

class AvanceFinancieroController extends Controller
{
    //
    public function listaravafins() {
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
            
        // Definir años y trimestres disponibles
        $anios = [
            2024 => [3, 4],
            2025 => [1, 2, 3, 4],
            2026 => [1, 2, 3, 4],
            2027 => [1, 2, 3, 4],
        ];

        // Definir los campos a sumar
        $campos = ['icld', 'icde', 'sgpe', 'sgps', 'sgpapsb', 'rped', 'sgr', 'cr', 'g', 'co', 'or'];

        // Iniciar la consulta base trayendo todos los campos de indicador_productos
        $query = DB::table('indicador_productos AS ip')
            ->select('ip.*');

        // Agregar selectRaw dinámicamente para cada año
        foreach ($anios as $anio => $trimestres) {
            foreach (['programado', 'avance'] as $tipo) {
                $selects = [];
                foreach ($campos as $campo) {
                    if ($tipo === 'programado') {
                        foreach ($trimestres as $trimestre) {
                            $columna = "{$campo}_{$anio}_{$trimestre}";
                            $selects[] = "IFNULL(SUM(pf.{$columna}),0)";
                        }
                    } else {
                        $selects[] = "IFNULL(SUM(CASE WHEN af.anio_af = {$anio} THEN af.{$campo} END),0)";
                    }
                }
                $alias = "{$tipo}_{$anio}";
                $query->selectRaw('(' . implode(' + ', $selects) . ') AS '.$alias);
            }
        }

        // Relacionar las tablas
        $query->leftJoin('programar_financieros AS pf', 'pf.id_ip', '=', 'ip.id')
            ->leftJoin('avance_financieros AS af', 'af.id_pf', '=', 'pf.id')
            ->groupBy('ip.id')
            ->orderBy('ip.id', 'asc');

        // Obtener resultados y calcular los porcentajes
        $ips = $query->get()->map(function ($item) use ($anios) {
            $total_programado = 0;
            $total_avance = 0;

            foreach ($anios as $anio => $trimestres) {
                // Reemplazar coma por punto y convertir a float
                $programado_raw = str_replace(',', '.', $item->{'programado_'.$anio});
                $avance_raw = str_replace(',', '.', $item->{'avance_'.$anio});
                $programado = (float) $programado_raw;
                $avance = (float) $avance_raw;

                $porcentaje = ($programado > 0) ? ($avance / $programado) * 100 : 0;

                // Asegurar 2 decimales siempre (string)
                //$item->{'programado_'.$anio} = number_format($programado, 2, '.', '');
                //$item->{'avance_' . $anio} = number_format($avance, 2, '.', '');
                if  ($programado > 0) {
                    $item->{'porcentaje_'.$anio} = number_format($porcentaje, 2, '.', '');
                    $item->{'nivel_desempeno_'.$anio} = $this->calcularNivelDesempeno($porcentaje);
                }
                else {
                    $item->{'porcentaje_'.$anio} = "No programado";
                    $item->{'nivel_desempeno_'.$anio} = "";
                }
                $total_programado += $programado;
                $total_avance += $avance;
            }

            // Totales cuatrienio con 2 decimales
            $item->programado_cuatrenio = number_format($total_programado, 2, '.', '');
            $item->avance_cuatrenio = number_format($total_avance, 2, '.', '');
            $porcentaje_cuatrenio = ($total_programado > 0) ? ($total_avance / $total_programado) * 100 : 0;
            $item->porcentaje_cuatrenio = number_format($porcentaje_cuatrenio, 2, '.', '');
            $item->nivel_desempeno_cuatrenio = $this->calcularNivelDesempeno($porcentaje_cuatrenio);

            return $item;
        });

        //return response()->json($ips);

        if (Auth::check()) {
            //return response()->json($ips);
            return view('admin/avafin.index1', compact('usuario', 'nombre', 'rol', 'dependencia', 'ips', 'dependencias', 'estrategias', 'dimensions', 'apuestas'));
        }
        else {
            return Redirect::route('login');
        }
    }

    public function ver_ind2($id) {
        // Definir años y trimestres disponibles
        $anios = [
            2024 => [3, 4],
            2025 => [1, 2, 3, 4],
            2026 => [1, 2, 3, 4],
            2027 => [1, 2, 3, 4],
        ];

        // Definir los campos a sumar
        $campos = ['icld', 'icde', 'sgpe', 'sgps', 'sgpapsb', 'rped', 'sgr', 'cr', 'g', 'co', 'or'];

        // Iniciar la consulta base trayendo todos los campos de indicador_productos
        $query = DB::table('indicador_productos AS ip')
            ->select('ip.*')->where('ip.id_d', $id);

        // Agregar selectRaw dinámicamente para cada año
        foreach ($anios as $anio => $trimestres) {
            foreach (['programado', 'avance'] as $tipo) {
                $selects = [];
                foreach ($campos as $campo) {
                    if ($tipo === 'programado') {
                        foreach ($trimestres as $trimestre) {
                            $columna = "{$campo}_{$anio}_{$trimestre}";
                            $selects[] = "IFNULL(SUM(pf.{$columna}),0)";
                        }
                    } else {
                        $selects[] = "IFNULL(SUM(CASE WHEN af.anio_af = {$anio} THEN af.{$campo} END),0)";
                    }
                }
                $alias = "{$tipo}_{$anio}";
                $query->selectRaw('(' . implode(' + ', $selects) . ') AS '.$alias);
            }
        }

        // Relacionar las tablas
        $query->leftJoin('programar_financieros AS pf', 'pf.id_ip', '=', 'ip.id')
            ->leftJoin('avance_financieros AS af', 'af.id_pf', '=', 'pf.id')
            ->groupBy('ip.id')
            ->orderBy('ip.id', 'asc');

        // Obtener resultados y calcular los porcentajes
        $ips = $query->get()->map(function ($item) use ($anios) {
            $total_programado = 0;
            $total_avance = 0;

            foreach ($anios as $anio => $trimestres) {
                // Reemplazar coma por punto y convertir a float
                $programado_raw = str_replace(',', '.', $item->{'programado_'.$anio});
                $avance_raw = str_replace(',', '.', $item->{'avance_'.$anio});
                $programado = (float) $programado_raw;
                $avance = (float) $avance_raw;

                $porcentaje = ($programado > 0) ? ($avance / $programado) * 100 : 0;

                // Asegurar 2 decimales siempre (string)
                //$item->{'programado_'.$anio} = number_format($programado, 2, '.', '');
                //$item->{'avance_' . $anio} = number_format($avance, 2, '.', '');
                if  ($programado > 0) {
                    $item->{'porcentaje_'.$anio} = number_format($porcentaje, 2, '.', '');
                    $item->{'nivel_desempeno_'.$anio} = $this->calcularNivelDesempeno($porcentaje);
                }
                else {
                    $item->{'porcentaje_'.$anio} = "No programado";
                    $item->{'nivel_desempeno_'.$anio} = "";
                }
                $total_programado += $programado;
                $total_avance += $avance;
            }

            // Totales cuatrienio con 2 decimales
            $item->programado_cuatrenio = number_format($total_programado, 2, '.', '');
            $item->avance_cuatrenio = number_format($total_avance, 2, '.', '');
            $porcentaje_cuatrenio = ($total_programado > 0) ? ($total_avance / $total_programado) * 100 : 0;
            $item->porcentaje_cuatrenio = number_format($porcentaje_cuatrenio, 2, '.', '');
            $item->nivel_desempeno_cuatrenio = $this->calcularNivelDesempeno($porcentaje_cuatrenio);

            return $item;
        });

        //return response()->json($ips);

        if (Auth::check()) {
            return response()->json($ips);
            //return view('admin/avafin.index1', compact('usuario', 'nombre', 'rol', 'dependencia', 'ips', 'dependencias'));
        }
        else {
            return Redirect::route('login');
        }
    }

    private function calcularNivelDesempeno($porcentaje)
    {
        if ($porcentaje < 40) {
            return 'Crítico';
        } elseif ($porcentaje <= 60) {
            return 'Bajo';
        } elseif ($porcentaje <= 70) {
            return 'Medio';
        } elseif ($porcentaje <= 80) {
            return 'Satisfactorio';
        } elseif ($porcentaje <= 100) {
            return 'Sobresaliente';
        } else {
            return 'Sobre Ejecutado';
        }
    }

    public function ver_avances($id) {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $avafins = AvanceFinanciero::where('id_ip', $id)->get();
            $ip = IndicadorProducto::find($id);
            $muns = Municipio::all();
            $gp = GrupoPoblacion::all();
            $ips = IndicadorProducto::all()->map(function ($ip) {
                $ip->codigo_ip = str_replace(',', '.', $ip->codigo_ip);
                return $ip;
            });
            return view('admin/avafin.index2', compact('usuario', 'nombre', 'rol', 'dependencia', 'avafins', 'ip', 'muns', 'ips', 'gp'));
        }
        return Redirect::route('login');
    }

    public function guardaravafin(Request $request) {
        $request->validate([
            'anio_af' => 'required',
            'bpin' => 'required',
            'trimestre_af' => 'required',
            'avance_icld' => 'required',
            'avance_icde' => 'required',
            'avance_sgpe' => 'required',
            'avance_sgps' => 'required',
            'avance_sgpapsb' => 'required',
            'avance_rped' => 'required',
            'avance_sgr' => 'required',
            'avance_cr' => 'required',
            'avance_g' => 'required',
            'avance_co' => 'required',
            'avance_or' => 'required',
            'desc_fin' => 'required',
            'id_pf' => 'required|exists:programar_financieros,id'
        ]);
        $ip = Str::before($request->ip, '.');
        $ip = IndicadorProducto::where('codigo_ip', $ip)->first();
        $avafin = new AvanceFinanciero();
        $avafin->ICLD = $request->input('avance_icld');
        $avafin->ICDE = $request->input('avance_icde');
        $avafin->SGPE = $request->input('avance_sgpe');
        $avafin->SGPS = $request->input('avance_sgps');
        $avafin->SGPAPSB = $request->input('avance_sgpapsb');
        $avafin->RPED = $request->input('avance_rped');
        $avafin->SGR = $request->input('avance_sgr');
        $avafin->CR = $request->input('avance_cr');
        $avafin->G = $request->input('avance_g');
        $avafin->CO = $request->input('avance_co');
        $avafin->OR = $request->input('avance_or');
        $avafin->anio_af = $request->input('anio_af');
        $avafin->trimestre_af = $request->input('trimestre_af');
        $avafin->logro_af = $request->input('desc_fin');
        $avafin->id_pf = $request->input('id_pf');
        $avafin->bpin_af = $request->input('bpin');
        $avafin->estado_af = 'Activo';
        $avafin->save();
        return redirect()->route('ver_avanfin', ['id' => $ip])->with('success', 'Avance financiero creado correctamente para el periodo '.$request->anio_af.'_'.$request->trimestre_af);
    }

    public function traer_financiero_anio($id) {
        $progs = ProgramarFinanciero::where('id_ip', $id)->get();
        return response()->json($progs);
    }

    public function veravafin($id) {
        $avafin = AvanceFinanciero::with('avancefin.indproducto.dependencia')->find($id);
        return response()->json($avafin);
    }

    public function ver_avanfin($id) {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $ip = IndicadorProducto::with('indproducto.avancefin')->find($id);
            
            $periodos = [
                '_2024_3', '_2024_4', '_2025_1', '_2025_2', '_2025_3', '_2025_4',
                '_2026_1', '_2026_2', '_2026_3', '_2026_4', '_2027_1', '_2027_2',
                '_2027_3', '_2027_4'
            ];
            $campos = ['ICLD', 'ICDE', 'SGPE', 'SGPS', 'SGPAPSB', 'RPED', 'SGR', 'CR', 'G', 'CO', 'OR'];
            foreach ($ip->indproducto as $pro) {
                $programado_trimestres = [];

                // Recorremos todos los periodos posibles
                foreach ($periodos as $p) {
                    $anio_trim = explode('_', trim($p, '_'));
                    $anio = $anio_trim[0];
                    $trim = $anio_trim[1];

                    // Calcular total programado para ese periodo
                    $total_programado = 0;
                    foreach ($campos as $campo) {
                        $valor = str_replace(',', '.', $pro->{$campo . $p});
                        $total_programado += (float) $valor;
                    }

                    $programado_trimestres[$p] = [
                        'anio' => $anio,
                        'trimestre' => $trim,
                        'total_programado' => $total_programado,
                    ];
                }

                // Reemplazamos los avances con los trimestres combinados (avance + programado)
                $nuevos_avances = [];

                foreach ($programado_trimestres as $p => $info) {
                    $anio = $info['anio'];
                    $trim = $info['trimestre'];
                    $total_programado = $info['total_programado'];

                    // Si el total programado es 0, no agregar el registro
                    if ($total_programado == 0) {
                        continue; // <<<< OMITIR este periodo
                    }

                    // Buscar si existe avance real en ese periodo
                    $avance = $pro->avancefin->firstWhere(function ($a) use ($anio, $trim) {
                        return $a->anio_af == $anio && $a->trimestre_af == $trim;
                    });

                    if ($avance) {
                        $total_avance = 0;
                        foreach ($campos as $campo) {
                            $avance->$campo = str_replace(',', '.', $avance->$campo);
                            $total_avance += (float) $avance->$campo;
                        }
                        $avance->total_Avance = $total_avance;
                    } else {
                        // Crear un objeto vacío de avance
                        $avance = new \stdClass();
                        $avance->anio_af = $anio;
                        $avance->trimestre_af = $trim;
                        $avance->id_pf = $pro->id;
                        foreach ($campos as $campo) {
                            $avance->$campo = 0;
                        }
                        $avance->total_Avance = 0;
                    }

                    $avance->total_Programado = $total_programado;

                    $porcentaje = ($avance->total_Avance / $total_programado) * 100;
                    $avance->porcentaje_periodo = number_format($porcentaje, 2, '.', '');
                    if ($porcentaje >= 0 && $porcentaje < 40) {
                        $avance->desempenio_periodo = "Crítico";
                    } elseif ($porcentaje >= 40 && $porcentaje <= 60) {
                        $avance->desempenio_periodo = "Bajo";
                    } elseif ($porcentaje > 60 && $porcentaje <= 70) {
                        $avance->desempenio_periodo = "Medio";
                    } elseif ($porcentaje > 70 && $porcentaje <= 80) {
                        $avance->desempenio_periodo = "Satisfactorio";
                    } elseif ($porcentaje > 80 && $porcentaje <= 100) {
                        $avance->desempenio_periodo = "Sobresaliente";
                    } else {
                        $avance->desempenio_periodo = "Sobre Ejecutado";
                    }

                    // Calcular porcentaje anual
                    $trimestres = ($anio == '2024') ? [3, 4] : [1, 2, 3, 4];
                    $total_programado_anual = 0;
                    foreach ($trimestres as $t) {
                        foreach ($campos as $campo) {
                            $valor = str_replace(',', '.', $pro->{$campo . "_{$anio}_{$t}"});
                            $total_programado_anual += (float) $valor;
                        }
                    }

                    $avance_trimestre = $avance->total_Avance;
                    if ($total_programado_anual == 0) {
                        $avance->porcentaje_anio = 'No Programado';
                        $avance->desempenio_anio = 'No Programado';
                    } else {
                        $porc_anual = ($avance_trimestre / $total_programado_anual) * 100;
                        $avance->porcentaje_anio = number_format($porc_anual, 2, '.', '');
                        if ($porc_anual >= 0 && $porc_anual < 40) {
                            $avance->desempenio_anio = "Crítico";
                        } elseif ($porc_anual >= 40 && $porc_anual <= 60) {
                            $avance->desempenio_anio = "Bajo";
                        } elseif ($porc_anual > 60 && $porc_anual <= 70) {
                            $avance->desempenio_anio = "Medio";
                        } elseif ($porc_anual > 70 && $porc_anual <= 80) {
                            $avance->desempenio_anio = "Satisfactorio";
                        } elseif ($porc_anual > 80 && $porc_anual <= 100) {
                            $avance->desempenio_anio = "Sobresaliente";
                        } else {
                            $avance->desempenio_anio = "Sobre Ejecutado";
                        }
                    }

                    $nuevos_avances[] = $avance;
                }

                // Reemplazamos la colección original de avances por la nueva
                $pro->avancefin = collect($nuevos_avances);
            }
            /*foreach ($ip->indproducto as $pro) {
                dd($pro->avancefin); // Así verificas que sí tiene los avances asignados
            }*/
            
            $total = 0;
            $faltan = 0;
            $avances = 0;

            foreach ($ip->indproducto as $pro) {
                foreach ($pro->avancefin as $avance) {
                    $total++;

                    $sumaAvance = 0;
                    foreach ($campos as $campo) {
                        $sumaAvance += (float) str_replace(',', '.', $avance->$campo);
                    }

                    if ($sumaAvance > 0) {
                        $avances++;
                    }
                }
            }

            $faltan = $total - $avances;

            return view('admin/avafin.index2', compact('usuario', 'nombre', 'rol', 'dependencia', 'ip', 'faltan', 'total'));
        }
        return Redirect::route('login');
    }

    public function verfinip($id) {
        $ip = IndicadorProducto::with('indproducto.avancefin')->find($id);

        $periodos = [
            '_2024_3', '_2024_4', '_2025_1', '_2025_2', '_2025_3', '_2025_4',
            '_2026_1', '_2026_2', '_2026_3', '_2026_4', '_2027_1', '_2027_2',
            '_2027_3', '_2027_4'
        ];

        $campos = ['ICLD', 'ICDE', 'SGPE', 'SGPS', 'SGPAPSB', 'RPED', 'SGR', 'CR', 'G', 'CO', 'OR'];

        foreach ($ip->indproducto as $pro) {
            $programado_trimestres = [];
            $avance_total_anual = [];
            $programado_total_anual = [];
            $resumen_periodo = [];

            // Calcular lo programado por trimestre
            foreach ($periodos as $p) {
                [$anio, $trim] = explode('_', trim($p, '_'));

                $total_programado = 0;
                foreach ($campos as $campo) {
                    $valor = str_replace(',', '.', $pro->{$campo . $p});
                    $total_programado += (float) $valor;
                }

                $programado_trimestres[$p] = [
                    'anio' => $anio,
                    'trimestre' => $trim,
                    'total_programado' => $total_programado,
                ];

                if (!isset($programado_total_anual[$anio])) {
                    $programado_total_anual[$anio] = 0;
                }
                $programado_total_anual[$anio] += $total_programado;
            }

            $nuevos_avances = [];

            foreach ($programado_trimestres as $p => $info) {
                $anio = $info['anio'];
                $trim = $info['trimestre'];
                $total_programado = $info['total_programado'];

                $periodo_key = $anio . '_' . $trim;

                $avance = $pro->avancefin->firstWhere(function ($a) use ($anio, $trim) {
                    return $a->anio_af == $anio && $a->trimestre_af == $trim;
                });

                if ($avance) {
                    $total_avance = 0;
                    foreach ($campos as $campo) {
                        $avance->$campo = str_replace(',', '.', $avance->$campo);
                        $total_avance += (float) $avance->$campo;
                    }
                    $avance->total_Avance = $total_avance;
                } else {
                    $avance = new \stdClass();
                    $avance->anio_af = $anio;
                    $avance->trimestre_af = $trim;
                    $avance->id_pf = $pro->id;
                    foreach ($campos as $campo) {
                        $avance->$campo = 0;
                    }
                    $avance->total_Avance = 0;
                }

                $avance->total_Programado = $total_programado;

                // Calcular desempeño del periodo
                if ($total_programado == 0) {
                    $resumen_periodo[$periodo_key] = [
                        'anio' => $anio,
                        'trimestre' => $trim,
                        'total_programado' => 'No programado',
                        'total_avance' => 'No programado',
                        'porcentaje' => 'No programado',
                        'desempenio' => 'No programado',
                    ];
                    continue; // Saltamos cálculos si no fue programado
                }

                $porcentaje = ($avance->total_Avance / $total_programado) * 100;
                $avance->porcentaje_periodo = number_format($porcentaje, 2, '.', '');

                if ($porcentaje < 40) $avance->desempenio_periodo = "Crítico";
                elseif ($porcentaje <= 60) $avance->desempenio_periodo = "Bajo";
                elseif ($porcentaje <= 70) $avance->desempenio_periodo = "Medio";
                elseif ($porcentaje <= 80) $avance->desempenio_periodo = "Satisfactorio";
                elseif ($porcentaje <= 100) $avance->desempenio_periodo = "Sobresaliente";
                else $avance->desempenio_periodo = "Sobre Ejecutado";

                // Acumulado por año
                if (!isset($avance_total_anual[$anio])) {
                    $avance_total_anual[$anio] = 0;
                }
                $avance_total_anual[$anio] += $avance->total_Avance;

                // Guardar en resumen_periodo
                $resumen_periodo[$periodo_key] = [
                    'anio' => $anio,
                    'trimestre' => $trim,
                    'total_programado' => $total_programado,
                    'total_avance' => $avance->total_Avance,
                    'porcentaje' => number_format($porcentaje, 2, '.', ''),
                    'desempenio' => $avance->desempenio_periodo,
                ];

                $nuevos_avances[] = $avance;
            }

            $pro->avancefin = collect($nuevos_avances);

            // Crear resumen anual
            $resumen_anual = [];

            foreach ($programado_total_anual as $anio => $total_prog) {
                $total_av = $avance_total_anual[$anio] ?? 0;
                $porcentaje_anio = ($total_prog == 0) ? 0 : ($total_av / $total_prog) * 100;
                $desempenio = 'No Programado';

                if ($total_prog > 0) {
                    if ($porcentaje_anio < 40) $desempenio = "Crítico";
                    elseif ($porcentaje_anio <= 60) $desempenio = "Bajo";
                    elseif ($porcentaje_anio <= 70) $desempenio = "Medio";
                    elseif ($porcentaje_anio <= 80) $desempenio = "Satisfactorio";
                    elseif ($porcentaje_anio <= 100) $desempenio = "Sobresaliente";
                    else $desempenio = "Sobre Ejecutado";
                }

                $resumen_anual[$anio] = [
                    'anio' => $anio,
                    'total_programado' => $total_prog,
                    'total_avance' => $total_av,
                    'porcentaje' => number_format($porcentaje_anio, 2, '.', ''),
                    'desempenio' => $desempenio,
                ];
            }

            $pro->resumen_anual = $resumen_anual;
            $pro->resumen_periodo = $resumen_periodo;
        }

        return response()->json($ip);
    }

    function generarSumaCamposProgramados($anio, $trim) {
        $campos_base = ['ICLD', 'ICDE', 'SGPE', 'SGPS', 'SGPAPSB', 'RPED', 'SGR', 'CR', 'G', 'CO', 'OR'];
        $campos = [];

        if ($anio == 0 && $trim == 0) {
            for ($a = 2024; $a <= 2027; $a++) {
                $trimestres = ($a == 2024) ? [3, 4] : [1, 2, 3, 4];
                foreach ($trimestres as $t) {
                    foreach ($campos_base as $campo) {
                        $campos[] = "CAST(REPLACE(programar_financieros.{$campo}_{$a}_{$t}, ',', '.') AS DECIMAL(10,2))";
                    }
                }
            }
        } elseif ($anio == 0 && $trim != 0) {
            // Todos los años pero solo el trimestre indicado
            for ($a = 2024; $a <= 2027; $a++) {
                if ($a == 2024 && !in_array($trim, [3, 4])) {
                    continue; // Evita trimestres inválidos para 2024
                }
                foreach ($campos_base as $campo) {
                    $campos[] = "CAST(REPLACE(programar_financieros.{$campo}_{$a}_{$trim}, ',', '.') AS DECIMAL(10,2))";
                }
            }
        } elseif ($anio != 0 && $trim == 0) {
            $trimestres = ($anio == 2024) ? [3, 4] : [1, 2, 3, 4];
            foreach ($trimestres as $t) {
                foreach ($campos_base as $campo) {
                    $campos[] = "CAST(REPLACE(programar_financieros.{$campo}_{$anio}_{$t}, ',', '.') AS DECIMAL(10,2))";
                }
            }
        } elseif ($anio != 0 && $trim != 0) {
            foreach ($campos_base as $campo) {
                $campos[] = "CAST(REPLACE(programar_financieros.{$campo}_{$anio}_{$trim}, ',', '.') AS DECIMAL(10,2))";
            }
        }
        return implode(' + ', $campos);
    }

    public function verfinanciero_anio($id)
    {
        $valor = array_map('trim', explode('_', $id));
        $anio = $valor[0];
        $trim = $valor[1];
        $id_ip = $valor[2];
        $rez = $valor[3];

        // Lista de campos base
        $campos = ['ICLD', 'ICDE', 'SGPE', 'SGPS', 'SGPAPSB', 'RPED', 'SGR', 'CR', 'G', 'CO', 'OR'];

        // Obtener todos los registros de avance
        $registros = DB::table('avance_financieros')
            ->leftJoin('programar_financieros', 'programar_financieros.id', '=', 'avance_financieros.id_pf')
            ->select(
                'avance_financieros.id',
                'avance_financieros.anio_af',
                'avance_financieros.trimestre_af',
                'avance_financieros.estado_af',
                DB::raw('
                    ROUND((
                        CAST(REPLACE(ICLD, ",", ".") AS DECIMAL(18,2)) +
                        CAST(REPLACE(ICDE, ",", ".") AS DECIMAL(18,2)) +
                        CAST(REPLACE(SGPE, ",", ".") AS DECIMAL(18,2)) +
                        CAST(REPLACE(SGPS, ",", ".") AS DECIMAL(18,2)) +
                        CAST(REPLACE(SGPAPSB, ",", ".") AS DECIMAL(18,2)) +
                        CAST(REPLACE(RPED, ",", ".") AS DECIMAL(18,2)) +
                        CAST(REPLACE(SGR, ",", ".") AS DECIMAL(18,2)) +
                        CAST(REPLACE(CR, ",", ".") AS DECIMAL(18,2)) +
                        CAST(REPLACE(G, ",", ".") AS DECIMAL(18,2)) +
                        CAST(REPLACE(CO, ",", ".") AS DECIMAL(18,2)) +
                        CAST(REPLACE(`OR`, ",", ".") AS DECIMAL(18,2))
                    ), 2) AS total_avance
                ')
            )
            ->when($id_ip != 0, function($q) use ($id_ip) {
                $q->where('programar_financieros.id_ip', $id_ip);
            })
            ->when($anio != 0, function($q) use ($anio) {
                $q->where('avance_financieros.anio_af', $anio);
            })
            ->when($trim != 0, function($q) use ($trim) {
                $q->where('avance_financieros.trimestre_af', $trim);
            })
            //->whereNotNull('avance_financieros.trimestre_af')
            ->orderBy('avance_financieros.anio_af')
            ->orderBy('avance_financieros.trimestre_af')
            ->get();

        // Para cada registro calcular el % periodo y % año
        foreach ($registros as $reg) {
            $anio_af = $reg->anio_af;
            $trim_af = $reg->trimestre_af;

            // Total avance ya viene en el campo
            $total_avance = $reg->total_avance;

            // === Calcular total programado del periodo ===
            $total_programado_periodo = 0;
            foreach ($campos as $campo) {
                $col = "{$campo}_{$anio_af}_{$trim_af}";
                $valor = DB::table('programar_financieros')
                    ->whereNotNull($col)
                    ->where('programar_financieros.id_ip', $id_ip)
                    ->select(DB::raw("SUM(CAST(REPLACE($col, ',', '.') AS DECIMAL(18,2))) as total"))
                    ->value('total');
                $total_programado_periodo += (float) ($valor ?? 0);
            }

            $reg->porcentaje_periodo = ($total_programado_periodo > 0)
                ? round(($total_avance / $total_programado_periodo) * 100, 2)
                : 0;

            // === Calcular total programado del año ===
            $trims = ($anio_af == 2024) ? [3, 4] : [1, 2, 3, 4];
            $total_programado_anio = 0;
            foreach ($trims as $t) {
                foreach ($campos as $campo) {
                    $col = "{$campo}_{$anio_af}_{$t}";
                    $valor = DB::table('programar_financieros')
                        ->whereNotNull($col)
                        ->where('programar_financieros.id_ip', $id_ip)
                        ->select(DB::raw("SUM(CAST(REPLACE($col, ',', '.') AS DECIMAL(18,2))) as total"))
                        ->value('total');
                    $total_programado_anio += (float) ($valor ?? 0);
                }
            }

            $reg->porcentaje_anio = ($total_programado_anio > 0)
                ? round(($total_avance / $total_programado_anio) * 100, 2)
                : 0;
        }

        $total = count($registros);
        $avances = 0;

        foreach ($registros as $r) {
            if ($r->total_avance > 0) {
                $avances++;
            }
        }
        $faltan = $total - $avances;
        return response()->json([$registros, $total, $faltan]);
    }


    public function editaravafin($id) {
        $avafin = AvanceFinanciero::find($id);
        return response()->json($avafin);
    }

    public function actualizaravafin(Request $request) {
        $request->validate([    
            'estado' => 'required',
            'ICLD' => 'required',
            'ICDE' => 'required',
            'SGPE' => 'required',
            'SGPS' => 'required',
            'SGPAPSB' => 'required',
            'RPED' => 'required',
            'SGR' => 'required',
            'CR' => 'required',
            'G' => 'required',
            'CO' => 'required',
            'OR' => 'required',
            'm_0_5' => 'required',
            'm_6_12' => 'required',
            'm_13_17' => 'required',
            'm_18_29' => 'required',
            'm_30_59' => 'required',
            'm_60' => 'required',
            'h_0_5' => 'required',
            'h_6_12' => 'required',
            'h_13_17' => 'required',
            'h_18_29' => 'required',
            'h_30_59' => 'required',
            'h_60' => 'required',
            'beneficio' => 'required',
            'cantidad' => 'required',
            'id_ip' => 'required|exists:indicador_productos,id',
            'id_mun' => 'required|exists:municipios,id',
            'id_gp' => 'required|exists:grupo_poblacions,id'
        ]);
        $avafin = AvanceFinanciero::find($request->input('id'));
        $avafin->ICLD = $request->input('ICLD');
        $avafin->ICDE = $request->input('ICDE');
        $avafin->SGPE = $request->input('SGPE');
        $avafin->SGPS = $request->input('SGPS');
        $avafin->SGPAPSB = $request->input('SGPAPSB');
        $avafin->RPED = $request->input('RPED');
        $avafin->SGR = $request->input('SGR');
        $avafin->CR = $request->input('CR');
        $avafin->G = $request->input('G');
        $avafin->CO = $request->input('CO');
        $avafin->OR = $request->input('OR');
        $avafin->m_0_5 = $request->input('m_0_5');
        $avafin->m_6_12 = $request->input('m_6_12');
        $avafin->m_13_17 = $request->input('m_13_17');
        $avafin->m_18_29 = $request->input('m_18_29');
        $avafin->m_30_59 = $request->input('m_30_59');
        $avafin->m_60 = $request->input('m_60');
        $avafin->h_0_5 = $request->input('h_0_5');
        $avafin->h_6_12 = $request->input('h_6_12');
        $avafin->h_13_17 = $request->input('h_13_17');
        $avafin->h_18_29 = $request->input('h_18_29');
        $avafin->h_30_59 = $request->input('h_30_59');
        $avafin->h_60 = $request->input('h_60');
        $avafin->beneficio = $request->input('beneficio');
        $avafin->cantidad = $request->input('cantidad');
        $avafin->id_ip = $request->input('id_ip');
        $avafin->id_mun = $request->input('id_mun');
        $avafin->id_gp = $request->input('id_gp');
        $avafin->estado_af = $request->input('estado');;
        $avafin->save();
        return redirect()->route('listaravafins')->with('success', 'Avance Financiero actualizado correctamente');
    }

    public function veravances_anio($id) {
        $valor = array_map('trim', explode('_', $id));
        $anio = $valor[0];
        $trim = $valor[1];
        $ind = $valor[2];
        if ($anio != 0 and $trim != 0) {
            $datos = AvanceFinanciero::join('indicador_productos', 'indicador_productos.id', '=', 'avance_financieros.id_ip')
                                        ->with('municipios')
                                        ->where('actividads.id_ip', $ind)
                                        ->where('actividads.anio_a', $anio)
                                        ->where('actividads.trimestre_a', $trim)
                                        ->get();
        }
        else {
            if ($anio != 0 and $trim == 0) {
                $datos = AvanceFinanciero::join('indicador_productos', 'indicador_productos.id', '=', 'avance_financieros.id_ip')
                                        ->with('municipios')
                                        ->where('actividads.id_ip', $ind)
                                        ->where('actividads.anio_a', $anio)
                                        ->get();
            }
            else {
                if ($anio == 0 and $trim != 0) {
                    $datos = AvanceFinanciero::join('indicador_productos', 'indicador_productos.id', '=', 'avance_financieros.id_ip')
                                        ->with('municipios')
                                        ->where('actividads.id_ip', $ind)
                                        ->where('actividads.trimestre_a', $trim)
                                        ->get();
                }
                else {
                    $datos = AvanceFinanciero::join('indicador_productos', 'indicador_productos.id', '=', 'avance_financieros.id_ip')
                                        ->with('municipios')
                                        ->where('actividads.id_ip', $ind)
                                        ->get();
                }
            }
        }
        return response()->json($datos);
    }

    public function eliminaravafin($id) {
        $avafin = AvanceFinanciero::find($id);
        if ($avafin) {
            $avafin->estado_af = "Inactivo";
            $avafin->save();
            return response()->json(['success' => true, 'message' => 'Avance Financiero Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Avance Financiera no encontrado']);
    }

    public function csvavafins(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);
        //return response()->json($request);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['id_pf', 'anio_af', 'trimestre_af', 'bpin_af', 'ICLD', 'ICDE', 'SGPE', 
                                'SGPS', 'SGPAPSB', 'RPED', 'SGR', 'CR', 'G', 'CO', 'OR', 'logro_af',
                                'estado_af'];
        $encabezadosEsperados = array_map('strtolower', $encabezadosEsperados);

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
        $importar = new csvImportAvaFin;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todos los Avances Financieros ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevos Avances Financieros importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
