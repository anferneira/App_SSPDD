<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AvanceEstrategico;
use App\Models\IndicadorProducto;
use App\Models\ProgramarEstrategico;
use App\Models\Dependencia;
use App\Imports\csvImportAvaEst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class AvanceEstrategicoController extends Controller
{
    //
    public function listaravaests() {
        /*if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $ips = IndicadorProducto::all();
            $avances = AvanceEstrategico::orderBy('id_ip')->get();
            $dependencias = Dependencia::where('id', '!=' , 1)
                                        ->where('id', '!=', 31)
                                        ->where('id', '!=', 32)
                                        ->orderBy('nombre_d')->get();
            return view('admin/avaest.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'ips', 'avances', 'dependencias'));
        }
        return Redirect::route('login');*/
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $dependencias = $dependencias = Dependencia::orderBy('nombre_d')
                                ->where('id', '!=', 1)
                                ->where('id', '!=', 31)
                                ->where('id', '!=', 32)->get();
            //$ips = IndicadorProducto::all();
            $ips = IndicadorProducto::all()->map(function ($ip) {
                $ip->codigo_ip = str_replace(',', '.', $ip->codigo_ip);
                return $ip;
            });
            return view('admin/avaest.index1', compact('usuario', 'nombre', 'rol', 'dependencia', 'ips', 'dependencias'));
        }
        return Redirect::route('login');
    }

    public function dep_indi1($id) {
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

    public function guardaravaest(Request $request) {
        $avaest = AvanceEstrategico::where('id_ip', $request->id_ip)
                                    ->where('anio_ae', $request->anio)
                                    ->where('trimestre_ae', $request->trimestre)->get();
        if ($avaest->count() > 0)
            return redirect()->route('listaravaests')->with('error', 'El Avance Estratégico ya existe en el sistema.');
        $request->validate([
            'avance' => 'required',
            'anio' => 'required',
            'trimestre' => 'required',
            'id_ip' => 'required|exists:indicador_productos,id'
        ]);
        $avaest = new AvanceEstrategico();
        $avaest->avance_ae = $request->input('avance');
        $avaest->anio_ae = $request->input('anio');
        $avaest->trimestre_ae = $request->input('trimestre');
        $avaest->id_ip = $request->input('id_ip');
        $avaest->estado_ae = 'Activo';
        $avaest->save();
        return redirect()->route('listaravaests')->with('success', 'Avance Estratégico creado correctamente');
    }

    public function ver_ind2($id) {
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
            /*$acts = Actividad::leftJoin('avance_actividads', 'actividads.id', '=', 'avance_actividads.id_a')
                            ->select('actividads.*', DB::raw('IF(COUNT(avance_actividads.id) > 0, 1, 0) as avance'))
                            ->where('actividads.id_ip', $id)
                            ->groupBy('actividads.id'); // Agregado para evitar errores con COUNT()
            // Ordenar las actividades según el código 'codigo_a'
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
            //$acts = $acts->orderBy('actividads.codigo_a')->get(); // OPTIMIZADO: Ordenar en la consulta

            // Contar los avances
            //$faltan = $acts->where('avance', 0)->count();
            //$total = $acts->count();
            //return response()->json($acts);
            //$ip = IndicadorProducto::find($id);
            $ests = AvanceEstrategico::leftJoin('indicador_productos.id', '=', 'avance_estrategicos.id_ip')
                                    ->join('actividads.id_ip', '=', 'indicador_productos.id')
                                    ->join('avance_actividads.id_a', '=', 'actividads.id')
                                    ->select('a')
                                    ->where('indicador_productos.id_ip', $id)
                                    ->get();
            dd($ests);
            return view('admin/avaact.index2', compact('usuario', 'nombre', 'rol', 'dependencia', 'acts', 'ip', 'dependencias', 'faltan', 'total'));
        }
        return Redirect::route('login');
    }

    public function veravaest($id) {
        $avaest = AvanceEstrategico::with('indproducto.dependencia')->find($id);
        $programado = ProgramarEstrategico::selectRaw('p'.$avaest->anio_ae.'_'.$avaest->trimestre_ae.' as programado')
                                                    ->where('id_ip', $avaest->id_ip)
                                                    ->get();
        foreach ($programado as $p)
            $avaest->programado = $p->programado;
        $pe = ProgramarEstrategico::where('id_ip', $avaest->id_ip)->get();
        $sum = 0;
        $cont = 0;
        foreach ($pe as $p) {
            if ($avaest->anio_ae == 2024) {
                $sum = $sum + floatval(str_replace(',', '.', $p->p2024_3));
                $sum = $sum + floatval(str_replace(',', '.', $p->p2024_4));
            }
            else {
                if ($avaest->anio_ae == 2025) {
                    $sum = $sum + floatval(str_replace(',', '.', $p->p2025_1));
                    $sum = $sum + floatval(str_replace(',', '.', $p->p2025_2));
                    $sum = $sum + floatval(str_replace(',', '.', $p->p2025_3));
                    $sum = $sum + floatval(str_replace(',', '.', $p->p2025_4));
                }
                else {
                    if ($avaest->anio_ae == 2026) {
                        $sum = $sum + floatval(str_replace(',', '.', $p->p2026_1));
                        $sum = $sum + floatval(str_replace(',', '.', $p->p2026_2));
                        $sum = $sum + floatval(str_replace(',', '.', $p->p2026_3));
                        $sum = $sum + floatval(str_replace(',', '.', $p->p2026_4));
                    }
                    else {
                        $sum = $sum + floatval(str_replace(',', '.', $p->p2027_1));
                        $sum = $sum + floatval(str_replace(',', '.', $p->p2027_2));
                        $sum = $sum + floatval(str_replace(',', '.', $p->p2027_3));
                        $sum = $sum + floatval(str_replace(',', '.', $p->p2027_4));
                    }
                }
            }
            $cont++;
        }
        $avaest->programado_anio = $sum;
        $avaest->cantidad_anio = $cont;
        $pe = ProgramarEstrategico::all();
        $sum = 0;
        $cont = 0;
        foreach ($pe as $p) {
            $sum = $sum + floatval(str_replace(',', '.', $p->p2024_3));
            $sum = $sum + floatval(str_replace(',', '.', $p->p2024_4));
            $sum = $sum + floatval(str_replace(',', '.', $p->p2025_1));
            $sum = $sum + floatval(str_replace(',', '.', $p->p2025_2));
            $sum = $sum + floatval(str_replace(',', '.', $p->p2025_3));
            $sum = $sum + floatval(str_replace(',', '.', $p->p2025_4));
            $sum = $sum + floatval(str_replace(',', '.', $p->p2026_1));
            $sum = $sum + floatval(str_replace(',', '.', $p->p2026_2));
            $sum = $sum + floatval(str_replace(',', '.', $p->p2026_3));
            $sum = $sum + floatval(str_replace(',', '.', $p->p2026_4));
            $sum = $sum + floatval(str_replace(',', '.', $p->p2027_1));
            $sum = $sum + floatval(str_replace(',', '.', $p->p2027_2));
            $sum = $sum + floatval(str_replace(',', '.', $p->p2027_3));
            $sum = $sum + floatval(str_replace(',', '.', $p->p2027_4));
            $cont++;
        }
        $avaest->programado_cuatrenio = $sum;
        $avaest->cantidad_cuatrenio = $cont;
        return response()->json($avaest);
    }

    public function editaravaest($id) {
        $avaest = AvanceEstrategico::with('indproducto.dependencia')->find($id);
        $avaest->ips = IndicadorProducto::select('id', 'codigo_ip')
                                    ->where('id_d', $avaest->indproducto->dependencia->id)->get();
        $programado = ProgramarEstrategico::selectRaw('p'.$avaest->anio_ae.'_'.$avaest->trimestre_ae.' as programado')
                                                    ->where('id_ip', $avaest->id_ip)
                                                    ->get();
        foreach ($programado as $p)
            $avaest->programado = $p->programado;
        return response()->json($avaest);
    }

    public function actualizaravaest(Request $request) {
        //return response()->json($request);
        $request->validate([    
            'estado' => 'required',
            'avance' => 'required',
            'anio' => 'required',
            'trimestre' => 'required',
            'id_ip' => 'required|exists:indicador_productos,id'
        ]);
        //return response()->json($request);
        $avaest = AvanceEstrategico::find($request->input('id'));
        $avaest->avance_ae = $request->input('avance');
        $avaest->anio_ae = $request->input('anio');
        $avaest->trimestre_ae = $request->input('trimestre');
        $avaest->id_ip = $request->input('id_ip');
        $avaest->estado_ae = $request->input('estado');
        $avaest->save();
        return redirect()->route('listaravaests')->with('success', 'Avance Estratégico actualizado correctamente');
    }

    public function eliminaravaest($id) {
        $avaest = AvanceEstrategico::find($id);
        if ($avaest) {
            $avaest->estado_ae = "Inactivo";
            $avaest->save();
            return response()->json(['success' => true, 'message' => 'Avance Estratégico Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Avance Estratégico no encontrado']);
    }

    public function csvavaests(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['id_ip', 'avance_ae', 'anio_ae', 'trimestre_ae', 'estado_ae'];

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
        $importar = new csvImportAvaEst;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Programaciones Estratégicas ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Programaciones Estratégicas importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }

    public function ind_dep($id) {
        $ind = IndicadorProducto::join('dependencias', 'dependencias.id', '=', 'indicador_productos.id_d')
                                ->selectRaw('indicador_productos.id as id, indicador_productos.codigo_ip')
                                ->where('dependencias.id', $id)
                                ->get();
        return response()->json($ind);
    }

    public function rezago($id) {
        // Dividir el string por el carácter '_'
        $partes = explode('_', $id);
        // Asignar las partes a variables
        $id_ip = $partes[0]; // Primera parte (id del indicador)
        // $partes[1] Primera parte (valor del avance en el periodo)
        $periodo = $partes[2].'_'.$partes[3]; // Combinar tercera y cuarta parte (año_trimestre)
        $campo_programado = 'p'.$periodo;
        $pro = AvanceEstrategico::where('id_ip', $id_ip)
                                ->where('anio_ae', $partes[2])
                                ->where('trimestre_ae', $partes[3])->get();
        if ($pro->count() == 0) {
            $ava = IndicadorProducto::join('programar_estrategicos', 'indicador_productos.id', '=', 'programar_estrategicos.id_ip')
                                    ->select($campo_programado.' as valor_programado')
                                    ->where('programar_estrategicos.id_ip', $id_ip)
                                    ->get();
            return response()->json($ava);
        }
        else {
            if ($partes[4] == 1) {
                $ava = IndicadorProducto::join('programar_estrategicos', 'indicador_productos.id', '=', 'programar_estrategicos.id_ip')
                                    ->select($campo_programado.' as valor_programado')
                                    ->where('programar_estrategicos.id_ip', $id_ip)
                                    ->get();
                return response()->json($ava);
            }
            else
                return response()->json('El periodo ya fué programado');
        }
    }
}
