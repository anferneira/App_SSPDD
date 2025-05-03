<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DependenciaEstrategia;
use App\Models\Dependencia;
use App\Models\Estrategia;
use App\Imports\csvImportDepEstrategia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class DependenciaEstrategiaController extends Controller
{
    //
    public function listardepests() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $dependencias = Dependencia::orderBy('nombre_d')->get();
            $estrategias = Estrategia::orderBy('codigo_e')->get();
            $depests = DependenciaEstrategia::orderBy('id_d')->get();
            return view('admin/depest.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'dependencias', 'estrategias', 'depests'));
        }
        return Redirect::route('login');
    }

    public function guardardepest(Request $request) {
        $depest = DependenciaEstrategia::where('id_d', $request->id_d)
                            ->where('id_e', $request->id_depest)->get();
        if ($depest->count() > 0)
            return redirect()->route('listardepests')->with('error', 'La Estrategia en la Dependencia ya existe en el sistema.');
        $request->validate([
            'id_d' => 'required',
            'id_depest' => 'required'
        ]);
        $depest = new DependenciaEstrategia();
        $depest->id_d = $request->input('id_d');
        $depest->id_e = $request->input('id_estrategia');
        $depest->estado_de = 'Activo';
        $depest->save();
        return redirect()->route('listardepests')->with('success', 'Estrategia en Dependencia asignada correctamente');
    }

    public function verdepest($id) {
        $depest = DependenciaEstrategia::with(['dependencias', 'estrategias'])->find($id);
        return response()->json($depest);
    }

    public function editardepest($id) {
        $depest = DependenciaEstrategia::find($id);
        return response()->json($depest);
    }

    public function actualizardepest(Request $request) {
        $request->validate([
            'id_d' => 'required',
            'id_estrategia' => 'required',
            'estado' => 'required'
        ]);
        $depest = DependenciaEstrategia::find($request->input('id'));
        $depest->id_d = $request->input('id_d');
        $depest->id_e = $request->input('id_estrategia');
        $depest->estado_de = $request->input('estado');
        $depest->save();
        return redirect()->route('listardepests')->with('success', 'Estrategia en Dependencia actualizada correctamente');
    }

    public function eliminardepest($id) {
        $depest = DependenciaEstrategia::find($id);
        if ($depest) {
            $depest->estado_de = "Inactivo";
            $depest->save();
            return response()->json(['success' => true, 'message' => 'Estrategia en Dependencia Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Estrategia en Dependencia no encontrada']);
    }

    public function csvdepests(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['id_d', 'id_e', 'estado_de'];

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
        $importar = new csvImportDepEstrategia;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Estrategias en las Dependencias ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Estrategias importadas correctamente a las Dependencias y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
