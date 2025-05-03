<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GrupoPoblacion;
use App\Imports\csvImportGruPoblacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class GrupoPoblacionController extends Controller
{
    //
    public function listargrupobs() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $grupobs = GrupoPoblacion::orderBy('codigo_gp')->get();
            return view('admin/grupob.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'grupobs'));
        }
        return Redirect::route('login');
    }

    public function guardargrupob(Request $request) {
        $grupob = GrupoPoblacion::where('codigo_gp', $request->codigo)->get();
        if ($grupob->count() > 0)
            return redirect()->route('listargrupobs')->with('error', 'El Grupo Poblacionial ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
        ]);
        $grupob = new GrupoPoblacion();
        $grupob->codigo_gp = $request->input('codigo');
        $grupob->nombre_gp = $request->input('nombre');
        $grupob->estado_gp = 'Activo';
        $grupob->save();
        return redirect()->route('listargrupobs')->with('success', 'Grupo Poblacionial creado correctamente');
    }

    public function vergrupob($id) {
        $grupob = GrupoPoblacion::find($id);
        return response()->json($grupob);
    }

    public function editargrupob($id) {
        $grupob = GrupoPoblacion::find($id);
        return response()->json($grupob);
    }

    public function actualizargrupob(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'estado' => 'required',
        ]);
        $grupob = GrupoPoblacion::find($request->input('id'));
        $grupob->codigo_gp = $request->input('codigo');
        $grupob->nombre_gp = $request->input('nombre');
        $grupob->estado_gp = $request->input('estado');
        $grupob->save();
        return redirect()->route('listargrupobs')->with('success', 'Grupo Poblacionial actualizado correctamente');
    }

    public function eliminargrupob($id) {
        $grupob = GrupoPoblacion::find($id);
        if ($grupob) {
            $grupob->estado_gp = "Inactivo";
            $grupob->save();
            return response()->json(['success' => true, 'message' => 'Grupo Poblacionial Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Grupo Poblacionial no encontrado']);
    }

    public function csvgrupobs(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_gp', 'nombre_gp', 'estado_gp'];

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
        $importar = new csvImportGruPoblacion;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todos los Grupos Poblacioniales ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevos Grupos Poblacioniales importados correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}

