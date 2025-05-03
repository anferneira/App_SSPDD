<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Logro;
use App\Imports\csvImportLogro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class LogroController extends Controller
{
    //
    public function listarlogros() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $logros = Logro::orderBy('codigo_lu')->get();
            return view('admin/logro.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'logros'));
        }
        return Redirect::route('login');
    }

    public function guardarlogro(Request $request) {
        $logro = Logro::where('codigo_lu', $request->codigo)->get();
        if ($logro->count() > 0)
            return redirect()->route('listarlogros')->with('error', 'El Logro Unido ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required|string|max:100',
            'estado' => 'required|string|max:20'
        ]);
        $logro = new Logro();
        $logro->codigo_lu = $request->input('codigo');
        $logro->nombre_lu = $request->input('nombre');
        $logro->estado_lu = 'Activo';
        $logro->save();
        return redirect()->route('listarlogros')->with('success', 'Logro Unido creado correctamente');
    }

    public function verlogro($id) {
        $logro = Logro::find($id);
        return response()->json($logro);
    }

    public function editarlogro($id) {
        $logro = Logro::find($id);
        return response()->json($logro);
    }

    public function actualizarlogro(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'estado' => 'required'
        ]);
        $logro = Logro::find($request->input('id'));
        $logro->codigo_lu = $request->input('codigo');
        $logro->nombre_lu = $request->input('nombre');
        $logro->estado_lu = $request->input('estado');
        $logro->save();
        return redirect()->route('listarlogros')->with('success', 'Logro Unido actualizado correctamente');
    }

    public function eliminarlogro($id) {
        $logro = Logro::find($id);
        if ($logro) {
            $logro->estado_lu = "Inactivo";
            $logro->save();
            return response()->json(['success' => true, 'message' => 'Logro Unido Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Logro Unido no encontrado']);
    }

    public function csvlogros(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_lu', 'nombre_lu', 'estado_lu'];

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
        $importar = new csvImportLogro;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todos los Logros Unidos ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevos Logros Unidos importados correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
