<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DependenciaDimension;
use App\Models\Dependencia;
use App\Models\Dimension;
use App\Imports\csvImportDepDimension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class DependenciaDimensionController extends Controller
{
    //
    public function listardepdims() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $dependencias = Dependencia::orderBy('nombre_d')->get();
            $dimensiones = Dimension::orderBy('codigo_d')->get();
            $depdims = DependenciaDimension::orderBy('id_dep')->get();
            return view('admin/depdim.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'dependencias', 'dimensiones', 'depdims'));
        }
        return Redirect::route('login');
    }

    public function guardardepdim(Request $request) {
        $depdim = DependenciaDimension::where('id_d', $request->id_d)
                            ->where('id_e', $request->id_depdim)->get();
        if ($depdim->count() > 0)
            return redirect()->route('listardepdims')->with('error', 'La Dimension en la Dependencia ya existe en el sistema.');
        $request->validate([
            'id_d' => 'required',
            'id_depdim' => 'required'
        ]);
        $depdim = new DependenciaDimension();
        $depdim->id_dep = $request->input('id_d');
        $depdim->id_dim = $request->input('id_dimension');
        $depdim->estado_dd = 'Activo';
        $depdim->save();
        return redirect()->route('listardepdims')->with('success', 'Dimension en Dependencia asignada correctamente');
    }

    public function verdepdim($id) {
        $depdim = DependenciaDimension::with(['dependenciass', 'dimensiones'])->find($id);
        return response()->json($depdim);
    }

    public function editardepdim($id) {
        $depdim = DependenciaDimension::find($id);
        return response()->json($depdim);
    }

    public function actualizardepdim(Request $request) {
        $request->validate([
            'id_d' => 'required',
            'id_dimension' => 'required',
            'estado' => 'required'
        ]);
        $depdim = DependenciaDimension::find($request->input('id'));
        $depdim->id_dep = $request->input('id_d');
        $depdim->id_dim = $request->input('id_dimension');
        $depdim->estado_dd = $request->input('estado');
        $depdim->save();
        return redirect()->route('listardepdims')->with('success', 'Dimension en Dependencia actualizada correctamente');
    }

    public function eliminardepdim($id) {
        $depdim = DependenciaDimension::find($id);
        if ($depdim) {
            $depdim->estado_dd = "Inactivo";
            $depdim->save();
            return response()->json(['success' => true, 'message' => 'Dimension en Dependencia Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Dimension en Dependencia no encontrada']);
    }

    public function csvdepdims(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['id_dep', 'id_dim', 'estado_dd'];

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
        $importar = new csvImportDepDimension;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Dimensiones en las Dependencias ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Dimensiones importadas correctamente a las Dependencias y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
