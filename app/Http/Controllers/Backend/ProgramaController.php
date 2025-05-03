<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Programa;
use App\Models\Sector;
use App\Imports\csvImportPrograma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ProgramaController extends Controller
{
    //
    public function listarprogramas() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $sectoriales = Sector::orderBy('codigo_s')->get();
            $programas = Programa::orderBy('nombre_p')->get();
            return view('admin/programa.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'programas', 'sectoriales'));
        }
        return Redirect::route('login');
    }

    public function guardarprograma(Request $request) {
        $programa = Programa::where('nombre_p', $request->nombre)->get();
        if ($programa->count() > 0)
            return redirect()->route('listarprogramas')->with('error', 'El Programa ya existe en el sistema.');
        $request->validate([
            'nombre' => 'required',
            'estado' => 'required',
            'id_s' => 'required|exists:sectors,id',
        ]);
        $programa = new Programa();
        $programa->nombre_p = $request->input('nombre');
        $programa->id_s = $request->input('id_sectorial');
        $programa->estado_p = 'Activo';
        $programa->save();
        return redirect()->route('listarprogramas')->with('success', 'Programa creado correctamente');
    }

    public function verprograma($id) {
        $programa = Programa::with('sectorial.sectordependencia')->find($id);
        return response()->json($programa);
    }

    public function editarprograma($id) {
        $programa = Programa::find($id);
        return response()->json($programa);
    }

    public function actualizarprograma(Request $request) {
        $request->validate([
            'nombre' => 'required',
            'estado' => 'required',
            'id_sector' => 'required|exists:sectors,id',
        ]);
        $programa = Programa::find($request->input('id'));
        $programa->nombre_p = $request->input('nombre');
        $programa->estado_p = $request->input('estado');
        $programa->id_s = $request->input('id_sector');
        $programa->save();
        return redirect()->route('listarprogramas')->with('success', 'Programa actualizado correctamente');
    }

    public function eliminarprograma($id) {
        $rograma = Programa::find($id);
        if ($rograma) {
            $rograma->estado_p = "Inactivo";
            $rograma->save();
            return response()->json(['success' => true, 'message' => 'Programa Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Programa no encontrado']);
    }

    public function csvprogramas(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['nombre_p', 'estado_p', 'id_s'];

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
        $importar = new csvImportPrograma;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todos los Programas ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevos Programas importados correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}

