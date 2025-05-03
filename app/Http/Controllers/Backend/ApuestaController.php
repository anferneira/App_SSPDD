<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Dimension;
use App\Models\Apuesta;
use App\Imports\csvImportApuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ApuestaController extends Controller
{
    //
    public function listarapuestas() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $dimensiones = Dimension::orderBy('codigo_d')->get();
            $apuestas = Apuesta::orderBy('codigo_a')->get();
            return view('admin/apuesta.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'dimensiones', 'apuestas'));
        }
        return Redirect::route('login');
    }

    public function guardarapuesta(Request $request) {
        $apuesta = Apuesta::where('codigo_a', $request->codigo)->get();
        if ($apuesta->count() > 0)
            return redirect()->route('listarapuestas')->with('error', 'La Apuesta ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'objetivo' => 'required',
            'id_dimension' => 'required|exists:dimensions,id'
        ]);
        $apuesta = new Apuesta();
        $apuesta->codigo_a = $request->input('codigo');
        $apuesta->nombre_a = $request->input('nombre');
        $apuesta->objetivo_a = $request->input('objetivo');
        $apuesta->id_d = $request->input('id_dimension');
        $apuesta->estado_a = 'Activo';
        $apuesta->save();
        return redirect()->route('listarapuestas')->with('success', 'Apuesta creada correctamente');
    }

    public function verapuesta($id) {
        $apuesta = Apuesta::with('dimension.estrategia_dimension')->find($id);
        return response()->json($apuesta);
    }

    public function editarapuesta($id) {
        $apuesta = Apuesta::find($id);
        return response()->json($apuesta);
    }

    public function actualizarapuesta(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'objetivo' => 'required',
            'estado' => 'required',
            'id_dimension' => 'required|exists:dimensions,id'
        ]);
        $apuesta = Apuesta::find($request->input('id'));
        $apuesta->codigo_a = $request->input('codigo');
        $apuesta->nombre_a = $request->input('nombre');
        $apuesta->id_d = $request->input('id_dimension');
        $apuesta->estado_a = $request->input('estado');
        $apuesta->save();
        return redirect()->route('listarapuestas')->with('success', 'Apuesta actualizada correctamente');
    }

    public function eliminarapuesta($id) {
        $apuesta = Apuesta::find($id);
        if ($apuesta) {
            $apuesta->estado_a = "Inactivo";
            $apuesta->save();
            return response()->json(['success' => true, 'message' => 'Apuesta Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Apuesta no encontrada']);
    }

    public function csvapuestas(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_a', 'nombre_a', 'objetivo_a', 'estado_a', 'id_d'];

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
        $importar = new csvImportApuesta;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Apuestas ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Apuestas importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
