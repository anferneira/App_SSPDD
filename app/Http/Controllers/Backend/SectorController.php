<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use App\Models\Dependencia;
use App\Imports\csvImportSector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class SectorController extends Controller
{
    //
    public function listarsectores() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $sectoriales = Sector::orderBy('codigo_s')->get();
            $dependencias = Dependencia::orderBy('nombre_d')->get();
            return view('admin/sector.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'dependencias', 'sectoriales'));
        }
        return Redirect::route('login');
    }

    public function guardarsector(Request $request) {
        $sector = Sector::where('codigo_s', $request->codigo)->get();
        if ($sector->count() > 0)
            return redirect()->route('listarsectoriales')->with('error', 'La Sectorial ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required|string|max:100',
            'estado' => 'required|string|max:20',
            'id_d' => 'required|exists:dependencias,id',
        ]);
        $sectorial = new Sector();
        $sectorial->codigo_s = $request->input('codigo');
        $sectorial->nombre_s = $request->input('nombre');
        $sectorial->id_d = $request->input('id_d');
        $sectorial->estado_s = 'Activo';
        $sectorial->save();
        return redirect()->route('listarsectores')->with('success', 'Sectorial creada correctamente');
    }

    public function versector($id) {
        $sectorial = Sector::with('sectordependencia')->find($id);
        return response()->json($sectorial);
    }

    public function editarsector($id) {
        $sectorial = Sector::find($id);
        return response()->json($sectorial);
    }

    public function actualizarsector(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'estado' => 'required',
            'id_d' => 'required|exists:dependencias,id',
        ]);
        $sectorial = Sector::find($request->input('id'));
        $sectorial->codigo_s = $request->input('codigo');
        $sectorial->nombre_s = $request->input('nombre');
        $sectorial->id_d = $request->input('id_d');
        $sectorial->estado_s = $request->input('estado');
        $sectorial->save();
        return redirect()->route('listarsectores')->with('success', 'Sectorial actualizada correctamente');
    }

    public function eliminarsector($id) {
        $sectorial = Sector::find($id);
        if ($sectorial) {
            $sectorial->estado_s = "Inactivo";
            $sectorial->save();
            return response()->json(['success' => true, 'message' => 'Sectorial Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Sectorial no encontrada']);
    }

    public function csvsectores(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_s', 'nombre_s', 'id_d', 'estado_s'];

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
        $importar = new csvImportSector;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Sectoriales ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Sectoriales importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}

