<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Edpm;
use App\Imports\csvImportEdpm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class EdpmController extends Controller
{
    //
    public function listaredpms() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $edpms = Edpm::orderBy('nombre_edpm')->get();
            return view('admin/edpm.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'edpms'));
        }
        return Redirect::route('login');
    }

    public function guardaredpm(Request $request) {
        $edpm = Edpm::where('nombre_edpm', $request->nombre)->get();
        if ($sector->count() > 0)
            return redirect()->route('listaredpms')->with('error', 'La Estrategia EDPM ya existe en el sistema.');
        $request->validate([
            'nombre' => 'required',
            'programa' => 'required|string|max:100',
            'estado' => 'required|string|max:20',
        ]);
        $edpm = new Edpm();
        $edpm->nombre_edpm = $request->input('nombre');
        $edpm->programa_edpm = $request->input('programa');
        $edpm->estado_edpm = 'Activo';
        $edpm->save();
        return redirect()->route('listaredpms')->with('success', 'Estrategia EDPM creada correctamente');
    }

    public function veredpm($id) {
        $edpm = Edpm::find($id);
        return response()->json($edpm);
    }

    public function editaredpm($id) {
        $edpm = Edpm::find($id);
        return response()->json($edpm);
    }

    public function actualizaredpm(Request $request) {
        $request->validate([
            'nombre' => 'required',
            'programa' => 'required',
            'estado' => 'required',
        ]);
        $edpm = Edpm::find($request->input('id'));
        $edpm->nombre_edpm = $request->input('nombre');
        $edpm->programa_edpm = $request->input('programa');
        $edpm->estado_edpm = $request->input('estado');
        $edpm->save();
        return redirect()->route('listaredpms')->with('success', 'Estrategia EDPM actualizada correctamente');
    }

    public function eliminaredpm($id) {
        $edpm = Edpm::find($id);
        if ($edpm) {
            $edpm->estado_edpm = "Inactivo";
            $edpm->save();
            return response()->json(['success' => true, 'message' => 'Estrategia EDPM Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Estrategia EDPM no encontrada']);
    }

    public function csvedpms(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['nombre_edpm', 'programa_edpm', 'estado_edpm'];

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
        $importar = new csvImportEdpm;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Estrategias EDPM ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Estrategias EDPM importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}

