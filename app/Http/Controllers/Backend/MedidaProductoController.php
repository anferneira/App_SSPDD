<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MedidaProducto;
use App\Imports\csvImportMedProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class MedidaProductoController extends Controller
{
    //
    public function listarmedprods() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $medprods = MedidaProducto::orderBy('medido_mp')->get();
            return view('admin/medprod.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'medprods'));
        }
        return Redirect::route('login');
    }

    public function guardarmedprod(Request $request) {
        $medprod = MedidaProducto::where('medido_mp', $request->codigo)->get();
        if ($medprod->count() > 0)
            return redirect()->route('listarmedprods')->with('error', 'La Medida de Producto ya existe en el sistema.');
        $request->validate([
            'medido' => 'required',
            'unidad' => 'required',
            'estado' => 'required'
        ]);
        $medprod = new MedidaProducto();
        $medprod->codigo_mp = $request->input('medido');
        $medprod->nombre_mp = $request->input('unidad');
        $medprod->estado_mp = 'Activo';
        $medprod->save();
        return redirect()->route('listarmedprods')->with('success', 'Medida de Producto creada correctamente');
    }

    public function vermedprod($id) {
        $medprod = MedidaProducto::find($id);
        return response()->json($medprod);
    }

    public function editarmedprod($id) {
        $medprod = MedidaProducto::find($id);
        return response()->json($medprod);
    }

    public function actualizarmedprod(Request $request) {
        $request->validate([
            'medido' => 'required',
            'unidad' => 'required',
            'estado' => 'required'
        ]);
        $medprod = MedidaProducto::find($request->input('id'));
        $medprod->medido_mp = $request->input('medido');
        $medprod->unidad_mp = $request->input('unidad');
        $medprod->estado_mp = $request->input('estado');
        $medprod->save();
        return redirect()->route('listarmedprods')->with('success', 'Medida de Producto actualizada correctamente');
    }

    public function eliminarmedprod($id) {
        $medprod = MedidaProducto::find($id);
        if ($medprod) {
            $medprod->estado_mp = "Inactivo";
            $medprod->save();
            return response()->json(['success' => true, 'message' => 'Medida de Producto Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Medida de Producto no encontrada']);
    }

    public function csvmedprods(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['medido_mp', 'unidad_mp', 'estado_mp'];

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
        $importar = new csvImportMedProducto;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Medidas de Productos ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Medida de Productos importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
