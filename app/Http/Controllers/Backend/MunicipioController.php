<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Municipio;
use App\Models\Provincia;
use App\Imports\csvImportMunicipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class MunicipioController extends Controller
{
    //
    public function listarmunicipios() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_dependencia;
            $provincias = Provincia::orderBy('nombre_p')->get();
            $municipios = Municipio::orderBy('nombre_m')->get();
            return view('admin/municipio.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'provincias', 'municipios'));
        }
        return Redirect::route('login');
    }

    public function guardarmunicipio(Request $request) {
        $municipio = Municipio::where('codigo_m', $request->codigo)->get();
        if ($municipio->count() > 0)
            return redirect()->route('listarmunicipios')->with('error', 'El Municipio ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'longitud' => 'required',
            'latitud' => 'required',
            'estado' => 'required',
            'id_p' => 'required|exists:provincias,id'
        ]);
        $municipio = new Municipio();
        $municipio->codigo_m = $request->input('codigo');
        $municipio->nombre_m = $request->input('nombre');
        $municipio->latitud_m = $request->input('latitud');
        $municipio->longitud_m = $request->input('longitud');
        $municipio->id_p_m = $request->input('id_p');
        $municipio->estado_m = 'Activo';
        $municipio->save();
        return redirect()->route('listarmunicipios')->with('success', 'Municipio creado correctamente');
    }

    public function vermunicipio($id) {
        $municipio = Municipio::with('provincia')->find($id);
        return response()->json($municipio);
    }

    public function editarmunicipio($id) {
        $municipio = Municipio::find($id);
        return response()->json($municipio);
    }

    public function actualizarmunicipio(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'longitud' => 'required',
            'latitud' => 'required',
            'estado' => 'required',
            'id_p' => 'required|exists:provincias,id'
        ]);
        $municipio = Municipio::find($request->input('id'));
        $municipio->codigo_m = $request->input('codigo');
        $municipio->nombre_m = $request->input('nombre');
        $municipio->latitud_m = $request->input('latitud');
        $municipio->longitud_m = $request->input('longitud');
        $municipio->id_p = $request->input('id_p');
        $municipio->estado_m = $request->input('estado');;
        $municipio->save();
        return redirect()->route('listarmunicipios')->with('success', 'Municipio actualizado correctamente');
    }

    public function eliminarmunicipio($id) {
        $municipio = Municipio::find($id);
        if ($municipio) {
            $municipio->estado_m = "Inactivo";
            $municipio->save();
            return response()->json(['success' => true, 'message' => 'Municipio Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Municipio no encontrado']);
    }

    public function csvmunicipios(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_m', 'nombre_m', 'latitud_m', 'longitud_m', 'id_p', 'estado_m'];

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
        $importar = new csvImportMunicipio;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todos los Municipios ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevos Municipios importados correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
