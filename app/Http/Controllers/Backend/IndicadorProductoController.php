<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\IndicadorProducto;
use App\Models\IndicadorResultado;
use App\Models\MedidaProducto;
use App\Models\Apuesta;
use App\Models\Sector;
use App\Models\Programa;
use App\Models\IndicadorMga;
use App\Models\Dependencia;
use App\Models\Orientacion;
use App\Models\VariablePobreza;
use App\Models\Logro;
use App\Models\Edpm;
use App\Models\MetaOds;
use App\Models\Ods;
use App\Models\IndicadorProductoMetaOds;
use App\Imports\csvImportIndProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class IndicadorProductoController extends Controller
{
    //
    public function listarips() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $ips = IndicadorProducto::orderBy('codigo_ip')->get();
            return view('admin/ip.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'ips'));
        }
        return Redirect::route('login');
    }

    public function guardarip(Request $request) {
        $ip = IndicadorProducto::where('nombre_ip', $request->nombre)->get();
        if ($ip->count() > 0)
            return redirect()->route('listarips')->with('error', 'El Indicador de Producto ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'linea' => 'required',
            'fuente' => 'required',
            'meta' => 'required',
            'meta_real' => 'required',
            'id_mr' => 'required|exists:medida_resultados,id',
            'id_mo' => 'required|exists:meta_ods,id'
        ]);
        $ip = new IndicadorProducto();
        $ip->codigo_ip = $request->input('codigo');
        $ip->nombre_ip = $request->input('nombre');
        $ip->linea_ip = $request->input('linea');
        $ip->fuente_ip = $request->input('fuente');
        $ip->meta_ip = $request->input('meta');
        $ip->meta_ip_real = $request->input('meta_real');
        $ip->id_mr = $request->input('id_mr');
        $ip->id_mo = $request->input('id_mo');
        $ip->estado_ip = 'Activo';
        $ip->save();
        return redirect()->route('listarips')->with('success', 'Indicador de Producto creado correctamente');
    }

    public function verip($id) {
        $ip = IndicadorProducto::with(['resultado', 'dependencia', 'apuesta.dimension.estrategia_dimension', 'programa.sectorial.sectordependencia', 'mga', 'medida', 'orientar', 'variable.dimension', 'logro', 'edpm'])->find($id);
        $ip->metas_ods = MetaOds::join('indicador_producto_meta_ods', 'meta_ods.id', '=', 'indicador_producto_meta_ods.id_mo')
                                                ->select('meta_ods.id', 'meta_ods.codigo_mo', 'meta_ods.nombre_mo')
                                                ->where('indicador_producto_meta_ods.id_ip', $ip->codigo_ip)
                                                ->get();
        $ip->ods = Ods::join('meta_ods', 'ods.id', '=', 'meta_ods.id_ods')
                        ->join('indicador_producto_meta_ods', 'meta_ods.id', '=', 'indicador_producto_meta_ods.id_mo')
                        ->select('ods.id', 'ods.codigo_ods', 'ods.nombre_ods')
                        ->where('indicador_producto_meta_ods.id_ip', $ip->codigo_ip)
                        ->distinct()
                        ->get();
        return response()->json($ip);
    }

    public function veripods($id) {
        $ods = Ods::find($id);
        return response()->json($ods);
    }

    public function veripmetods($id) {
        $metaods = MetaOds::with('ods')->find($id);
        return response()->json($metaods);
    }

    public function editarip($id) {
        $ip = IndicadorProducto::find($id);
        return response()->json($ip);
    }

    public function actualizarip(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'linea' => 'required',
            'fuente' => 'required',
            'meta' => 'required',
            'meta_real' => 'required',
            'id_mr' => 'required|exists:medida_resultados,id',
            'id_mo' => 'required|exists:meta_ods,id',
            'estado' => 'required'
        ]);
        $ip = IndicadorProducto::find($request->input('id'));
        $ip->codigo_ip = $request->input('codigo');
        $ip->nombre_ip = $request->input('nombre');
        $ip->linea_ip = $request->input('linea');
        $ip->fuente_ip = $request->input('fuente');
        $ip->meta_ip = $request->input('meta');
        $ip->meta_ip_real = $request->input('meta_real');
        $ip->id_mr = $request->input('id_mr');
        $ip->id_mo = $request->input('id_mo');
        $ip->estado_ip = $request->input('estado');
        $ip->save();
        return redirect()->route('listarips')->with('success', 'Indicador de Producto actualizado correctamente');
    }

    public function eliminarip($id) {
        $ip = IndicadorProducto::find($id);
        if ($ip) {
            $ip->estado_ip = "Inactivo";
            $ip->save();
            return response()->json(['success' => true, 'message' => 'Indicador de Producto Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Indicador de Producto no encontrado']);
    }

    public function csvips(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_ip', 'nombre_ip', 'descripcion_ip', 'id_ir', 'id_d', 'id_a', 'id_s', 'id_p', 'id_mga', 'linea_ip', 'id_mp', 'frecuencia_ip', 'fuente_ip', 'meta_ip', 'abrigo_ip', 'id_o', 'id_vp', 'id_lu', 'id_edpm', 'meta_ip_real', 'estado_ip'];

        $encabezadosLeidos = array_map('trim', $headings[0][0]);
        sort($encabezadosLeidos);
        sort($encabezadosEsperados);
        //dd($encabezadosEsperados,$encabezadosLeidos);

        // Verificar si los encabezados coinciden
        // Comparamos si los encabezados obtenidos coinciden con los esperados
        if ($encabezadosLeidos !== $encabezadosEsperados) {
            return redirect()->back()->with('error', 'La estructura del archivo no es válida. Verifica los encabezados.');
        }

        // Continuar con la importación si todo está bien
        // Crear la instancia de la clase de importación
        $importar = new csvImportIndProducto;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todos los Indicadores de Productos ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevos Indicadores de Productos importados correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}