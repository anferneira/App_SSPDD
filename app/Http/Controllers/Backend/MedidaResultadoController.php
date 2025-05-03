<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MedidaResultado;
use App\Imports\csvImportMedResultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class MedidaResultadoController extends Controller
{
    //
    public function listarmedress() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $medress = MedidaResultado::orderBy('nombre_mr')->get();
            return view('admin/medres.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'medress'));
        }
        return Redirect::route('login');
    }

    public function guardarmedres(Request $request) {
        $medres = MedidaResultado::where('nombre_mr', $request->nombre)->get();
        if ($medres->count() > 0)
            return redirect()->route('listarmedress')->with('error', 'La Medida de Resultado ya existe en el sistema.');
        $request->validate([
            'nombre' => 'required',
            'estado' => 'required'
        ]);
        $medres = new MedidaResultado();
        $medres->nombre_mr = $request->input('nombre');
        $medres->estado_mr = 'Activo';
        $medres->save();
        return redirect()->route('listarmedress')->with('success', 'Medida de Resultado creada correctamente');
    }

    public function vermedres($id) {
        $medres = MedidaResultado::find($id);
        return response()->json($medres);
    }

    public function editarmedres($id) {
        $medres = MedidaResultado::find($id);
        return response()->json($medres);
    }

    public function actualizarmedres(Request $request) {
        $request->validate([
            'nombre' => 'required',
            'estado' => 'required'
        ]);
        $medres = MedidaResultado::find($request->input('id'));
        $medres->nombre_mr = $request->input('nombre');
        $medres->estado_mr = $request->input('estado');
        $medres->save();
        return redirect()->route('listarmedress')->with('success', 'Medida de Resultado actualizada correctamente');
    }

    public function eliminarmedres($id) {
        $medres = MedidaResultado::find($id);
        if ($medres) {
            $medres->estado_mr = "Inactivo";
            $medres->save();
            return response()->json(['success' => true, 'message' => 'Medida de Resultado Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Medida de Resultado no encontrada']);
    }

    public function csvmedress(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['nombre_mr', 'estado_mr'];

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
        $importar = new csvImportMedResultado;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Medidas de Resultado ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Medidas de Resultado importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
