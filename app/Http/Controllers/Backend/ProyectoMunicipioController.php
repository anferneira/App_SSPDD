<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProyectoMunicipio;
use App\Models\LineaInversion;
use App\Models\ProyectoConvergencia;
use App\Models\Municipio;
use App\Imports\csvImportProMunicipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ProyectoMunicipioController extends Controller
{
    //
    public function listarpromuns() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $lineas = LineaInversion::orderBy('proyecto_li')->get();
            $municipios = Municipio::orderBy('nombre_m')->get();
            $proyecto_convergencias = ProyectoConvergencia::orderBy('codigo_pc')->get();
            $promuns = ProyectoMunicipio::orderBy('proyecto_pm')->get();
            return view('admin/promun.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'lineas', 'proyecto_convergencias', 'promuns', 'municipios'));
        }
        return Redirect::route('login');
    }

    public function guardarpromun(Request $request) {
        $promun = ProyectoMunicipio::where('proyecto_pm', $request->nombre)
                                    ->where('id_li', $request->id_li)
                                    ->where('id_pc', $request->id_pc)
                                    ->where('id_m', $request->id_m)->get();
        if ($promun->count() > 0)
            return redirect()->route('listarpromuns')->with('error', 'El Proyecto en el Municipio ya existe en el sistema.');
        $request->validate([
            'id_li' => 'required',
            'id_pc' => 'required',
            'id_m' => 'required',
            'nombre' => 'required'
        ]);
        $promun = new ProyectoMunicipio();
        $promun->id_li = $request->input('id_li');
        $promun->id_pc = $request->input('id_pc');
        $promun->id_m = $request->input('id_m');
        $promun->proyecto_pm = $request->input('nombre');
        $promun->estado_pm = 'Activo';
        $promun->save();
        return redirect()->route('listarpromuns')->with('success', 'Proyecto en el Municipio asignado correctamente');
    }

    public function verpromun($id) {
        $promun = ProyectoMunicipio::with(['linea_inversion', 'proyecto_convergencia', 'municipio'])->find($id);
        return response()->json($promun);
    }

    public function editarpromun($id) {
        $promun = ProyectoMunicipio::find($id);
        return response()->json($promun);
    }

    public function actualizarpromun(Request $request) {
        $request->validate([
            'id_li' => 'required',
            'id_pc' => 'required',
            'id_m' => 'required',
            'nombre' => 'required'
        ]);
        $promun = ProyectoMunicipio::find($request->id);
        $promun->id_li = $request->input('id_li');
        $promun->id_pc = $request->input('id_pc');
        $promun->id_m = $request->input('id_m');
        $promun->proyecto_pm = $request->input('nombre');
        $promun->estado_pm = $request->input('estado');
        $promun->save();
        return redirect()->route('listarpromuns')->with('success', 'Proyecto en el Municipio actualizado correctamente');
    }

    public function eliminarpromun($id) {
        $promun = ProyectoMunicipio::find($id);
        if ($promun) {
            $promun->estado_pm = "Inactivo";
            $promun->save();
            return response()->json(['success' => true, 'message' => 'Proyecto en el Municipio Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Proyecto en el Municipio no encontrado']);
    }

    public function csvpromuns(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['proyecto_pm', 'id_li', 'id_pc', 'id_m', 'estado_pm'];

        $encabezadosLeidos = array_map('trim', $headings[0][0]);
        sort($encabezadosLeidos);
        sort($encabezadosEsperados);
        //dd($encabezadosEsperados, $encabezadosLeidos);
        // Verificar si los encabezados coinciden
        // Comparamos si los encabezados obtenidos coinciden con los esperados
        if ($encabezadosLeidos !== $encabezadosEsperados) {
            return redirect()->back()->with('error', 'La estructura del archivo no es válida. Verifica los encabezados.');
        }

        // Continuar con la importación si todo está bien
        // Crear la instancia de la clase de importación
        $importar = new csvImportProMunicipio;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todos los Proyectos en los Municipios en las LineaInversions ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevos Proyectos en los Municipios importados correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}

