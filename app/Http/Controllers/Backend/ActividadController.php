<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Dependencia;
use App\Models\IndicadorProducto;
use App\Imports\csvImportActividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ActividadController extends Controller
{
    //
    public function listaracts() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $dependencias = $dependencias = Dependencia::orderBy('nombre_d')
                                ->where('id', '!=', 1)
                                ->where('id', '!=', 31)
                                ->where('id', '!=', 32)->get();
            /*$ips = IndicadorProducto::orderBy('codigo_ip')->get()->map(function ($ip) {
                $ip->codigo_ip = str_replace(',', '.', $ip->codigo_ip);
                return $ip;
            });*/
            /*$ips = IndicadorProducto::selectRaw("REPLACE(codigo_ip, ',', '.') as codigo_ip, id")
                                    ->orderBy('codigo_ip')
                                    ->get();*/
            $ips = IndicadorProducto::all()->map(function ($ip) {
                $ip->codigo_ip = str_replace(',', '.', $ip->codigo_ip);
                return $ip;
            })->sortBy('id');
            return view('admin/actividad.index1', compact('usuario', 'nombre', 'rol', 'dependencia', 'ips', 'dependencias'));
        }
        return Redirect::route('login');
    }

    public function ver_ind($id) {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_dependencia;
            $acts = Actividad::where('id_ip', $id)->get();
             // Ordenar las actividades según el código 'codigo_a'
            $acts = $acts->sortBy(function ($actividad) {
                return $this->ordenarCodigo($actividad->codigo_a);
            });
            $ip = IndicadorProducto::find($id);
            $ips = IndicadorProducto::all();
            $ips = $ips->sortBy(function ($i) {
                return $this->ordenarCodigo($i->codigo_ip);
            });
            return view('admin/actividad.index2', compact('usuario', 'nombre', 'rol', 'dependencia', 'acts', 'ip', 'ips'));
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

    public function dep_ind($id) {
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

    public function veractividades_anio2($id) {
        $valor = array_map('trim', explode('_', $id));
        $anio = $valor[0];
        $trim = $valor[1];
        $ind = $valor[2];
        if ($anio != 0 and $trim != 0) {
            $datos = Actividad::join('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
                                        ->select('actividads.id', 'actividads.codigo_a', 'actividads.nombre_a', 'actividads.estado_a')
                                        ->where('actividads.id_ip', $ind)
                                        ->where('actividads.anio_a', $anio)
                                        ->where('actividads.trimestre_a', $trim)
                                        ->get();
        }
        else {
            if ($anio != 0 and $trim == 0) {
                $datos = Actividad::join('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
                                        ->select('actividads.id', 'actividads.codigo_a', 'actividads.nombre_a', 'actividads.estado_a')
                                        ->where('actividads.id_ip', $ind)
                                        ->where('actividads.anio_a', $anio)
                                        ->get();
            }
            else {
                if ($anio == 0 and $trim != 0) {
                    $datos = Actividad::join('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
                                        ->select('actividads.id', 'actividads.codigo_a', 'actividads.nombre_a', 'actividads.estado_a')
                                        ->where('actividads.id_ip', $ind)
                                        ->where('actividads.trimestre_a', $trim)
                                        ->get();
                }
                else {
                    $datos = Actividad::join('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
                                        ->select('actividads.id', 'actividads.codigo_a', 'actividads.nombre_a', 'actividads.estado_a')
                                        ->where('actividads.id_ip', $ind)
                                        ->get();
                }
            }
        }
        return response()->json($datos);
    }

    public function guardaract(Request $request) {
        $act = Actividad::where('codigo_a', $request->codigo)
                                ->where('id_ip', $request->id_ip)
                                ->where('anio_a', $request->anio)
                                ->where('trimestre_a', $request->trimestre)
                                ->get();
        if ($act->count() > 0)
            return redirect()->route('listaracts')->with('error', 'La Actividad ya existe en el sistema.');
        $request->validate([
            'nombre' => 'required',
            'anio' => 'required',
            'trimestre' => 'required',
            'meta' => 'required',
            'aporte' => 'required',
            'id_ip' => 'required|exists:indicador_productos,id'
        ]);
        $act = new Actividad();
        $id_dep = IndicadorProducto::find($request->input('id_ip'));
        $act->id_dep = $id_dep->id_d;
        $act->codigo_a = $request->input('codigo');
        $act->nombre_a = $request->input('nombre');
        $act->id_ip = $request->input('id_ip');
        $act->anio_a = $request->input('anio');
        $act->trimestre_a = $request->input('trimestre');
        $act->meta_a = $request->input('meta');
        $act->aporte_a = $request->input('aporte');
        $act->estado_a = 'Activo';
        $act->save();
        return redirect()->route('listaracts')->with('success', 'Actividad creada correctamente');
    }

    public function veract($id) {
        $act = Actividad::with('producto')->find($id);
        return response()->json($act);
    }

    public function editaract($id) {
        $act = Actividad::find($id);
        return response()->json($act);
    }

    public function actualizaract(Request $request) {
        
        $request->validate([
            'nombre' => 'required',
            'anio' => 'required',
            'trimestre' => 'required',
            'meta' => 'required',
            'aporte' => 'required',
            'id_ip' => 'required|exists:indicador_productos,id',
            'estado' => 'required',
        ]);
        $act = Actividad::find($request->input('id'));
        $act->codigo_a = $request->input('codigo');
        $act->nombre_a = $request->input('nombre');
        $act->id_ip = $request->input('id_ip');
        $act->anio_a = $request->input('anio');
        $act->trimestre_a = $request->input('trimestre');
        $act->meta_a = $request->input('meta');
        $act->aporte_a = $request->input('aporte');
        $id_dep = IndicadorProducto::find($request->input('id_ip'));
        $act->id_dep = $id_dep->id_d;
        $act->estado_a = $request->input('estado');
        $act->save();
        return redirect()->route('listaracts')->with('success', 'Actividad actualizada correctamente');
    }

    public function eliminaract($id) {
        $act = Actividad::find($id);
        if ($act) {
            $act->estado_a = "Inactivo";
            $act->save();
            return response()->json(['success' => true, 'message' => 'Actividad Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Actividad no encontrada']);
    }

    public function csvacts(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_a', 'nombre_a', 'id_ip', 'id_dep', 'anio_a', 'trimestre_a', 'meta_a', 'aporte_a', 'estado_a'];

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
        $importar = new csvImportActividad;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Actividades ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Actividades importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}

