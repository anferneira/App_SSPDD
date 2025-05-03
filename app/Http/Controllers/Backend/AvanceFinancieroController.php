<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AvanceFinanciero;
use App\Models\IndicadorProducto;
use App\Models\Municipio;
use App\Models\GrupoPoblacional;
use App\Models\Dependencia;
use App\Imports\csvImportAvaFin;
use App\Models\GrupoPoblacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Facades\DB;

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
            ->leftJoin('avance_financieros AS af', 'af.id_ip', '=', 'ip.id')
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
            return view('admin/avafin.index1', compact('usuario', 'nombre', 'rol', 'dependencia', 'ips', 'dependencias'));
        }
        else {
            return Redirect::route('login');
        }
    }

    private function calcularNivelDesempeno($porcentaje)
    {
        if ($porcentaje <= 39) {
            return 'Crítico';
        } elseif ($porcentaje <= 59) {
            return 'Bajo';
        } elseif ($porcentaje <= 79) {
            return 'Medio';
        } elseif ($porcentaje <= 99) {
            return 'Satisfactorio';
        } elseif ($porcentaje <= 120) {
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
        $avafin = new AvanceFinanciero();
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
        $avafin->estado_af = 'Activo';
        $avafin->save();
        return redirect()->route('listaravafins')->with('success', 'Avance Financiero creado correctamente');
    }

    public function veravafin($id) {
        $avafin = AvanceFinanciero::with('indproducto1', 'municipios', 'poblacion')->find($id);
        return response()->json($avafin);
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
        $encabezadosEsperados = ['id_ip', 'anio_af', 'trimestre_af', 'ICLD', 'ICDE', 'SGPE', 
                                'SGPS', 'SGPAPSB', 'RPED', 'SGR', 'CR', 'G', 'CO', 'OR',
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
