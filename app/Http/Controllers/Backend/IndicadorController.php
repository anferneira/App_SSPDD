<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use App\Models\IndicadorMga;
use App\Models\Apuesta;
use App\Models\TipoIndicador;
use App\Models\Indicador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class IndicadorController extends Controller
{
    //
    public function listarindicadores() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre;
            $dependencia = $usuario->dependencia->nombre;
            $indicadores = Indicador::all();
            return view('admin/indicador.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'indicadores'));
        }
        return Redirect::route('login');
    }

    public function guardarindicador(Request $request) {
        $indicador = Indicador::where('codigo', $request->codigo)->get();
        if ($indicador->count() > 0)
            return redirect()->route('listarindicadores')->with('error', 'El Indicador ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'medido_a_traves' => 'required',
            'unidad_medida' => 'required',
            'frecuencia_reporte' => 'required',
            'meta_2024_3' => 'required',
            'meta_2024_4' => 'required',
            'meta_2024' => 'required',
            'meta_2025_1' => 'required',
            'meta_2025_2' => 'required',
            'meta_2025_3' => 'required',
            'meta_2025_4' => 'required',
            'meta_2025' => 'required',
            'meta_2026_1' => 'required',
            'meta_2026_2' => 'required',
            'meta_2026_3' => 'required',
            'meta_2026_4' => 'required',
            'meta_2026' => 'required',
            'meta_2027_1' => 'required',
            'meta_2027_2' => 'required',
            'meta_2027_3' => 'required',
            'meta_2027_4' => 'required',
            'meta_2027' => 'required',
            'meta_cuatrenio' => 'required',
            'plan_abrigo' => 'required',
            'id_sector' => 'required|exists:sectors,id',
            'id_mga' => 'required|exists:indicador_mgas,id',
            'id_apuesta' => 'required|exists:apuestas,id',
            'id_tipo_indicador' => 'required|exists:tipo_indicadors,id'
        ]);
        $indicador = new Indicador();
        $indicador->codigo_interno = $request->input('codigo');
        $indicador->nombre = $request->input('nombre');
        $indicador->descripcion = $request->input('descripcion');
        $indicador->medido_a_traves = $request->input('medido_a_traves');
        $indicador->unidad_medida = $request->input('unidad_medida');
        $indicador->frecuencia_reporte = $request->input('frecuencia_reporte');
        $indicador->meta_2024_3 = $request->input('meta_2024_3');
        $indicador->meta_2024_4 = $request->input('meta_2024_4');
        $indicador->mmeta_2024 = $request->input('meta_2024');
        $indicador->meta_2025_1 = $request->input('meta_2025_1');
        $indicador->meta_2025_2 = $request->input('meta_2025_2');
        $indicador->meta_2025_3 = $request->input('meta_2025_3');
        $indicador->meta_2025_4 = $request->input('meta_2025_4');
        $indicador->meta_2025 = $request->input('meta_2025');
        $indicador->meta_2026_1 = $request->input('meta_2026_1');
        $indicador->meta_2026_2 = $request->input('meta_2026_2');
        $indicador->meta_2026_3 = $request->input('meta_2026_3');
        $indicador->meta_2026_4 = $request->input('meta_2026_4');
        $indicador->meta_2026 = $request->input('meta_2026');
        $indicador->meta_2027_1 = $request->input('meta_2027_1');
        $indicador->meta_2027_2 = $request->input('meta_2027_2');
        $indicador->meta_2027_3 = $request->input('meta_2027_3');
        $indicador->meta_2027_4 = $request->input('meta_2027_4');
        $indicador->meta_2027 = $request->input('meta_2027');
        $indicador->meta_cuatrenio = $request->input('meta_cuatrenio');
        $indicador->plan_abrigo = $request->input('plan_abrigo');
        $indicador->id_sector = $request->input('id_sector');
        $indicador->id_mga = $request->input('id_mga');
        $indicador->id_apuesta = $request->input('id_apuesta');
        $indicador->id_tipo_indicador = $request->input('id_tipo_indicador');
        $indicador->estado = 'Activo';
        $indicador->save();
        return redirect()->route('listarindicadores')->with('success', 'Indicador creado correctamente');
    }

    public function verindicador($id) {
        $indicador = Indicador::with([''])->find($id);
        return response()->json($indicador);
    }

    public function editarindicador($id) {
        $indicador = Indicador::find($id);
        return response()->json($indicador);
    }

    public function actualizarindicador(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'medido_a_traves' => 'required',
            'unidad_medida' => 'required',
            'frecuencia_reporte' => 'required',
            'meta_2024_3' => 'required',
            'meta_2024_4' => 'required',
            'meta_2024' => 'required',
            'meta_2025_1' => 'required',
            'meta_2025_2' => 'required',
            'meta_2025_3' => 'required',
            'meta_2025_4' => 'required',
            'meta_2025' => 'required',
            'meta_2026_1' => 'required',
            'meta_2026_2' => 'required',
            'meta_2026_3' => 'required',
            'meta_2026_4' => 'required',
            'meta_2026' => 'required',
            'meta_2027_1' => 'required',
            'meta_2027_2' => 'required',
            'meta_2027_3' => 'required',
            'meta_2027_4' => 'required',
            'meta_2027' => 'required',
            'meta_cuatrenio' => 'required',
            'plan_abrigo' => 'required',
            'id_sector' => 'required|exists:sectors,id',
            'id_mga' => 'required|exists:indicador_mgas,id',
            'id_apuesta' => 'required|exists:apuestas,id',
            'id_tipo_indicador' => 'required|exists:tipo_indicadors,id',
            'estado' => 'required'
        ]);
        $indicador = Indicador::find($request->input('id'));
        $indicador->codigo_interno = $request->input('codigo');
        $indicador->nombre = $request->input('nombre');
        $indicador->descripcion = $request->input('descripcion');
        $indicador->medido_a_traves = $request->input('medido_a_traves');
        $indicador->unidad_medida = $request->input('unidad_medida');
        $indicador->frecuencia_reporte = $request->input('frecuencia_reporte');
        $indicador->meta_2024_3 = $request->input('meta_2024_3');
        $indicador->meta_2024_4 = $request->input('meta_2024_4');
        $indicador->mmeta_2024 = $request->input('meta_2024');
        $indicador->meta_2025_1 = $request->input('meta_2025_1');
        $indicador->meta_2025_2 = $request->input('meta_2025_2');
        $indicador->meta_2025_3 = $request->input('meta_2025_3');
        $indicador->meta_2025_4 = $request->input('meta_2025_4');
        $indicador->meta_2025 = $request->input('meta_2025');
        $indicador->meta_2026_1 = $request->input('meta_2026_1');
        $indicador->meta_2026_2 = $request->input('meta_2026_2');
        $indicador->meta_2026_3 = $request->input('meta_2026_3');
        $indicador->meta_2026_4 = $request->input('meta_2026_4');
        $indicador->meta_2026 = $request->input('meta_2026');
        $indicador->meta_2027_1 = $request->input('meta_2027_1');
        $indicador->meta_2027_2 = $request->input('meta_2027_2');
        $indicador->meta_2027_3 = $request->input('meta_2027_3');
        $indicador->meta_2027_4 = $request->input('meta_2027_4');
        $indicador->meta_2027 = $request->input('meta_2027');
        $indicador->meta_cuatrenio = $request->input('meta_cuatrenio');
        $indicador->plan_abrigo = $request->input('plan_abrigo');
        $indicador->id_sector = $request->input('id_sector');
        $indicador->id_mga = $request->input('id_mga');
        $indicador->id_apuesta = $request->input('id_apuesta');
        $indicador->id_tipo_indicador = $request->input('id_tipo_indicador');
        $indicador->estado = 'Activo';
        $indicador->save();
        return redirect()->route('listarindicadores')->with('success', 'Indicador actualizado correctamente');
    }

    public function eliminarindicador($id) {
        $indicador = Indicador::find($id);
        if ($indicador) {
            $indicador->estado = "Inactivo";
            $indicador->save();
            return response()->json(['success' => true, 'message' => 'Indicador Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Indicador no encontrado']);
    }
}