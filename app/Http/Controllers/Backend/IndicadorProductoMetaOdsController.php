<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\IndicadorProductoMetaOds;
use App\Models\IndicadorProducto;
use App\Models\MetaOds;
use App\Models\Ods;
use App\Imports\csvImportIndProductoMetaOds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class IndicadorProductoMetaOdsController extends Controller
{
    //
    public function listaripmos() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $ipmos = IndicadorProductoMetaOds::orderBy('id_ip')->get();
            $ips = IndicadorProducto::orderBy('codigo_ip')->get();
            $mos = MetaOds::orderBy('codigo_mo')->get();
            $odss = Ods::orderBy('codigo_ods')->get();
            return view('admin/ipmo.index1', compact('usuario', 'nombre', 'rol', 'dependencia', 'ipmos', 'ips', 'mos', 'odss'));
        }
        return Redirect::route('login');
    }

    public function guardaripmo(Request $request) {
        $ipmo = IndicadorProductoMetaOds::where('id_ip', $request->id_ip)
                                        ->where('id_mo', $request->id_mo)->get();
        if ($ipmo->count() > 0)
            return redirect()->route('listaripmos')->with('error', 'La Meta Ods en el Indicador de Producto ya existe en el sistema.');
        $request->validate([
            'id_ip' => 'required|exists:indicador_productos,id',
            'id_mo' => 'required|exists:meta_ods,id'
        ]);
        $ipmo = new IndicadorProductoMetaOds();
        $ipmo->id_ip = $request->input('id_ip');
        $ipmo->id_mo = $request->input('id_mo');
        $ipmo->estado_imo = 'Activo';
        $ipmo->save();
        return redirect()->route('listaripmos')->with('success', 'Meta Ods en Indicador de Producto creada correctamente');
    }

    public function veripmo($id) {
        $ipmo = IndicadorProductoMetaOds::with(['producto', 'meta_ods.ods'])->find($id);
        return response()->json($ipmo);
    }

    public function mostrar_ods() {
        $ods = Ods::orderBy('codigo_ods')->get();
        return response()->json($ods);
    }

    public function editarip($id) {
        $ipmo = IndicadorProductoMetaOds::find($id);
        return response()->json($ipmo);
    }

    public function actualizaripmo(Request $request) {
        $request->validate([
            'id_ip' => 'requiped|exists:indicador_productos,id',
            'id_mo' => 'requiped|exists:meta_ods,id',
            'estado' => 'required'
        ]);
        $ipmo = IndicadorProductoMetaOds::find($request->input('id'));
        $ipmo->id_mr = $request->input('id_ip');
        $ipmo->id_mo = $request->input('id_mo');
        $ipmo->estado_imo = $request->input('estado');
        $ipmo->save();
        return redirect()->route('listaripmos')->with('success', 'Meta Ods en Indicador de Producto actualizada correctamente');
    }

    public function eliminaripmo($id) {
        $ipmo = IndicadorProductoMetaOds::find($id);
        if ($ipmo) {
            $ipmo->estado_imo = "Inactivo";
            $ipmo->save();
            return response()->json(['success' => true, 'message' => 'Meta Ods en Indicador de Producto Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Meta Ods en Indicador de Producto no encontrado']);
    }

    public function csvipmos(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['id_ip', 'id_mo', 'estado_imo'];

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
        $importar = new csvImportIndProductoMetaOds;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas la Metas ODS en los Indicadores de Productos ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Metas Ods en Indicadores de Productos importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}