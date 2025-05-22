<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProgramarEstrategico;
use App\Models\IndicadorProducto;
use App\Imports\csvImportProEst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ProgramarEstrategicoController extends Controller
{
    //
    public function listarproests() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_dependencia;
            $ips = IndicadorProducto::selectRaw('MIN(id) as id, codigo_ip')
                                        ->groupBy('codigo_ip')
                                        ->get();
            $proests = ProgramarEstrategico::orderBy('id_ip')->get()
                                                ->unique('id_ip');
            //return response()->json($proests);
            return view('admin/proest.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'ips', 'proests'));
        }
        return Redirect::route('login');
    }

    public function guardarproest(Request $request) {
        $proest = ProgramarEstrategico::where('id_ip', $request->id_ip)->get();
        if ($proest->count() > 0)
            return redirect()->route('listarproests')->with('error', 'La Programación Estratégica ya existe en el sistema.');
        $request->validate([
            '2024_3' => 'required',
            '2024_4' => 'required',
            '2025_1' => 'required',
            '2025_2' => 'required',
            '2025_3' => 'required',
            '2025_4' => 'required',
            '2026_1' => 'required',
            '2026_2' => 'required',
            '2026_3' => 'required',
            '2026_4' => 'required',
            '2027_1' => 'required',
            '2027_2' => 'required',
            '2027_3' => 'required',
            '2027_4' => 'required',
            'calculo' => 'required',
            'id_ip' => 'required|exists:indicador_productos,id'
        ]);
        $proest = new ProgramarEstrategico();
        $proest->p2024_3 = $request->input('2024_3');
        $proest->p2024_4 = $request->input('2024_4');
        $proest->p2025_1 = $request->input('2025_1');
        $proest->p2025_2 = $request->input('2025_2');
        $proest->p2025_3 = $request->input('2025_3');
        $proest->p2025_4 = $request->input('2025_4');
        $proest->p2026_1 = $request->input('2026_1');
        $proest->p2026_2 = $request->input('2026_2');
        $proest->p2026_3 = $request->input('2026_3');
        $proest->p2026_4 = $request->input('2026_4');
        $proest->p2027_1 = $request->input('2027_1');
        $proest->p2027_2 = $request->input('2027_2');
        $proest->p2027_3 = $request->input('2027_3');
        $proest->p2027_4 = $request->input('2027_4');
        $proest->id_ip = $request->input('id_ip');
        $proest->calculo = $request->input('calculo');
        $proest->estado_pe = 'Activo';
        $proest->save();
        return redirect()->route('listarproests')->with('success', 'Programación Estratégica creada correctamente');
    }

    public function verproest($id) {
        $proest = ProgramarEstrategico::with('indproducto')->find($id);
        return response()->json($proest);
    }

    public function editarproest($id) {
        $proest = ProgramarEstrategico::find($id);
        return response()->json($proest);
    }

    public function actualizarproest(Request $request) {
        //return response()->json($request);
        $request->validate([    
            'estado' => 'required',
            '2024_3' => 'required',
            '2024_4' => 'required',
            '2025_1' => 'required',
            '2025_2' => 'required',
            '2025_3' => 'required',
            '2025_4' => 'required',
            '2026_1' => 'required',
            '2026_2' => 'required',
            '2026_3' => 'required',
            '2026_4' => 'required',
            '2027_1' => 'required',
            '2027_2' => 'required',
            '2027_3' => 'required',
            '2027_4' => 'required',
            'calculo' => 'required',
            'id_ip' => 'required|exists:indicador_productos,id'
        ]);
        //return response()->json($request);
        $proest = ProgramarEstrategico::find($request->input('id'));
        $proest->p2024_3 = $request->input('2024_3');
        $proest->p2024_4 = $request->input('2024_4');
        $proest->p2025_1 = $request->input('2025_1');
        $proest->p2025_2 = $request->input('2025_2');
        $proest->p2025_3 = $request->input('2025_3');
        $proest->p2025_4 = $request->input('2025_4');
        $proest->p2026_1 = $request->input('2026_1');
        $proest->p2026_2 = $request->input('2026_2');
        $proest->p2026_3 = $request->input('2026_3');
        $proest->p2026_4 = $request->input('2026_4');
        $proest->p2027_1 = $request->input('2027_1');
        $proest->p2027_2 = $request->input('2027_2');
        $proest->p2027_3 = $request->input('2027_3');
        $proest->p2027_4 = $request->input('2027_4');
        $proest->id_ip = $request->input('id_ip');
        $proest->calculo = $request->input('calculo');
        $proest->estado_pe = $request->input('estado');
        $proest->save();
        return redirect()->route('listarproests')->with('success', 'Programación Estratégica actualizada correctamente');
    }

    public function eliminarproest($id) {
        $proest = ProgramarEstrategico::find($id);
        if ($proest) {
            $proest->estado_pe = "Inactivo";
            $proest->save();
            return response()->json(['success' => true, 'message' => 'Programación Estratégica Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Programación Estratégica no encontrada']);
    }

    public function csvproests(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['id_ip', 'p2024_3', 'p2024_4', 'p2025_1', 'p2025_2', 'p2025_3', 'p2025_4', 
                                'p2026_1', 'p2026_2', 'p2026_3', 'p2026_4', 'p2027_1', 'p2027_2', 'p2027_3', 'p2027_4',
                                'calculo', 'estado_pe'];

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
        $importar = new csvImportProEst;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Programaciones Estratégicas ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Programaciones Estratégicas importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
