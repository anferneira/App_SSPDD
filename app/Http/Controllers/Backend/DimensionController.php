<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Dimension;
use App\Models\Estrategia;
use App\Imports\csvImportDimension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class DimensionController extends Controller
{
    //
    public function listardimensiones() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $dimensiones = Dimension::orderBy('codigo_d')->get();
            $estrategias = Estrategia::orderBy('codigo_e')->get();
            return view('admin/dimension.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'dimensiones', 'estrategias'));
        }
        return Redirect::route('login');
    }

    public function guardardimension(Request $request) {
        $dimension = Dimension::where('codigo_d', $request->codigo)->get();
        if ($dimension->count() > 0)
            return redirect()->route('listardimensiones')->with('error', 'La Dimensión ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'estado' => 'required',
            'id_estrategia' => 'required|exists:estrategias,id'
        ]);
        $dimension = new Dimension();
        $dimension->codigo_d = $request->input('codigo');
        $dimension->nombre_d = $request->input('nombre');
        $dimension->id_e = $request->input('id_estrategia');
        $dimension->estado_d = 'Activo';
        $dimension->save();
        return redirect()->route('listardimensiones')->with('success', 'Dimensión creada correctamente');
    }

    public function verdimension($id) {
        $dimension = Dimension::with('estrategia_dimension')->find($id);
        return response()->json($dimension);
    }

    public function editardimension($id) {
        $dimension = Dimension::find($id);
        return response()->json($dimension);
    }

    public function actualizardimension(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'estado' => 'required',
            'id_estrategia' => 'required|exists:estrategias,id'
        ]);
        $dimension = Dimension::find($request->input('id'));
        $dimension->codigo_d = $request->input('codigo');
        $dimension->nombre_d = $request->input('nombre');
        $dimension->estado_d = $request->input('estado');
        $dimension->id_e = $request->input('id_estrategia');
        $dimension->save();
        return redirect()->route('listardimensiones')->with('success', 'Dimensión actualizada correctamente');
    }

    public function eliminardimension($id) {
        $dimension = Dimension::find($id);
        if ($dimension) {
            $dimension->estado_d = "Inactivo";
            $dimension->save();
            return response()->json(['success' => true, 'message' => 'Dimensión Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Dimensión no encontrada']);
    }

    public function csvdimensiones(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_d', 'nombre_d', 'id_e', 'estado_d'];

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
        $importar = new csvImportDimension;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Dimensiones ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Dimensiones importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
