<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Ods;
use App\Imports\csvImportOds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class OdsController extends Controller
{
    //
    public function listarodss() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $odss = Ods::orderBy('codigo_ods')->get();
            return view('admin/ods.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'odss'));
        }
        return Redirect::route('login');
    }

    public function guardarods(Request $request) {
        $ods = Ods::where('codigo_ods', $request->codigo)->get();
        if ($ods->count() > 0)
            return redirect()->route('listarodss')->with('error', 'El Ods ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required'
        ]);
        $ods = new Ods();
        $ods->codigo_ods = $request->input('codigo');
        $ods->nombre_ods = $request->input('nombre');
        $ods->estado_ods = 'Activo';
        $ods->save();
        return redirect()->route('listarodss')->with('success', 'Ods creado correctamente');
    }

    public function verods($id) {
        $ods = Ods::find($id);
        return response()->json($ods);
    }

    public function editarods($id) {
        $ods = Ods::find($id);
        return response()->json($ods);
    }

    public function actualizarods(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'estado' => 'required'
        ]);
        $ods = Ods::find($request->input('id'));
        $ods->codigo_ods = $request->input('codigo');
        $ods->nombre_ods = $request->input('nombre');
        $ods->estado_ods = $request->input('estado');
        $ods->save();
        return redirect()->route('listarodss')->with('success', 'Ods actualizado correctamente');
    }

    public function eliminarods($id) {
        $ods = Ods::find($id);
        if ($ods) {
            $ods->estado_ods = "Inactivo";
            $ods->save();
            return response()->json(['success' => true, 'message' => 'Ods Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Ods no encontrada']);
    }

    public function csvodss(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_ods', 'nombre_ods', 'estado_ods'];

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
        $importar = new csvImportOds;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todos los Ods ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevos Ods importados correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
