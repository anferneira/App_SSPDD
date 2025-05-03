<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Provincia;
use App\Imports\csvImportProvincia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ProvinciaController extends Controller
{
    //
    public function listarprovincias() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $provincias = Provincia::orderBy('nombre_p')->get();
            return view('admin/provincia.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'provincias'));
        }
        return Redirect::route('login');
    }

    public function guardarprovincia(Request $request) {
        $provincia = Provincia::where('nombre_p', $request->nombre)->get();
        if ($provincia->count() > 0)
            return redirect()->route('listarprovincias')->with('error', 'La Provincia ya existe en el sistema.');
        $request->validate([
            'nombre' => 'required',
            'estado' => 'required'
        ]);
        $provincia = new Provincia();
        $provincia->nombre_p = $request->input('nombre');
        $provincia->estado_p = 'Activo';
        $provincia->save();
        return redirect()->route('listarprovincias')->with('success', 'Provincia creada correctamente');
    }

    public function verprovincia($id) {
        $provincia = Provincia::find($id);
        return response()->json($provincia);
    }

    public function editarprovincia($id) {
        $provincia = Provincia::find($id);
        return response()->json($provincia);
    }

    public function actualizarprovincia(Request $request) {
        $request->validate([
            'nombre' => 'required',
            'estado' => 'required'
        ]);
        $provincia = Provincia::find($request->input('id'));
        $provincia->nombre_p = $request->input('nombre');
        $provincia->estado_p = $request->input('estado');
        $provincia->save();
        return redirect()->route('listarprovincias')->with('success', 'Provincia actualizada correctamente');
    }

    public function eliminarprovincia($id) {
        $provincia = Provincia::find($id);
        if ($provincia) {
            $provincia->estado_p = "Inactivo";
            $provincia->save();
            return response()->json(['success' => true, 'message' => 'Provincia Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Provincia no encontrada']);
    }

    public function csvprovincias(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['nombre_p', 'estado_p'];

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
        $importar = new csvImportProvincia;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Provincias ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Provincias importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
