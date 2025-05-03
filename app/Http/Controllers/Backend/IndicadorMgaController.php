<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\IndicadorMga;
use App\Imports\csvImportIndicadorMga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class IndicadorMgaController extends Controller
{
    //
    public function listarmgas() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $mgas = IndicadorMga::orderBy('codigo_mga')->get();
            return view('admin/mga.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'mgas'));
        }
        return Redirect::route('login');
    }

    public function guardarmga(Request $request) {
        $mga = IndicadorMga::where('codigo_mga', $request->codigo)->get();
        if ($mga->count() > 0)
            return redirect()->route('listarmgas')->with('error', 'El Indicador MGA ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'producto' => 'required|string|max:100',
            'estado' => 'required|string|max:20'
        ]);
        $mga = new IndicadorMga();
        $mga->codigo_mga = $request->input('codigo');
        $mga->producto_mga = $request->input('producto');
        $mga->estado_mga = 'Activo';
        $mga->save();
        return redirect()->route('listarmgas')->with('success', 'Indicador MGA creado correctamente');
    }

    public function vermga($id) {
        $mga = IndicadorMga::find($id);
        return response()->json($mga);
    }

    public function editarmga($id) {
        $mga = IndicadorMga::find($id);
        return response()->json($mga);
    }

    public function actualizarmga(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'producto' => 'required',
            'estado' => 'required'
        ]);
        $mga = IndicadorMga::find($request->input('id'));
        $mga->codigo_mga = $request->input('codigo');
        $mga->producto_mga = $request->input('producto');
        $mga->estado_mga = $request->input('estado');
        $mga->save();
        return redirect()->route('listarmgas')->with('success', 'Indicador MGA actualizado correctamente');
    }

    public function eliminarmga($id) {
        $mga = IndicadorMga::find($id);
        if ($mga) {
            $mga->estado_mga = "Inactivo";
            $mga->save();
            return response()->json(['success' => true, 'message' => 'Indicador MGA Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Indicador MGA no encontrado']);
    }

    public function csvmgas(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_mga', 'producto_mga', 'estado_mga'];

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
        $importar = new csvImportIndicadorMga;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todos los Indicadores MGA ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevos Indicadores MGA importados correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
