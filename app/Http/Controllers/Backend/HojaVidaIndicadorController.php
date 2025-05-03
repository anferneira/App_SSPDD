<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IndicadorProducto;
use App\Models\Estrategia;
use App\Models\Dimension;
use App\Models\Apuesta;
use App\Models\Dependencia;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HojaVidaIndicadorController extends Controller
{
    //
    public function cargarlistas() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $estrategias = Estrategia::orderBy('codigo_e')->get();
            $dimensiones = Dimension::orderBy('codigo_d')->get();
            $apuestas = Apuesta::orderBy('codigo_a')->get();
            $dependencias = Dependencia::orderBy('nombre_d')
                                    ->where('id', '!=', 1)
                                    ->where('id', '!=', 31)
                                    ->where('id', '!=', 32)->get();
            $ips = IndicadorProducto::select('codigo_ip', 'descripcion_ip')
                                    ->distinct()->orderBy('codigo_ip')->get();
            return view('admin/hvi.index1', compact('usuario', 'nombre', 'rol', 'dependencia', 'estrategias', 'dimensiones', 'apuestas', 'dependencias', 'ips'));
        }
        return Redirect::route('login');
    }

    public function cargarhvi() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $ips = IndicadorProducto::selectRaw('MIN(id) as id, codigo_ip')
                                        ->groupBy('codigo_ip')
                                        ->get();
            return view('admin/hvi.index2', compact('usuario', 'nombre', 'rol', 'dependencia', 'ips'));
        }
        return Redirect::route('login');
    }

    public function verindicador($id) {
        $datos = IndicadorProducto::with('mga', 'apuesta.dimension.estrategia_dimension', 'dependencia', 'orientar', 'medida')->find($id);
        return response()->json($datos);
    }

    public function veractividades($id) {
        $datos = Actividad::join('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
                                        ->select('actividads.codigo_a', 'actividads.nombre_a', 'actividads.aporte_a', 'actividads.meta_a')
                                        ->where('actividads.id_ip', $id)
                                        ->get();
        return response()->json($datos);
    }

    public function veractividades_anio($id) {
        $valor = array_map('trim', explode('_', $id));
        $anio = $valor[0];
        $trim = $valor[1];
        $ind = $valor[2];
        if ($anio != 0 and $trim != 0) {
            $datos = Actividad::join('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
                                        ->select('actividads.codigo_a', 'actividads.nombre_a', 'actividads.aporte_a')
                                        ->where('actividads.id_ip', $ind)
                                        ->where('actividads.anio_a', $anio)
                                        ->where('actividads.trimestre_a', $trim)
                                        ->get();
        }
        else {
            if ($anio != 0 and $trim == 0) {
                $datos = Actividad::join('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
                                        ->select('actividads.codigo_a', 'actividads.nombre_a', 'actividads.aporte_a')
                                        ->where('actividads.id_ip', $ind)
                                        ->where('actividads.anio_a', $anio)
                                        ->get();
            }
            else {
                if ($anio == 0 and $trim != 0) {
                    $datos = Actividad::join('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
                                        ->select('actividads.codigo_a', 'actividads.nombre_a', 'actividads.aporte_a')
                                        ->where('actividads.id_ip', $ind)
                                        ->where('actividads.trimestre_a', $trim)
                                        ->get();
                }
                else {
                    $datos = Actividad::join('indicador_productos', 'indicador_productos.id', '=', 'actividads.id_ip')
                                        ->select('actividads.codigo_a', 'actividads.nombre_a', 'actividads.aporte_a')
                                        ->where('actividads.id_ip', $ind)
                                        ->get();
                }
            }
        }
        return response()->json($datos);
    }

    public function porest($id) {
        $datos = Estrategia::join('dimensions', 'estrategias.id', '=', 'dimensions.id_e')
                ->join('apuestas', 'dimensions.id', '=', 'apuestas.id_d')
                ->join('indicador_productos', 'apuestas.id', '=', 'indicador_productos.id_a')
                ->select('indicador_productos.descripcion_ip as descripcion', 'indicador_productos.codigo_ip as codigo')
                ->where('estrategias.id', $id)
                ->distinct()
                ->get();
        return response()->json($datos);
    }

    public function pordim($id) {
        $datos = Dimension::join('apuestas', 'dimensions.id', '=', 'apuestas.id_d')
                ->join('indicador_productos', 'apuestas.id', '=', 'indicador_productos.id_a')
                ->select('indicador_productos.codigo_ip as codigo', 'indicador_productos.descripcion_ip as descripcion')
                ->where('dimensions.id', $id)
                ->distinct()
                ->get();
        return response()->json($datos);
    }

    public function porapu($id) {
        $datos = Apuesta::join('indicador_productos', 'apuestas.id', '=', 'indicador_productos.id_a')
                ->select('indicador_productos.codigo_ip as codigo', 'indicador_productos.descripcion_ip as descripcion')
                ->where('apuestas.id', $id)
                ->distinct()
                ->get();
        return response()->json($datos);
    }

    public function pordep($id) {
        $datos = IndicadorProducto::join('dependencias', 'dependencias.id', '=', 'indicador_productos.id_d')
                            ->select('indicador_productos.codigo_ip as codigo', 'indicador_productos.descripcion_ip as descripcion')
                            ->where('dependencias.id', $id)
                            ->distinct()
                            ->get();
        return response()->json($datos);
    }

    public function actest1($id) {
        $datos = Estrategia::join('dimensions', 'estrategias.id', '=', 'dimensions.id_e')
                                ->where('dimensions.id', $id)
                                ->distinct()
                                ->get();
        return response()->json($datos);
    }

    public function actest2($id) {
        $datos = Estrategia::join('dimensions', 'estrategias.id', '=', 'dimensions.id_e')
                                ->join('apuestas', 'dimensions.id', '=', 'apuestas.id_d')
                                ->select('estrategias.id', 'estrategias.codigo_e', 'estrategias.nombre_e')
                                ->where('apuestas.id', $id)
                                ->distinct()
                                ->get();
        return response()->json($datos);
    }

    public function actest3($id) {
        $datos = Estrategia::join('dependencia_estrategias', 'estrategias.id', '=', 'dependencia_estrategias.id_e')
                                ->join('dependencias', 'dependencias.id', '=', 'dependencia_estrategias.id_d')
                                ->select('estrategias.id', 'estrategias.codigo_e', 'estrategias.nombre_e')
                                ->where('dependencias.id', $id)
                                ->distinct()
                                ->get();
        return response()->json($datos);
    }

    public function actdim1($id) {
        $datos = Dimension::where('id_e', $id)->get();
        return response()->json($datos);
    }

    public function actdim2($id) {
        $datos = Dimension::join('apuestas', 'dimensions.id', '=', 'apuestas.id_d')
                                ->where('apuestas.id', $id)
                                ->select('dimensions.id', 'dimensions.codigo_d', 'dimensions.nombre_d')
                                ->distinct()
                                ->get();
        return response()->json($datos);
    }

    public function actdim3($id) {
        $datos = Dimension::join('dependencia_dimensions', 'dimensions.id', '=', 'dependencia_dimensions.id_dim')
                                ->join('dependencias', 'dependencias.id', '=', 'dependencia_dimensions.id_dep')
                                ->select('dimensions.id', 'dimensions.codigo_d', 'dimensions.nombre_d')
                                ->where('dependencias.id', $id)
                                ->distinct()
                                ->get();
        return response()->json($datos);
    }

    public function actapu1($id) {
        $datos = Apuesta::join('dimensions', 'dimensions.id', '=', 'apuestas.id_d')
                        ->join('estrategias', 'estrategias.id', '=', 'dimensions.id_e')
                        ->where('estrategias.id', $id)
                        ->distinct()
                        ->get();
        return response()->json($datos);
    }

    public function actapu2($id) {
        $datos = Apuesta::join('dimensions', 'dimensions.id', '=', 'apuestas.id_d')
                        ->select('apuestas.id', 'apuestas.codigo_a', 'apuestas.nombre_a')
                        ->where('dimensions.id', $id)
                        ->distinct()
                        ->get();
        return response()->json($datos);
    }

    public function actapu3($id) {
        $datos = Apuesta::join('dependencia_apuestas', 'apuestas.id', '=', 'dependencia_apuestas.id_apu')
                        ->join('dependencias', 'dependencias.id', '=', 'dependencia_apuestas.id_dep')
                        ->select('apuestas.id', 'apuestas.codigo_a', 'apuestas.nombre_a')
                        ->where('dependencias.id', $id)
                        ->distinct()
                        ->get();
        return response()->json($datos);
    }

    public function actdp1($id) {
        $datos = Dependencia::join('dependencia_estrategias', 'dependencias.id', '=', 'dependencia_estrategias.id_d')
                        ->join('estrategias', 'estrategias.id', '=', 'dependencia_estrategias.id_e')
                        ->where('dependencia_estrategias.id_e', $id)
                        ->distinct()
                        ->get();
        return response()->json($datos);
    }

    public function actdp2($id) {
        $datos = Dependencia::join('dependencia_dimensions', 'dependencias.id', '=', 'dependencia_dimensions.id_dep')
                        ->join('dimensions', 'dimensions.id', '=', 'dependencia_dimensions.id_dim')
                        ->select('dependencias.id', 'dependencias.nombre_d')
                        ->where('dependencia_dimensions.id_dim', $id)
                        ->distinct()
                        ->get();
        return response()->json($datos);
    }

    public function actdp3($id) {
        $datos = Dependencia::join('dependencia_apuestas', 'dependencias.id', '=', 'dependencia_apuestas.id_dep')
                        ->join('apuestas', 'apuestas.id', '=', 'dependencia_apuestas.id_apu')
                        ->select('dependencias.id', 'dependencias.nombre_d')
                        ->where('apuestas.id', $id)
                        ->distinct()
                        ->get();
        return response()->json($datos);
    }

    public function borrarfiltros($id) {
        if ($id == 1) {
            $datos = Estrategia::orderBy('codigo_e')->get();
        }
        else {
            if ($id == 2) {
                $datos = Dimension::orderBy('codigo_d')->get();
            }
            else {
                if ($id == 3) {
                    $datos = Apuesta::orderBy('codigo_a')->get();
                }
                else {
                    if ($id == 4) {
                        $datos = Dependencia::orderBy('nombre_d')
                                            ->where('id', '!=', 1)
                                            ->where('id', '!=', 31)
                                            ->where('id', '!=', 32)->get();
                    }
                }
            }
        }
        return response()->json($datos);
    }
}
