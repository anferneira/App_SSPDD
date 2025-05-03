<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\IndicadorResultado;
use App\Models\MedidaResultado;
use App\Models\MetaOds;
use App\Imports\csvImportIndResultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class IndicadorResultadoController extends Controller
{
    //
    public function listarirs() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $irs = IndicadorResultado::orderBy('codigo_ir')->get();
            $metas = MetaOds::orderBy('codigo_mo')->get();
            $medidas = MedidaResultado::orderBy('nombre_mr')->get();
            return view('admin/ir.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'medidas', 'irs', 'metas'));
        }
        return Redirect::route('login');
    }

    public function guardarir(Request $request) {
        $ir = IndicadorResultado::where('nombre_ir', $request->nombre)->get();
        if ($ir->count() > 0)
            return redirect()->route('listarirs')->with('error', 'El Indicador de Resultado ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'linea' => 'required',
            'fuente' => 'required',
            'meta' => 'required',
            'transformacion' => 'required',
            'id_mr' => 'required|exists:medida_resultados,id',
            'id_mo' => 'required|exists:meta_ods,id'
        ]);
        $ir = new IndicadorResultado();
        $ir->codigo_ir = $request->input('codigo');
        $ir->nombre_ir = $request->input('nombre');
        $ir->linea_ir = $request->input('linea');
        $ir->fuente_ir = $request->input('fuente');
        $ir->meta_ir = $request->input('meta');
        $ir->transformacion_ir = $request->input('transformacion');
        $ir->id_mr = $request->input('id_mr');
        $ir->id_mo = $request->input('id_mo');
        $ir->estado_ir = 'Activo';
        $ir->save();
        return redirect()->route('listarirs')->with('success', 'Indicador de Resultado creado correctamente');
    }

    public function verir($id) {
        $ir = IndicadorResultado::with(['medidas', 'metas_ods.ods'])->find($id);
        return response()->json($ir);
    }

    public function editarir($id) {
        $ir = IndicadorResultado::find($id);
        return response()->json($ir);
    }

    public function actualizarir(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'linea' => 'required',
            'fuente' => 'required',
            'meta' => 'required',
            'transformacion' => 'required',
            'id_mr' => 'required|exists:medida_resultados,id',
            'id_mo' => 'required|exists:meta_ods,id',
            'estado' => 'required'
        ]);
        $ir = IndicadorResultado::find($request->input('id'));
        $ir->codigo_ir = $request->input('codigo');
        $ir->nombre_ir = $request->input('nombre');
        $ir->linea_ir = $request->input('linea');
        $ir->fuente_ir = $request->input('fuente');
        $ir->meta_ir = $request->input('meta');
        $ir->transformacion_ir = $request->input('transformacion');
        $ir->id_mr = $request->input('id_mr');
        $ir->id_mo = $request->input('id_mo');
        $ir->estado_ir = $request->input('estado');
        $ir->save();
        return redirect()->route('listarirs')->with('success', 'Indicador de Resultado actualizado correctamente');
    }

    public function eliminarir($id) {
        $ir = IndicadorResultado::find($id);
        if ($ir) {
            $ir->estado_ir = "Inactivo";
            $ir->save();
            return response()->json(['success' => true, 'message' => 'Indicador de Resultado Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Indicador de Resultado no encontrado']);
    }

    public function csvirs(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_ir', 'nombre_ir', 'linea_ir', 'fuente_ir', 'meta_ir', 'transformacion_ir', 'id_mr', 'id_mo', 'estado_ir'];

        $encabezadosLeidos = array_map('trim', $headings[0][0]);
        sort($encabezadosLeidos);
        sort($encabezadosEsperados);

        // Verificar si los encabezados coinciden
        // Comparamos si los encabezados obtenidos coinciden con los esperados
        if ($encabezadosLeidos !== $encabezadosEsperados) {
            return redirect()->back()->with('error', 'La estructura del archivo no es válida. Verifica los encabezados.');
        }

        // Continuar con la importación si todo está bien
        // Crear la instancia de la clase de importación
        $importar = new csvImportIndResultado;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todos los Indicadores de Resultados ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevos Indicadores de Resultados importados correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}