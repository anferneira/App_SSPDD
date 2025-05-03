<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProgramarFinanciero;
use App\Models\IndicadorProducto;
use App\Imports\csvImportProFin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ProgramarFinancieroController extends Controller
{
    //
    public function listarprofins() {
        if (Auth::check()){
            $usuario = Auth::user();
            $nombre = $usuario->name;
            $rol = $usuario->rol->nombre_r;
            $dependencia = $usuario->dependencia->nombre_dependencia;
            $ips = IndicadorProducto::orderBy('codigo_ip')->get();
            $profins = ProgramarFinanciero::orderBy('id_ip')->get()
                                                ->unique('id_ip');
            return view('admin/profin.index', compact('usuario', 'nombre', 'rol', 'dependencia', 'ips', 'profins'));
        }
        return Redirect::route('login');
    }

    public function guardarprofin(Request $request) {
        $profin = ProgramarFinanciero::where('id_ip', $request->id_ip)->get();
        if ($profin->count() > 0)
            return redirect()->route('listarprofins')->with('error', 'La Programación Financiera ya existe en el sistema.');
        $request->validate([
            'ICLD_2024_3' => 'required',
            'ICDE_2024_3' => 'required',
            'SGPE_2024_3' => 'required',
            'SGPS_2024_3' => 'required',
            'SGPAPSB_2024_3' => 'required',
            'RPED_2024_3' => 'required',
            'SGR_2024_3' => 'required',
            'CR_2024_3' => 'required',
            'G_2024_3' => 'required',
            'CO_2024_3' => 'required',
            'OR_2024_3' => 'required',
            'ICLD_2024_4' => 'required',
            'ICDE_2024_4' => 'required',
            'SGPE_2024_4' => 'required',
            'SGPS_2024_4' => 'required',
            'SGPAPSB_2024_4' => 'required',
            'RPED_2024_4' => 'required',
            'SGR_2024_4' => 'required',
            'CR_2024_4' => 'required',
            'G_2024_4' => 'required',
            'CO_2024_4' => 'required',
            'OR_2024_4' => 'required',
            'ICLD_2025_1' => 'required',
            'ICDE_2025_1' => 'required',
            'SGPE_2025_1' => 'required',
            'SGPS_2025_1' => 'required',
            'SGPAPSB_2025_1' => 'required',
            'RPED_2025_1' => 'required',
            'SGR_2025_1' => 'required',
            'CR_2025_1' => 'required',
            'G_2025_1' => 'required',
            'CO_2025_1' => 'required',
            'OR_2025_1' => 'required',
            'ICLD_2025_2' => 'required',
            'ICDE_2025_2' => 'required',
            'SGPE_2025_2' => 'required',
            'SGPS_2025_2' => 'required',
            'SGPAPSB_2025_2' => 'required',
            'RPED_2025_2' => 'required',
            'SGR_2025_2' => 'required',
            'CR_2025_2' => 'required',
            'G_2025_2' => 'required',
            'CO_2025_2' => 'required',
            'OR_2025_2' => 'required',
            'ICLD_2025_3' => 'required',
            'ICDE_2025_3' => 'required',
            'SGPE_2025_3' => 'required',
            'SGPS_2025_3' => 'required',
            'SGPAPSB_2025_3' => 'required',
            'RPED_2025_3' => 'required',
            'SGR_2025_3' => 'required',
            'CR_2025_3' => 'required',
            'G_2025_3' => 'required',
            'CO_2025_3' => 'required',
            'OR_2025_3' => 'required',
            'ICLD_2025_4' => 'required',
            'ICDE_2025_4' => 'required',
            'SGPE_2025_4' => 'required',
            'SGPS_2025_4' => 'required',
            'SGPAPSB_2025_4' => 'required',
            'RPED_2025_4' => 'required',
            'SGR_2025_4' => 'required',
            'CR_2025_4' => 'required',
            'G_2025_4' => 'required',
            'CO_2025_4' => 'required',
            'OR_2025_4' => 'required',
            'ICLD_2026_1' => 'required',
            'ICDE_2026_1' => 'required',
            'SGPE_2026_1' => 'required',
            'SGPS_2026_1' => 'required',
            'SGPAPSB_2026_1' => 'required',
            'RPED_2026_1' => 'required',
            'SGR_2026_1' => 'required',
            'CR_2026_1' => 'required',
            'G_2026_1' => 'required',
            'CO_2026_1' => 'required',
            'OR_2026_1' => 'required',
            'ICLD_2026_2' => 'required',
            'ICDE_2026_2' => 'required',
            'SGPE_2026_2' => 'required',
            'SGPS_2026_2' => 'required',
            'SGPAPSB_2026_2' => 'required',
            'RPED_2026_2' => 'required',
            'SGR_2026_2' => 'required',
            'CR_2026_2' => 'required',
            'G_2026_2' => 'required',
            'CO_2026_2' => 'required',
            'OR_2026_2' => 'required',
            'ICLD_2026_3' => 'required',
            'ICDE_2026_3' => 'required',
            'SGPE_2026_3' => 'required',
            'SGPS_2026_3' => 'required',
            'SGPAPSB_2026_3' => 'required',
            'RPED_2026_3' => 'required',
            'SGR_2026_3' => 'required',
            'CR_2026_3' => 'required',
            'G_2026_3' => 'required',
            'CO_2026_3' => 'required',
            'OR_2026_3' => 'required',
            'ICLD_2026_4' => 'required',
            'ICDE_2026_4' => 'required',
            'SGPE_2026_4' => 'required',
            'SGPS_2026_4' => 'required',
            'SGPAPSB_2026_4' => 'required',
            'RPED_2026_4' => 'required',
            'SGR_2026_4' => 'required',
            'CR_2026_4' => 'required',
            'G_2026_4' => 'required',
            'CO_2026_4' => 'required',
            'OR_2026_4' => 'required',
            'ICLD_2027_1' => 'required',
            'ICDE_2027_1' => 'required',
            'SGPE_2027_1' => 'required',
            'SGPS_2027_1' => 'required',
            'SGPAPSB_2027_1' => 'required',
            'RPED_2027_1' => 'required',
            'SGR_2027_1' => 'required',
            'CR_2027_1' => 'required',
            'G_2027_1' => 'required',
            'CO_2027_1' => 'required',
            'OR_2027_1' => 'required',
            'ICLD_2027_2' => 'required',
            'ICDE_2027_2' => 'required',
            'SGPE_2027_2' => 'required',
            'SGPS_2027_2' => 'required',
            'SGPAPSB_2027_2' => 'required',
            'RPED_2027_2' => 'required',
            'SGR_2027_2' => 'required',
            'CR_2027_2' => 'required',
            'G_2027_2' => 'required',
            'CO_2027_2' => 'required',
            'OR_2027_2' => 'required',
            'ICLD_2027_3' => 'required',
            'ICDE_2027_3' => 'required',
            'SGPE_2027_3' => 'required',
            'SGPS_2027_3' => 'required',
            'SGPAPSB_2027_3' => 'required',
            'RPED_2027_3' => 'required',
            'SGR_2027_3' => 'required',
            'CR_2027_3' => 'required',
            'G_2027_3' => 'required',
            'CO_2027_3' => 'required',
            'OR_2027_3' => 'required',
            'ICLD_2027_4' => 'required',
            'ICDE_2027_4' => 'required',
            'SGPE_2027_4' => 'required',
            'SGPS_2027_4' => 'required',
            'SGPAPSB_2027_4' => 'required',
            'RPED_2027_4' => 'required',
            'SGR_2027_4' => 'required',
            'CR_2027_4' => 'required',
            'G_2027_4' => 'required',
            'CO_2027_4' => 'required',
            'OR_2027_4' => 'required',
            'id_ip' => 'required|exists:indicador_productos,id'
        ]);
        $profin = new ProgramarFinanciero();
        $profin->ICDL_2024_3 = $request->input('ICDL_2024_3');
        $profin->ICDE_2024_3 = $request->input('ICDE_2024_3');
        $profin->SGPE_2024_3 = $request->input('SGPE_2024_3');
        $profin->SGPS_2024_3 = $request->input('SGPS_2024_3');
        $profin->SGPAPSB_2024_3 = $request->input('SGPAPSB_2024_3');
        $profin->RPED_2024_3 = $request->input('RPED_2024_3');
        $profin->SGR_2024_3 = $request->input('SGR_2024_3');
        $profin->CR_2024_3 = $request->input('CR_2024_3');
        $profin->G_2024_3 = $request->input('G_2024_3');
        $profin->CO_2024_3 = $request->input('CO_2024_3');
        $profin->OR_2024_3 = $request->input('OR_2024_3');
        $profin->ICDL_2024_4 = $request->input('ICDL_2024_4');
        $profin->ICDE_2024_4 = $request->input('ICDE_2024_4');
        $profin->SGPE_2024_4 = $request->input('SGPE_2024_4');
        $profin->SGPS_2024_4 = $request->input('SGPS_2024_4');
        $profin->SGPAPSB_2024_4 = $request->input('SGPAPSB_2024_4');
        $profin->RPED_2024_4 = $request->input('RPED_2024_4');
        $profin->SGR_2024_4 = $request->input('SGR_2024_4');
        $profin->CR_2024_4 = $request->input('CR_2024_4');
        $profin->G_2024_4 = $request->input('G_2024_4');
        $profin->CO_2024_4 = $request->input('CO_2024_4');
        $profin->OR_2024_4 = $request->input('OR_2024_4');
        $profin->ICDL_2025_1 = $request->input('ICDL_2025_1');
        $profin->ICDE_2025_1 = $request->input('ICDE_2025_1');
        $profin->SGPE_2025_1 = $request->input('SGPE_2025_1');
        $profin->SGPS_2025_1 = $request->input('SGPS_2025_1');
        $profin->SGPAPSB_2025_1 = $request->input('SGPAPSB_2025_1');
        $profin->RPED_2025_1 = $request->input('RPED_2025_1');
        $profin->SGR_2025_1 = $request->input('SGR_2025_1');
        $profin->CR_2025_1 = $request->input('CR_2025_1');
        $profin->G_2025_1 = $request->input('G_2025_1');
        $profin->CO_2025_1 = $request->input('CO_2025_1');
        $profin->OR_2025_1 = $request->input('OR_2025_1');
        $profin->ICDL_2025_2 = $request->input('ICDL_2025_2');
        $profin->ICDE_2025_2 = $request->input('ICDE_2025_2');
        $profin->SGPE_2025_2 = $request->input('SGPE_2025_2');
        $profin->SGPS_2025_2 = $request->input('SGPS_2025_2');
        $profin->SGPAPSB_2025_2 = $request->input('SGPAPSB_2025_2');
        $profin->RPED_2025_2 = $request->input('RPED_2025_2');
        $profin->SGR_2025_2 = $request->input('SGR_2025_2');
        $profin->CR_2025_2 = $request->input('CR_2025_2');
        $profin->G_2025_2 = $request->input('G_2025_2');
        $profin->CO_2025_2 = $request->input('CO_2025_2');
        $profin->OR_2025_2 = $request->input('OR_2025_2');
        $profin->ICDL_2025_3 = $request->input('ICDL_2025_3');
        $profin->ICDE_2025_3 = $request->input('ICDE_2025_3');
        $profin->SGPE_2025_3 = $request->input('SGPE_2025_3');
        $profin->SGPS_2025_3 = $request->input('SGPS_2025_3');
        $profin->SGPAPSB_2025_3 = $request->input('SGPAPSB_2025_3');
        $profin->RPED_2025_3 = $request->input('RPED_2025_3');
        $profin->SGR_2025_3 = $request->input('SGR_2025_3');
        $profin->CR_2025_3 = $request->input('CR_2025_3');
        $profin->G_2025_3 = $request->input('G_2025_3');
        $profin->CO_2025_3 = $request->input('CO_2025_3');
        $profin->OR_2025_3 = $request->input('OR_2025_3');
        $profin->ICDL_2025_4 = $request->input('ICDL_2025_4');
        $profin->ICDE_2025_4 = $request->input('ICDE_2025_4');
        $profin->SGPE_2025_4 = $request->input('SGPE_2025_4');
        $profin->SGPS_2025_4 = $request->input('SGPS_2025_4');
        $profin->SGPAPSB_2025_4 = $request->input('SGPAPSB_2025_4');
        $profin->RPED_2025_4 = $request->input('RPED_2025_4');
        $profin->SGR_2025_4 = $request->input('SGR_2025_4');
        $profin->CR_2025_4 = $request->input('CR_2025_4');
        $profin->G_2025_4 = $request->input('G_2025_4');
        $profin->CO_2025_4 = $request->input('CO_2025_4');
        $profin->OR_2025_4 = $request->input('OR_2025_4');
        $profin->ICDL_2026_1 = $request->input('ICDL_2026_1');
        $profin->ICDE_2026_1 = $request->input('ICDE_2026_1');
        $profin->SGPE_2026_1 = $request->input('SGPE_2026_1');
        $profin->SGPS_2026_1 = $request->input('SGPS_2026_1');
        $profin->SGPAPSB_2026_1 = $request->input('SGPAPSB_2026_1');
        $profin->RPED_2026_1 = $request->input('RPED_2026_1');
        $profin->SGR_2026_1 = $request->input('SGR_2026_1');
        $profin->CR_2026_1 = $request->input('CR_2026_1');
        $profin->G_2026_1 = $request->input('G_2026_1');
        $profin->CO_2026_1 = $request->input('CO_2026_1');
        $profin->OR_2026_1 = $request->input('OR_2026_1');
        $profin->ICDL_2026_2 = $request->input('ICDL_2026_2');
        $profin->ICDE_2026_2 = $request->input('ICDE_2026_2');
        $profin->SGPE_2026_2 = $request->input('SGPE_2026_2');
        $profin->SGPS_2026_2 = $request->input('SGPS_2026_2');
        $profin->SGPAPSB_2026_2 = $request->input('SGPAPSB_2026_2');
        $profin->RPED_2026_2 = $request->input('RPED_2026_2');
        $profin->SGR_2026_2 = $request->input('SGR_2026_2');
        $profin->CR_2026_2 = $request->input('CR_2026_2');
        $profin->G_2026_2 = $request->input('G_2026_2');
        $profin->CO_2026_2 = $request->input('CO_2026_2');
        $profin->OR_2026_2 = $request->input('OR_2026_2');
        $profin->ICDL_2026_3 = $request->input('ICDL_2026_3');
        $profin->ICDE_2026_3 = $request->input('ICDE_2026_3');
        $profin->SGPE_2026_3 = $request->input('SGPE_2026_3');
        $profin->SGPS_2026_3 = $request->input('SGPS_2026_3');
        $profin->SGPAPSB_2026_3 = $request->input('SGPAPSB_2026_3');
        $profin->RPED_2026_3 = $request->input('RPED_2026_3');
        $profin->SGR_2026_3 = $request->input('SGR_2026_3');
        $profin->CR_2026_3 = $request->input('CR_2026_3');
        $profin->G_2026_3 = $request->input('G_2026_3');
        $profin->CO_2026_3 = $request->input('CO_2026_3');
        $profin->OR_2026_3 = $request->input('OR_2026_3');
        $profin->ICDL_2026_4 = $request->input('ICDL_2026_4');
        $profin->ICDE_2026_4 = $request->input('ICDE_2026_4');
        $profin->SGPE_2026_4 = $request->input('SGPE_2026_4');
        $profin->SGPS_2026_4 = $request->input('SGPS_2026_4');
        $profin->SGPAPSB_2026_4 = $request->input('SGPAPSB_2026_4');
        $profin->RPED_2026_4 = $request->input('RPED_2026_4');
        $profin->SGR_2026_4 = $request->input('SGR_2026_4');
        $profin->CR_2026_4 = $request->input('CR_2026_4');
        $profin->G_2026_4 = $request->input('G_2026_4');
        $profin->CO_2026_4 = $request->input('CO_2026_4');
        $profin->OR_2026_4 = $request->input('OR_2026_4');
        $profin->ICDL_2027_1 = $request->input('ICDL_2027_1');
        $profin->ICDE_2027_1 = $request->input('ICDE_2027_1');
        $profin->SGPE_2027_1 = $request->input('SGPE_2027_1');
        $profin->SGPS_2027_1 = $request->input('SGPS_2027_1');
        $profin->SGPAPSB_2027_1 = $request->input('SGPAPSB_2027_1');
        $profin->RPED_2027_1 = $request->input('RPED_2027_1');
        $profin->SGR_2027_1 = $request->input('SGR_2027_1');
        $profin->CR_2027_1 = $request->input('CR_2027_1');
        $profin->G_2027_1 = $request->input('G_2027_1');
        $profin->CO_2027_1 = $request->input('CO_2027_1');
        $profin->OR_2027_1 = $request->input('OR_2027_1');
        $profin->ICDL_2027_2 = $request->input('ICDL_2027_2');
        $profin->ICDE_2027_2 = $request->input('ICDE_2027_2');
        $profin->SGPE_2027_2 = $request->input('SGPE_2027_2');
        $profin->SGPS_2027_2 = $request->input('SGPS_2027_2');
        $profin->SGPAPSB_2027_2 = $request->input('SGPAPSB_2027_2');
        $profin->RPED_2027_2 = $request->input('RPED_2027_2');
        $profin->SGR_2027_2 = $request->input('SGR_2027_2');
        $profin->CR_2027_2 = $request->input('CR_2027_2');
        $profin->G_2027_2 = $request->input('G_2027_2');
        $profin->CO_2027_2 = $request->input('CO_2027_2');
        $profin->OR_2027_2 = $request->input('OR_2027_2');
        $profin->ICDL_2027_3 = $request->input('ICDL_2027_3');
        $profin->ICDE_2027_3 = $request->input('ICDE_2027_3');
        $profin->SGPE_2027_3 = $request->input('SGPE_2027_3');
        $profin->SGPS_2027_3 = $request->input('SGPS_2027_3');
        $profin->SGPAPSB_2027_3 = $request->input('SGPAPSB_2027_3');
        $profin->RPED_2027_3 = $request->input('RPED_2027_3');
        $profin->SGR_2027_3 = $request->input('SGR_2027_3');
        $profin->CR_2027_3 = $request->input('CR_2027_3');
        $profin->G_2027_3 = $request->input('G_2027_3');
        $profin->CO_2027_3 = $request->input('CO_2027_3');
        $profin->OR_2027_3 = $request->input('OR_2027_3');
        $profin->ICDL_2027_4 = $request->input('ICDL_2027_4');
        $profin->ICDE_2027_4 = $request->input('ICDE_2027_4');
        $profin->SGPE_2027_4 = $request->input('SGPE_2027_4');
        $profin->SGPS_2027_4 = $request->input('SGPS_2027_4');
        $profin->SGPAPSB_2027_4 = $request->input('SGPAPSB_2027_4');
        $profin->RPED_2027_4 = $request->input('RPED_2027_4');
        $profin->SGR_2027_4 = $request->input('SGR_2027_4');
        $profin->CR_2027_4 = $request->input('CR_2027_4');
        $profin->G_2027_4 = $request->input('G_2027_4');
        $profin->CO_2027_4 = $request->input('CO_2027_4');
        $profin->OR_2027_4 = $request->input('OR_2027_4');
        $profin->id_ip = $request->input('id_ip');
        $profin->estado_pf = 'Activo';
        $profin->save();
        return redirect()->route('listarprofins')->with('success', 'Programación Financiera creada correctamente');
    }

    public function verprofin($id) {
        $profin = ProgramarFinanciero::with('indproducto')->find($id);
        return response()->json($profin);
    }

    public function editarprofin($id) {
        $profin = ProgramarFinanciero::find($id);
        return response()->json($profin);
    }

    public function actualizarprofin(Request $request) {
        $request->validate([    
            'estado' => 'required',
            'ICLD_2024_3' => 'required',
            'ICDE_2024_3' => 'required',
            'SGPE_2024_3' => 'required',
            'SGPS_2024_3' => 'required',
            'SGPAPSB_2024_3' => 'required',
            'RPED_2024_3' => 'required',
            'SGR_2024_3' => 'required',
            'CR_2024_3' => 'required',
            'G_2024_3' => 'required',
            'CO_2024_3' => 'required',
            'OR_2024_3' => 'required',
            'ICLD_2024_4' => 'required',
            'ICDE_2024_4' => 'required',
            'SGPE_2024_4' => 'required',
            'SGPS_2024_4' => 'required',
            'SGPAPSB_2024_4' => 'required',
            'RPED_2024_4' => 'required',
            'SGR_2024_4' => 'required',
            'CR_2024_4' => 'required',
            'G_2024_4' => 'required',
            'CO_2024_4' => 'required',
            'OR_2024_4' => 'required',
            'ICLD_2025_1' => 'required',
            'ICDE_2025_1' => 'required',
            'SGPE_2025_1' => 'required',
            'SGPS_2025_1' => 'required',
            'SGPAPSB_2025_1' => 'required',
            'RPED_2025_1' => 'required',
            'SGR_2025_1' => 'required',
            'CR_2025_1' => 'required',
            'G_2025_1' => 'required',
            'CO_2025_1' => 'required',
            'OR_2025_1' => 'required',
            'ICLD_2025_2' => 'required',
            'ICDE_2025_2' => 'required',
            'SGPE_2025_2' => 'required',
            'SGPS_2025_2' => 'required',
            'SGPAPSB_2025_2' => 'required',
            'RPED_2025_2' => 'required',
            'SGR_2025_2' => 'required',
            'CR_2025_2' => 'required',
            'G_2025_2' => 'required',
            'CO_2025_2' => 'required',
            'OR_2025_2' => 'required',
            'ICLD_2025_3' => 'required',
            'ICDE_2025_3' => 'required',
            'SGPE_2025_3' => 'required',
            'SGPS_2025_3' => 'required',
            'SGPAPSB_2025_3' => 'required',
            'RPED_2025_3' => 'required',
            'SGR_2025_3' => 'required',
            'CR_2025_3' => 'required',
            'G_2025_3' => 'required',
            'CO_2025_3' => 'required',
            'OR_2025_3' => 'required',
            'ICLD_2025_4' => 'required',
            'ICDE_2025_4' => 'required',
            'SGPE_2025_4' => 'required',
            'SGPS_2025_4' => 'required',
            'SGPAPSB_2025_4' => 'required',
            'RPED_2025_4' => 'required',
            'SGR_2025_4' => 'required',
            'CR_2025_4' => 'required',
            'G_2025_4' => 'required',
            'CO_2025_4' => 'required',
            'OR_2025_4' => 'required',
            'ICLD_2026_1' => 'required',
            'ICDE_2026_1' => 'required',
            'SGPE_2026_1' => 'required',
            'SGPS_2026_1' => 'required',
            'SGPAPSB_2026_1' => 'required',
            'RPED_2026_1' => 'required',
            'SGR_2026_1' => 'required',
            'CR_2026_1' => 'required',
            'G_2026_1' => 'required',
            'CO_2026_1' => 'required',
            'OR_2026_1' => 'required',
            'ICLD_2026_2' => 'required',
            'ICDE_2026_2' => 'required',
            'SGPE_2026_2' => 'required',
            'SGPS_2026_2' => 'required',
            'SGPAPSB_2026_2' => 'required',
            'RPED_2026_2' => 'required',
            'SGR_2026_2' => 'required',
            'CR_2026_2' => 'required',
            'G_2026_2' => 'required',
            'CO_2026_2' => 'required',
            'OR_2026_2' => 'required',
            'ICLD_2026_3' => 'required',
            'ICDE_2026_3' => 'required',
            'SGPE_2026_3' => 'required',
            'SGPS_2026_3' => 'required',
            'SGPAPSB_2026_3' => 'required',
            'RPED_2026_3' => 'required',
            'SGR_2026_3' => 'required',
            'CR_2026_3' => 'required',
            'G_2026_3' => 'required',
            'CO_2026_3' => 'required',
            'OR_2026_3' => 'required',
            'ICLD_2026_4' => 'required',
            'ICDE_2026_4' => 'required',
            'SGPE_2026_4' => 'required',
            'SGPS_2026_4' => 'required',
            'SGPAPSB_2026_4' => 'required',
            'RPED_2026_4' => 'required',
            'SGR_2026_4' => 'required',
            'CR_2026_4' => 'required',
            'G_2026_4' => 'required',
            'CO_2026_4' => 'required',
            'OR_2026_4' => 'required',
            'ICLD_2027_1' => 'required',
            'ICDE_2027_1' => 'required',
            'SGPE_2027_1' => 'required',
            'SGPS_2027_1' => 'required',
            'SGPAPSB_2027_1' => 'required',
            'RPED_2027_1' => 'required',
            'SGR_2027_1' => 'required',
            'CR_2027_1' => 'required',
            'G_2027_1' => 'required',
            'CO_2027_1' => 'required',
            'OR_2027_1' => 'required',
            'ICLD_2027_2' => 'required',
            'ICDE_2027_2' => 'required',
            'SGPE_2027_2' => 'required',
            'SGPS_2027_2' => 'required',
            'SGPAPSB_2027_2' => 'required',
            'RPED_2027_2' => 'required',
            'SGR_2027_2' => 'required',
            'CR_2027_2' => 'required',
            'G_2027_2' => 'required',
            'CO_2027_2' => 'required',
            'OR_2027_2' => 'required',
            'ICLD_2027_3' => 'required',
            'ICDE_2027_3' => 'required',
            'SGPE_2027_3' => 'required',
            'SGPS_2027_3' => 'required',
            'SGPAPSB_2027_3' => 'required',
            'RPED_2027_3' => 'required',
            'SGR_2027_3' => 'required',
            'CR_2027_3' => 'required',
            'G_2027_3' => 'required',
            'CO_2027_3' => 'required',
            'OR_2027_3' => 'required',
            'ICLD_2027_4' => 'required',
            'ICDE_2027_4' => 'required',
            'SGPE_2027_4' => 'required',
            'SGPS_2027_4' => 'required',
            'SGPAPSB_2027_4' => 'required',
            'RPED_2027_4' => 'required',
            'SGR_2027_4' => 'required',
            'CR_2027_4' => 'required',
            'G_2027_4' => 'required',
            'CO_2027_4' => 'required',
            'OR_2027_4' => 'required',
            'id_ip' => 'required|exists:indicador_productos,id'
        ]);
        $profin = new ProgramarFinanciero();
        $profin->ICDL_2024_3 = $request->input('ICDL_2024_3');
        $profin->ICDE_2024_3 = $request->input('ICDE_2024_3');
        $profin->SGPE_2024_3 = $request->input('SGPE_2024_3');
        $profin->SGPS_2024_3 = $request->input('SGPS_2024_3');
        $profin->SGPAPSB_2024_3 = $request->input('SGPAPSB_2024_3');
        $profin->RPED_2024_3 = $request->input('RPED_2024_3');
        $profin->SGR_2024_3 = $request->input('SGR_2024_3');
        $profin->CR_2024_3 = $request->input('CR_2024_3');
        $profin->G_2024_3 = $request->input('G_2024_3');
        $profin->CO_2024_3 = $request->input('CO_2024_3');
        $profin->OR_2024_3 = $request->input('OR_2024_3');
        $profin->ICDL_2024_4 = $request->input('ICDL_2024_4');
        $profin->ICDE_2024_4 = $request->input('ICDE_2024_4');
        $profin->SGPE_2024_4 = $request->input('SGPE_2024_4');
        $profin->SGPS_2024_4 = $request->input('SGPS_2024_4');
        $profin->SGPAPSB_2024_4 = $request->input('SGPAPSB_2024_4');
        $profin->RPED_2024_4 = $request->input('RPED_2024_4');
        $profin->SGR_2024_4 = $request->input('SGR_2024_4');
        $profin->CR_2024_4 = $request->input('CR_2024_4');
        $profin->G_2024_4 = $request->input('G_2024_4');
        $profin->CO_2024_4 = $request->input('CO_2024_4');
        $profin->OR_2024_4 = $request->input('OR_2024_4');
        $profin->ICDL_2025_1 = $request->input('ICDL_2025_1');
        $profin->ICDE_2025_1 = $request->input('ICDE_2025_1');
        $profin->SGPE_2025_1 = $request->input('SGPE_2025_1');
        $profin->SGPS_2025_1 = $request->input('SGPS_2025_1');
        $profin->SGPAPSB_2025_1 = $request->input('SGPAPSB_2025_1');
        $profin->RPED_2025_1 = $request->input('RPED_2025_1');
        $profin->SGR_2025_1 = $request->input('SGR_2025_1');
        $profin->CR_2025_1 = $request->input('CR_2025_1');
        $profin->G_2025_1 = $request->input('G_2025_1');
        $profin->CO_2025_1 = $request->input('CO_2025_1');
        $profin->OR_2025_1 = $request->input('OR_2025_1');
        $profin->ICDL_2025_2 = $request->input('ICDL_2025_2');
        $profin->ICDE_2025_2 = $request->input('ICDE_2025_2');
        $profin->SGPE_2025_2 = $request->input('SGPE_2025_2');
        $profin->SGPS_2025_2 = $request->input('SGPS_2025_2');
        $profin->SGPAPSB_2025_2 = $request->input('SGPAPSB_2025_2');
        $profin->RPED_2025_2 = $request->input('RPED_2025_2');
        $profin->SGR_2025_2 = $request->input('SGR_2025_2');
        $profin->CR_2025_2 = $request->input('CR_2025_2');
        $profin->G_2025_2 = $request->input('G_2025_2');
        $profin->CO_2025_2 = $request->input('CO_2025_2');
        $profin->OR_2025_2 = $request->input('OR_2025_2');
        $profin->ICDL_2025_3 = $request->input('ICDL_2025_3');
        $profin->ICDE_2025_3 = $request->input('ICDE_2025_3');
        $profin->SGPE_2025_3 = $request->input('SGPE_2025_3');
        $profin->SGPS_2025_3 = $request->input('SGPS_2025_3');
        $profin->SGPAPSB_2025_3 = $request->input('SGPAPSB_2025_3');
        $profin->RPED_2025_3 = $request->input('RPED_2025_3');
        $profin->SGR_2025_3 = $request->input('SGR_2025_3');
        $profin->CR_2025_3 = $request->input('CR_2025_3');
        $profin->G_2025_3 = $request->input('G_2025_3');
        $profin->CO_2025_3 = $request->input('CO_2025_3');
        $profin->OR_2025_3 = $request->input('OR_2025_3');
        $profin->ICDL_2025_4 = $request->input('ICDL_2025_4');
        $profin->ICDE_2025_4 = $request->input('ICDE_2025_4');
        $profin->SGPE_2025_4 = $request->input('SGPE_2025_4');
        $profin->SGPS_2025_4 = $request->input('SGPS_2025_4');
        $profin->SGPAPSB_2025_4 = $request->input('SGPAPSB_2025_4');
        $profin->RPED_2025_4 = $request->input('RPED_2025_4');
        $profin->SGR_2025_4 = $request->input('SGR_2025_4');
        $profin->CR_2025_4 = $request->input('CR_2025_4');
        $profin->G_2025_4 = $request->input('G_2025_4');
        $profin->CO_2025_4 = $request->input('CO_2025_4');
        $profin->OR_2025_4 = $request->input('OR_2025_4');
        $profin->ICDL_2026_1 = $request->input('ICDL_2026_1');
        $profin->ICDE_2026_1 = $request->input('ICDE_2026_1');
        $profin->SGPE_2026_1 = $request->input('SGPE_2026_1');
        $profin->SGPS_2026_1 = $request->input('SGPS_2026_1');
        $profin->SGPAPSB_2026_1 = $request->input('SGPAPSB_2026_1');
        $profin->RPED_2026_1 = $request->input('RPED_2026_1');
        $profin->SGR_2026_1 = $request->input('SGR_2026_1');
        $profin->CR_2026_1 = $request->input('CR_2026_1');
        $profin->G_2026_1 = $request->input('G_2026_1');
        $profin->CO_2026_1 = $request->input('CO_2026_1');
        $profin->OR_2026_1 = $request->input('OR_2026_1');
        $profin->ICDL_2026_2 = $request->input('ICDL_2026_2');
        $profin->ICDE_2026_2 = $request->input('ICDE_2026_2');
        $profin->SGPE_2026_2 = $request->input('SGPE_2026_2');
        $profin->SGPS_2026_2 = $request->input('SGPS_2026_2');
        $profin->SGPAPSB_2026_2 = $request->input('SGPAPSB_2026_2');
        $profin->RPED_2026_2 = $request->input('RPED_2026_2');
        $profin->SGR_2026_2 = $request->input('SGR_2026_2');
        $profin->CR_2026_2 = $request->input('CR_2026_2');
        $profin->G_2026_2 = $request->input('G_2026_2');
        $profin->CO_2026_2 = $request->input('CO_2026_2');
        $profin->OR_2026_2 = $request->input('OR_2026_2');
        $profin->ICDL_2026_3 = $request->input('ICDL_2026_3');
        $profin->ICDE_2026_3 = $request->input('ICDE_2026_3');
        $profin->SGPE_2026_3 = $request->input('SGPE_2026_3');
        $profin->SGPS_2026_3 = $request->input('SGPS_2026_3');
        $profin->SGPAPSB_2026_3 = $request->input('SGPAPSB_2026_3');
        $profin->RPED_2026_3 = $request->input('RPED_2026_3');
        $profin->SGR_2026_3 = $request->input('SGR_2026_3');
        $profin->CR_2026_3 = $request->input('CR_2026_3');
        $profin->G_2026_3 = $request->input('G_2026_3');
        $profin->CO_2026_3 = $request->input('CO_2026_3');
        $profin->OR_2026_3 = $request->input('OR_2026_3');
        $profin->ICDL_2026_4 = $request->input('ICDL_2026_4');
        $profin->ICDE_2026_4 = $request->input('ICDE_2026_4');
        $profin->SGPE_2026_4 = $request->input('SGPE_2026_4');
        $profin->SGPS_2026_4 = $request->input('SGPS_2026_4');
        $profin->SGPAPSB_2026_4 = $request->input('SGPAPSB_2026_4');
        $profin->RPED_2026_4 = $request->input('RPED_2026_4');
        $profin->SGR_2026_4 = $request->input('SGR_2026_4');
        $profin->CR_2026_4 = $request->input('CR_2026_4');
        $profin->G_2026_4 = $request->input('G_2026_4');
        $profin->CO_2026_4 = $request->input('CO_2026_4');
        $profin->OR_2026_4 = $request->input('OR_2026_4');
        $profin->ICDL_2027_1 = $request->input('ICDL_2027_1');
        $profin->ICDE_2027_1 = $request->input('ICDE_2027_1');
        $profin->SGPE_2027_1 = $request->input('SGPE_2027_1');
        $profin->SGPS_2027_1 = $request->input('SGPS_2027_1');
        $profin->SGPAPSB_2027_1 = $request->input('SGPAPSB_2027_1');
        $profin->RPED_2027_1 = $request->input('RPED_2027_1');
        $profin->SGR_2027_1 = $request->input('SGR_2027_1');
        $profin->CR_2027_1 = $request->input('CR_2027_1');
        $profin->G_2027_1 = $request->input('G_2027_1');
        $profin->CO_2027_1 = $request->input('CO_2027_1');
        $profin->OR_2027_1 = $request->input('OR_2027_1');
        $profin->ICDL_2027_2 = $request->input('ICDL_2027_2');
        $profin->ICDE_2027_2 = $request->input('ICDE_2027_2');
        $profin->SGPE_2027_2 = $request->input('SGPE_2027_2');
        $profin->SGPS_2027_2 = $request->input('SGPS_2027_2');
        $profin->SGPAPSB_2027_2 = $request->input('SGPAPSB_2027_2');
        $profin->RPED_2027_2 = $request->input('RPED_2027_2');
        $profin->SGR_2027_2 = $request->input('SGR_2027_2');
        $profin->CR_2027_2 = $request->input('CR_2027_2');
        $profin->G_2027_2 = $request->input('G_2027_2');
        $profin->CO_2027_2 = $request->input('CO_2027_2');
        $profin->OR_2027_2 = $request->input('OR_2027_2');
        $profin->ICDL_2027_3 = $request->input('ICDL_2027_3');
        $profin->ICDE_2027_3 = $request->input('ICDE_2027_3');
        $profin->SGPE_2027_3 = $request->input('SGPE_2027_3');
        $profin->SGPS_2027_3 = $request->input('SGPS_2027_3');
        $profin->SGPAPSB_2027_3 = $request->input('SGPAPSB_2027_3');
        $profin->RPED_2027_3 = $request->input('RPED_2027_3');
        $profin->SGR_2027_3 = $request->input('SGR_2027_3');
        $profin->CR_2027_3 = $request->input('CR_2027_3');
        $profin->G_2027_3 = $request->input('G_2027_3');
        $profin->CO_2027_3 = $request->input('CO_2027_3');
        $profin->OR_2027_3 = $request->input('OR_2027_3');
        $profin->ICDL_2027_4 = $request->input('ICDL_2027_4');
        $profin->ICDE_2027_4 = $request->input('ICDE_2027_4');
        $profin->SGPE_2027_4 = $request->input('SGPE_2027_4');
        $profin->SGPS_2027_4 = $request->input('SGPS_2027_4');
        $profin->SGPAPSB_2027_4 = $request->input('SGPAPSB_2027_4');
        $profin->RPED_2027_4 = $request->input('RPED_2027_4');
        $profin->SGR_2027_4 = $request->input('SGR_2027_4');
        $profin->CR_2027_4 = $request->input('CR_2027_4');
        $profin->G_2027_4 = $request->input('G_2027_4');
        $profin->CO_2027_4 = $request->input('CO_2027_4');
        $profin->OR_2027_4 = $request->input('OR_2027_4');
        $profin->id_ip = $request->input('id_ip');
        $profin->estado_pf = $request->input('estado');;
        $profin->save();
        return redirect()->route('listarprofins')->with('success', 'Programación Financiera actualizada correctamente');
    }

    public function eliminarprofin($id) {
        $profin = ProgramarFinanciero::find($id);
        if ($profin) {
            $profin->estado_pf = "Inactivo";
            $profin->save();
            return response()->json(['success' => true, 'message' => 'Programación Financiera Inactivo']);
        }
        return response()->json(['error' => true, 'message' => 'Programación Financiera no encontrada']);
    }

    /*public function csvprofins(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);
    
        // Leer encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        $encabezadosLeidos = array_map('trim', $headings[0][0]);
        $encabezadosEsperados = ['id_ip', 'icld_2024_3', 'icde_2024_3', 'sgpe_2024_3', 'sgps_2024_3', 'sgpapsb_2024_3', 'rped_2024_3', 'sgr_2024_3', 'cr_2024_3', 'g_2024_3', 'co_2024_3', 'or_2024_3',
                                'icld_2024_4', 'icde_2024_4', 'sgpe_2024_4', 'sgps_2024_4', 'sgpapsb_2024_4', 'rped_2024_4', 'sgr_2024_4', 'cr_2024_4', 'g_2024_4', 'co_2024_4', 'or_2024_4',
                                'icld_2025_1', 'icde_2025_1', 'sgpe_2025_1', 'sgps_2025_1', 'sgpapsb_2025_1', 'rped_2025_1', 'sgr_2025_1', 'cr_2025_1', 'g_2025_1', 'co_2025_1', 'or_2025_1',
                                'icld_2025_2', 'icde_2025_2', 'sgpe_2025_2', 'sgps_2025_2', 'sgpapsb_2025_2', 'rped_2025_2', 'sgr_2025_2', 'cr_2025_2', 'g_2025_2', 'co_2025_2', 'or_2025_2',
                                'icld_2025_3', 'icde_2025_3', 'sgpe_2025_3', 'sgps_2025_3', 'sgpapsb_2025_3', 'rped_2025_3', 'sgr_2025_3', 'cr_2025_3', 'g_2025_3', 'co_2025_3', 'or_2025_3',
                                'icld_2025_4', 'icde_2025_4', 'sgpe_2025_4', 'sgps_2025_4', 'sgpapsb_2025_4', 'rped_2025_4', 'sgr_2025_4', 'cr_2025_4', 'g_2025_4', 'co_2025_4', 'or_2025_4',
                                'icld_2026_1', 'icde_2026_1', 'sgpe_2026_1', 'sgps_2026_1', 'sgpapsb_2026_1', 'rped_2026_1', 'sgr_2026_1', 'cr_2026_1', 'g_2026_1', 'co_2026_1', 'or_2026_1',
                                'icld_2026_2', 'icde_2026_2', 'sgpe_2026_2', 'sgps_2026_2', 'sgpapsb_2026_2', 'rped_2026_2', 'sgr_2026_2', 'cr_2026_2', 'g_2026_2', 'co_2026_2', 'or_2026_2',
                                'icld_2026_3', 'icde_2026_3', 'sgpe_2026_3', 'sgps_2026_3', 'sgpapsb_2026_3', 'rped_2026_3', 'sgr_2026_3', 'cr_2026_3', 'g_2026_3', 'co_2026_3', 'or_2026_3',
                                'icld_2026_4', 'icde_2026_4', 'sgpe_2026_4', 'sgps_2026_4', 'sgpapsb_2026_4', 'rped_2026_4', 'sgr_2026_4', 'cr_2026_4', 'g_2026_4', 'co_2026_4', 'or_2026_4',
                                'icld_2027_1', 'icde_2027_1', 'sgpe_2027_1', 'sgps_2027_1', 'sgpapsb_2027_1', 'rped_2027_1', 'sgr_2027_1', 'cr_2027_1', 'g_2027_1', 'co_2027_1', 'or_2027_1',
                                'icld_2027_2', 'icde_2027_2', 'sgpe_2027_2', 'sgps_2027_2', 'sgpapsb_2027_2', 'rped_2027_2', 'sgr_2027_2', 'cr_2027_2', 'g_2027_2', 'co_2027_2', 'or_2027_2',
                                'icld_2027_3', 'icde_2027_3', 'sgpe_2027_3', 'sgps_2027_3', 'sgpapsb_2027_3', 'rped_2027_3', 'sgr_2027_3', 'cr_2027_3', 'g_2027_3', 'co_2027_3', 'or_2027_3',
                                'icld_2027_4', 'icde_2027_4', 'sgpe_2027_4', 'sgps_2027_4', 'sgpapsb_2027_4', 'rped_2027_4', 'sgr_2027_4', 'cr_2027_4', 'g_2027_4', 'co_2027_4', 'or_2027_4', 'estado_pf'];
    
        // Normalizar para evitar problemas de espacios y mayúsculas
        $encabezadosLeidos = array_map('strtolower', $encabezadosLeidos);
        $encabezadosEsperados = array_map('strtolower', $encabezadosEsperados);
    
        // Verificar encabezados
        $faltantes = array_diff($encabezadosEsperados, $encabezadosLeidos);
        $adicionales = array_diff($encabezadosLeidos, $encabezadosEsperados);
    
        if (!empty($faltantes) || !empty($adicionales)) {
            $mensaje = "La estructura del archivo no es válida.";
            if (!empty($faltantes)) {
                $mensaje .= " Faltan encabezados: " . implode(', ', $faltantes) . ".";
            }
            if (!empty($adicionales)) {
                $mensaje .= " Encabezados no esperados: " . implode(', ', $adicionales) . ".";
            }
            return redirect()->back()->with('error', $mensaje);
        }
    
        // Importar datos
        $importar = new csvImportProFin;
        Excel::import($importar, $request->file('archivo'));
    
        $nuevos = $importar->cantidadNuevos ?? 0;
        $existentes = $importar->cantidadExistentes ?? 0;
    
        if ($nuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Programaciones Financieras ya existen en la base de datos.');
        }
    
        return redirect()->back()->with('success', "{$nuevos} nuevas Programaciones Financieras importadas correctamente y {$existentes} registros ya existían en la base de datos.");
    }*/
    
    
    public function csvprofins(Request $request) {
        $request->validate([
            'archivo' => 'required|file|mimes:csv,txt',
        ]);
        //return response()->json($request);

        // Leer los encabezados del archivo
        $headings = (new HeadingRowImport)->toArray($request->file('archivo'));
        
        // Los encabezados leídos están en $headings[0][0]
        $encabezadosLeidos = $headings[0][0];
        // Encabezados esperados
        $encabezadosEsperados = ['id_ip', 'icld_2024_3', 'icde_2024_3', 'sgpe_2024_3', 'sgps_2024_3', 'sgpapsb_2024_3', 'rped_2024_3', 'sgr_2024_3', 'cr_2024_3', 'g_2024_3', 'co_2024_3', 'or_2024_3',
                                'icld_2024_4', 'icde_2024_4', 'sgpe_2024_4', 'sgps_2024_4', 'sgpapsb_2024_4', 'rped_2024_4', 'sgr_2024_4', 'cr_2024_4', 'g_2024_4', 'co_2024_4', 'or_2024_4',
                                'icld_2025_1', 'icde_2025_1', 'sgpe_2025_1', 'sgps_2025_1', 'sgpapsb_2025_1', 'rped_2025_1', 'sgr_2025_1', 'cr_2025_1', 'g_2025_1', 'co_2025_1', 'or_2025_1',
                                'icld_2025_2', 'icde_2025_2', 'sgpe_2025_2', 'sgps_2025_2', 'sgpapsb_2025_2', 'rped_2025_2', 'sgr_2025_2', 'cr_2025_2', 'g_2025_2', 'co_2025_2', 'or_2025_2',
                                'icld_2025_3', 'icde_2025_3', 'sgpe_2025_3', 'sgps_2025_3', 'sgpapsb_2025_3', 'rped_2025_3', 'sgr_2025_3', 'cr_2025_3', 'g_2025_3', 'co_2025_3', 'or_2025_3',
                                'icld_2025_4', 'icde_2025_4', 'sgpe_2025_4', 'sgps_2025_4', 'sgpapsb_2025_4', 'rped_2025_4', 'sgr_2025_4', 'cr_2025_4', 'g_2025_4', 'co_2025_4', 'or_2025_4',
                                'icld_2026_1', 'icde_2026_1', 'sgpe_2026_1', 'sgps_2026_1', 'sgpapsb_2026_1', 'rped_2026_1', 'sgr_2026_1', 'cr_2026_1', 'g_2026_1', 'co_2026_1', 'or_2026_1',
                                'icld_2026_2', 'icde_2026_2', 'sgpe_2026_2', 'sgps_2026_2', 'sgpapsb_2026_2', 'rped_2026_2', 'sgr_2026_2', 'cr_2026_2', 'g_2026_2', 'co_2026_2', 'or_2026_2',
                                'icld_2026_3', 'icde_2026_3', 'sgpe_2026_3', 'sgps_2026_3', 'sgpapsb_2026_3', 'rped_2026_3', 'sgr_2026_3', 'cr_2026_3', 'g_2026_3', 'co_2026_3', 'or_2026_3',
                                'icld_2026_4', 'icde_2026_4', 'sgpe_2026_4', 'sgps_2026_4', 'sgpapsb_2026_4', 'rped_2026_4', 'sgr_2026_4', 'cr_2026_4', 'g_2026_4', 'co_2026_4', 'or_2026_4',
                                'icld_2027_1', 'icde_2027_1', 'sgpe_2027_1', 'sgps_2027_1', 'sgpapsb_2027_1', 'rped_2027_1', 'sgr_2027_1', 'cr_2027_1', 'g_2027_1', 'co_2027_1', 'or_2027_1',
                                'icld_2027_2', 'icde_2027_2', 'sgpe_2027_2', 'sgps_2027_2', 'sgpapsb_2027_2', 'rped_2027_2', 'sgr_2027_2', 'cr_2027_2', 'g_2027_2', 'co_2027_2', 'or_2027_2',
                                'icld_2027_3', 'icde_2027_3', 'sgpe_2027_3', 'sgps_2027_3', 'sgpapsb_2027_3', 'rped_2027_3', 'sgr_2027_3', 'cr_2027_3', 'g_2027_3', 'co_2027_3', 'or_2027_3',
                                'icld_2027_4', 'icde_2027_4', 'sgpe_2027_4', 'sgps_2027_4', 'sgpapsb_2027_4', 'rped_2027_4', 'sgr_2027_4', 'cr_2027_4', 'g_2027_4', 'co_2027_4', 'or_2027_4', 'estado_pf'];
        

        $encabezadosLeidos = array_map('trim', $headings[0][0]);
        //sort($encabezadosLeidos);
        //sort($encabezadosEsperados);

        //dd($encabezadosEsperados, $encabezadosLeidos);

        // Verificar si los encabezados coinciden
        // Comparamos si los encabezados obtenidos coinciden con los esperados
        if ($encabezadosLeidos !== $encabezadosEsperados) {
            return redirect()->back()->with('error', 'La estructura del archivo no es válida. Verifica los encabezados.');
        }

        // Continuar con la importación si todo está bien
        // Crear la instancia de la clase de importación
        $importar = new csvImportProFin;

        Excel::import($importar, $request->file('archivo'));

         // Preparar los mensajes según el resultado
        if ($importar->cantidadNuevos === 0) {
            return redirect()->back()->with('info', 'Todas las Programaciones Financieras ya existen en la base de datos.');
        }

        return redirect()->back()->with('success', "{$importar->cantidadNuevos} nuevas Programaciones Financieras importadas correctamente y {$importar->cantidadExistentes} registros ya existían en la base de datos.");
    }
}
