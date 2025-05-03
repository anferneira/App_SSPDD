<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DimensionPobreza;
use App\Imports\csvImportDimPobreza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class DimensionPobrezaController extends Controller
{
    //
    public function listardimpobs() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $dimpobs = DimensionPobreza::orderBy('codigo_dp')->get();
            return view('admin/dimpob.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'dimpobs'));
        }
        return Redirect::route('login');
    }

    public function guardardimpob(Request $request) {
        $dimpob = DimensionPobreza::where('codigo_dimpob', $request->codigo)->get();
        if ($dimpob->count() > 0)
            return redirect()->route('listardimpobs')->with('error', 'La Dimensión de Pobreza ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required|string|max:100',
            'estado' => 'required|string|max:20'
        ]);
        $dimpob = new DimensionPobreza();
        $dimpob->codigo_dp = $request->input('codigo');
        $dimpob->nombre_dp = $request->input('nombre');
        $dimpob->estado_dp = 'Activo';
        $dimpob->save();
        return redirect()->route('listardimpobs')->with('success', 'Dimensión de Pobreza creada correctamente');
    }

    public function verdimpob($id) {
        $dimpob = DimensionPobreza::find($id);
        return response()->json($dimpob);
    }

    public function editardimpob($id) {
        $dimpob = DimensionPobreza::find($id);
        return response()->json($dimpob);
    }

    public function actualizardimpob(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'estado' => 'required'
        ]);
        $dimpob = DimensionPobreza::find($request->input('id'));
        $dimpob->codigo_dp = $request->input('codigo');
        $dimpob->nombre_dp = $request->input('nombre');
        $dimpob->estado_dp = $request->input('estado');
        $dimpob->save();
        return redirect()->route('listardimpobs')->with('success', 'Dimensión de Pobreza actualizada correctamente');
    }

    public function eliminardimpob($id) {
        $dimpob = DimensionPobreza::find($id);
        if ($dimpob) {
            $dimpob->estado_dp = "Inactivo";
            $dimpob->save();
            return response()->json(['success' => true, 'message' => 'Dimensión de Pobreza Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Dimensión de Pobreza no encontrada']);
    }

    public function csvdimpobs(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_dp', 'nombre_dp', 'estado_dp'];

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
        $importar = new csvImportDimPobreza;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Dimensiones de Pobreza ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas LDimensiones de Pobreza importados correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
