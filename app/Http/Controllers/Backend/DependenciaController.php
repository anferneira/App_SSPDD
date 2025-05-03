<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Dependencia;
use App\Imports\csvImportDependencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class DependenciaController extends Controller
{
    //
    public function listardependencias() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $dependencias = Dependencia::orderBy('nombre_d')->get();
            return view('admin/dependencia.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'dependencias'));
        }
        return Redirect::route('login');
    }

    public function guardardependencia(Request $request) {
        $dependencia = Dependencia::where('nombre_d', $request->nombre)->get();
        if ($dependencia->count() > 0)
            return redirect()->route('listardependencias')->with('error', 'La Dependencia ya existe en el sistema.');
        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);
        $dependencia = new Dependencia();
        $dependencia->nombre_d = $request->input('nombre');
        $dependencia->estado_d = 'Activo';
        $dependencia->save();
        return redirect()->route('listardependencias')->with('success', 'Dependencia creada correctamente');
    }

    public function verdependencia($id) {
        $dependencia = Dependencia::find($id);
        return response()->json($dependencia);
    }

    public function editardependencia($id) {
        $dependencia = Dependencia::find($id);
        return response()->json($dependencia);
    }

    public function actualizardependencia(Request $request) {
        $request->validate([
            'nombre' => 'required',
            'estado' => 'required'
        ]);
        $dependencia = Dependencia::find($request->input('id'));
        $dependencia->nombre_d = $request->input('nombre');
        $dependencia->estado_d = $request->input('estado');
        $dependencia->save();
        return redirect()->route('listardependencias')->with('success', 'Dependencia actualizada correctamente');
    }

    public function eliminardependencia($id) {
        $dependencia = Dependencia::find($id);
        if ($dependencia) {
            $dependencia->estado_d = "Inactivo";
            $dependencia->save();
            return response()->json(['success' => true, 'message' => 'Dependencia Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Dependencia no encontrada']);
    }

    public function csvdependencias(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['nombre_d', 'estado_d'];

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
        $importar = new csvImportDependencia;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Dependencias ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Dependencias importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
