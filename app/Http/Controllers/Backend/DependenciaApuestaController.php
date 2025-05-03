<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DependenciaApuesta;
use App\Models\Dependencia;
use App\Models\Apuesta;
use App\Imports\csvImportDepApuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class DependenciaApuestaController extends Controller
{
    //
    public function listardepapus() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $dependencias = Dependencia::orderBy('nombre_d')->get();
            $apuestas = Apuesta::orderBy('codigo_a')->get();
            $depapus = DependenciaApuesta::orderBy('id_dep')->get();
            return view('admin/depapu.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'dependencias', 'apuestas', 'depapus'));
        }
        return Redirect::route('login');
    }

    public function guardardepapu(Request $request) {
        $depapu = DependenciaApuesta::where('id_d', $request->id_d)
                            ->where('id_e', $request->id_depapu)->get();
        if ($depapu->count() > 0)
            return redirect()->route('listardepapus')->with('error', 'La Apuesta en la Dependencia ya existe en el sistema.');
        $request->validate([
            'id_d' => 'required',
            'id_apuesta' => 'required'
        ]);
        $depapu = new DependenciaApuesta();
        $depapu->id_dep = $request->input('id_d');
        $depapu->id_apu = $request->input('id_apuesta');
        $depapu->estado_da = 'Activo';
        $depapu->save();
        return redirect()->route('listardepapus')->with('success', 'Apuesta en Dependencia asignada correctamente');
    }

    public function verdepapu($id) {
        $depapu = DependenciaApuesta::with(['dependenciasss', 'apuestas'])->find($id);
        return response()->json($depapu);
    }

    public function editardepapu($id) {
        $depapu = DependenciaApuesta::find($id);
        return response()->json($depapu);
    }

    public function actualizardepapu(Request $request) {
        $request->validate([
            'id_d' => 'required',
            'id_apuesta' => 'required',
            'estado' => 'required'
        ]);
        $depapu = DependenciaApuesta::find($request->input('id'));
        $depapu->id_dep = $request->input('id_d');
        $depapu->id_apu = $request->input('id_apuesta');
        $depapu->estado_da = $request->input('estado');
        $depapu->save();
        return redirect()->route('listardepapus')->with('success', 'Apuesta en Dependencia actualizada correctamente');
    }

    public function eliminardepapu($id) {
        $depapu = DependenciaApuesta::find($id);
        if ($depapu) {
            $depapu->estado_da = "Inactivo";
            $depapu->save();
            return response()->json(['success' => true, 'message' => 'Apuesta en Dependencia Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Apuesta en Dependencia no encontrada']);
    }

    public function csvdepapus(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['id_dep', 'id_apu', 'estado_da'];

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
        $importar = new csvImportDepApuesta;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Apuestas en las Dependencias ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Apuestas importadas correctamente a las Dependencias y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
