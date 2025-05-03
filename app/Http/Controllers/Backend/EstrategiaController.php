<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Estrategia;
use App\Imports\csvImportEstrategia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class EstrategiaController extends Controller
{
    //
    public function listarestrategias() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $estrategias = Estrategia::orderBy('codigo_e')->get();
            return view('admin/estrategia.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'estrategias'));
        }
        return Redirect::route('login');
    }

    public function guardarestrategia(Request $request) {
        $estrategia = Estrategia::where('codigo_e', $request->codigo)->get();
        if ($estrategia->count() > 0)
            return redirect()->route('listarestrategias')->with('error', 'La Estrategia ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'estado' => 'required'
        ]);
        $estrategia = new Estrategia();
        $estrategia->codigo_e = $request->input('codigo');
        $estrategia->nombre_e = $request->input('nombre');
        $estrategia->estado_e = 'Activo';
        $estrategia->save();
        return redirect()->route('listarestrategias')->with('success', 'Estrategia creada correctamente');
    }

    public function verestrategia($id) {
        $estrategia = Estrategia::find($id);
        return response()->json($estrategia);
    }

    public function editarestrategia($id) {
        $estrategia = Estrategia::find($id);
        return response()->json($estrategia);
    }

    public function actualizarestrategia(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'estado' => 'required'
        ]);
        $estrategia = Estrategia::find($request->input('id'));
        $estrategia->codigo_e = $request->input('codigo');
        $estrategia->nombre_e = $request->input('nombre');
        $estrategia->estado_e = $request->input('estado');
        $estrategia->save();
        return redirect()->route('listarestrategias')->with('success', 'Estrategia actualizada correctamente');
    }

    public function eliminarestrategia($id) {
        $estrategia = Estrategia::find($id);
        if ($estrategia) {
            $estrategia->estado_e = "Inactivo";
            $estrategia->save();
            return response()->json(['success' => true, 'message' => 'Estrategia Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Estrategia no encontrada']);
    }

    public function csvestrategias(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_e', 'nombre_e', 'estado_e'];

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
        $importar = new csvImportEstrategia;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Estrategias ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Estrategias importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
