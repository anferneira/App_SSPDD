<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\MetaOds;
use App\Models\Ods;
use App\Imports\csvImportMetaOds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class MetaOdsController extends Controller
{
    //
    public function listarmetasodss() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_d;
            $odss = Ods::orderBy('codigo_ods')->get();
            $metasods = MetaOds::orderBy('codigo_mo')->get();
            return view('admin/metaods.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'odss', 'metasods'));
        }
        return Redirect::route('login');
    }

    public function guardarmetaods(Request $request) {
        $metaods = MetaOds::where('codigo_mo', $request->codigo)->get();
        if ($metaods->count() > 0)
            return redirect()->route('listarmetasodss')->with('error', 'La meta Ods ya existe en el sistema.');
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'id_ods' => 'required|exists:ods,id'
        ]);
        $metaods = new MetaOds();
        $metaods->codigo_mo = $request->input('codigo');
        $metaods->nombre_mo = $request->input('nombre');
        $metaods->id_ods = $request->input('id_ods');
        $metaods->estado_mo = 'Activo';
        $metaods->save();
        return redirect()->route('listarmetasodss')->with('success', 'Meta Ods creada correctamente');
    }

    public function vermetaods($id) {
        $metaods = Metaods::with('ods')->find($id);
        return response()->json($metaods);
    }

    public function editarmetaods($id) {
        $metaods = MetaOds::find($id);
        return response()->json($metaods);
    }

    public function actualizarmetaods(Request $request) {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'estado' => 'required',
            'id_ods' => 'required|exists:ods,id'
        ]);
        $metaods = MetaOds::find($request->input('id'));
        $metaods->codigo_mo = $request->input('codigo');
        $metaods->nombre_mo = $request->input('nombre');
        $metaods->id_ods = $request->input('id_ods');
        $metaods->estado_mo = $request->input('estado');;
        $metaods->save();
        return redirect()->route('listarmetasodss')->with('success', 'Meta Ods actualizada correctamente');
    }

    public function eliminarmetaods($id) {
        $metaods = MetaOds::find($id);
        if ($metaods) {
            $metaods->estado_mo = "Inactivo";
            $metaods->save();
            return response()->json(['success' => true, 'message' => 'Meta Ods Inactiva']);
        }
        return response()->json(['error' => true, 'message' => 'Meta Ods no encontrada']);
    }

    public function csvmetasodss(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['codigo_mo', 'nombre_mo', 'id_ods', 'estado_mo'];
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
        $importar = new csvImportMetaOds;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Metas Ods ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Metas Ods importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
