<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\DimensionPobreza;
use App\Models\VariablePobreza;
use App\Imports\csvImportVarPobreza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class VariablePobrezaController extends Controller
{
    //
    public function listarvarpobs() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $dimpobs = DimensionPobreza::orderBy('codigo_dp')->get();
            $varpobs = VariablePobreza::orderBy('nombre_vp')->get();
            return view('admin/varpob.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'dimpobs', 'varpobs'));
        }
        return Redirect::route('login');
    }

    public function guardarvarpob(Request $request) {
        $varpob = Variable_pobreza::where('codigo_vp', $request->codigo)->get();
        if ($dimension->count() > 0)
            return redirect()->route('listarvarpobs')->with('error', 'La Variable de Pobreza ya existe en el sistema.');
        $request->validate([
            'nombre' => 'required',
            'estado' => 'required',
            'id_dimension' => 'required|exists:dimension_pobrezas,id'
        ]);
        $varpob = new VariablePobreza();
        $varpob->nombre_vp = $request->input('nombre');
        $varpob->id_dp = $request->input('id_dimension');
        $varpob->estado_vp = 'Activo';
        $varpob->save();
        return redirect()->route('listarvarpobs')->with('success', 'Variable de Pobreza creada correctamente');
    }

    public function vervarpob($id) {
        $varpob = VariablePobreza::with('dimension')->find($id);
        return response()->json($varpob);
    }

    public function editarvarpob($id) {
        $varpob = VariablePobreza::find($id);
        return response()->json($varpob);
    }

    public function actualizarvarpob(Request $request) {
        $request->validate([
            'nombre' => 'required',
            'estado' => 'required',
            'id_dimension' => 'required|exists:dimension_pobrezas,id'
        ]);
        $varpob = VariablePobreza::find($request->input('id'));
        $varpob->nombre_vp = $request->input('nombre');
        $varpob->estado_vp = $request->input('estado');
        $varpob->id_dp = $request->input('id_dimension');
        $varpob->save();
        return redirect()->route('listarvarpobs')->with('success', 'Variable de Pobreza actualizada correctamente');
    }

    public function eliminarvarpob($id) {
        $varpob = VariablePobreza::find($id);
        if ($varpob) {
            $varpob->estado_vp = "Inactivo";
            $varpob->save();
            return response()->json(['success' => true, 'message' => 'Variable de Pobreza Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Variable de Pobreza no encontrada']);
    }

    public function csvvarpobs(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['nombre_vp', 'id_dp', 'estado_vp'];

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
        $importar = new csvImportVarPobreza;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Variables de Pobreza ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Variables de Pobreza importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
