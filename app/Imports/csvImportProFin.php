<?php

namespace App\Imports;

use App\Models\IndicadorProducto;
use App\Models\ProgramarFinanciero;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportProFin implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // Variables para contar los registros procesados
    public $cantidadNuevos = 0;
    public $cantidadExistentes = 0;

    public function model(array $row)
    {
        $relacion = IndicadorProducto::where('id', $row['id_ip']);
        if ($relacion) {
            // Verificar si el registro ya existe
            $existe = ProgramarFinanciero::where('id_ip', $row['id_ip'])
                                ->where('icld_2024_3', $row['icld_2024_3'])
                                ->where('icde_2024_3', $row['icde_2024_3'])
                                ->where('sgpe_2024_3', $row['sgpe_2024_3'])
                                ->where('sgps_2024_3', $row['sgps_2024_3'])
                                ->where('sgpapsb_2024_3', $row['sgpapsb_2024_3'])
                                ->where('rped_2024_3', $row['rped_2024_3'])
                                ->where('sgr_2024_3', $row['sgr_2024_3'])
                                ->where('cr_2024_3', $row['cr_2024_3'])
                                ->where('g_2024_3', $row['g_2024_3'])
                                ->where('co_2024_3', $row['co_2024_3'])
                                ->where('or_2024_3', $row['or_2024_3'])
                                ->where('icld_2024_4', $row['icld_2024_4'])
                                ->where('icde_2024_4', $row['icde_2024_4'])
                                ->where('sgpe_2024_4', $row['sgpe_2024_4'])
                                ->where('sgps_2024_4', $row['sgps_2024_4'])
                                ->where('sgpapsb_2024_4', $row['sgpapsb_2024_4'])
                                ->where('rped_2024_4', $row['rped_2024_4'])
                                ->where('sgr_2024_4', $row['sgr_2024_4'])
                                ->where('cr_2024_4', $row['cr_2024_4'])
                                ->where('g_2024_4', $row['g_2024_4'])
                                ->where('co_2024_4', $row['co_2024_4'])
                                ->where('or_2024_4', $row['or_2024_4'])
                                ->where('icld_2025_1', $row['icld_2025_1'])
                                ->where('icde_2025_1', $row['icde_2025_1'])
                                ->where('sgpe_2025_1', $row['sgpe_2025_1'])
                                ->where('sgps_2025_1', $row['sgps_2025_1'])
                                ->where('sgpapsb_2025_1', $row['sgpapsb_2025_1'])
                                ->where('rped_2025_1', $row['rped_2025_1'])
                                ->where('sgr_2025_1', $row['sgr_2025_1'])
                                ->where('cr_2025_1', $row['cr_2025_1'])
                                ->where('g_2025_1', $row['g_2025_1'])
                                ->where('co_2025_1', $row['co_2025_1'])
                                ->where('or_2025_1', $row['or_2025_1'])
                                ->where('icld_2025_2', $row['icld_2025_2'])
                                ->where('icde_2025_2', $row['icde_2025_2'])
                                ->where('sgpe_2025_2', $row['sgpe_2025_2'])
                                ->where('sgps_2025_2', $row['sgps_2025_2'])
                                ->where('sgpapsb_2025_2', $row['sgpapsb_2025_2'])
                                ->where('rped_2025_2', $row['rped_2025_2'])
                                ->where('sgr_2025_2', $row['sgr_2025_2'])
                                ->where('cr_2025_2', $row['cr_2025_2'])
                                ->where('g_2025_2', $row['g_2025_2'])
                                ->where('co_2025_2', $row['co_2025_2'])
                                ->where('or_2025_2', $row['or_2025_2'])
                                ->where('icld_2025_3', $row['icld_2025_3'])
                                ->where('icde_2025_3', $row['icde_2025_3'])
                                ->where('sgpe_2025_3', $row['sgpe_2025_3'])
                                ->where('sgps_2025_3', $row['sgps_2025_3'])
                                ->where('sgpapsb_2025_3', $row['sgpapsb_2025_3'])
                                ->where('rped_2025_3', $row['rped_2025_3'])
                                ->where('sgr_2025_3', $row['sgr_2025_3'])
                                ->where('cr_2025_3', $row['cr_2025_3'])
                                ->where('g_2025_3', $row['g_2025_3'])
                                ->where('co_2025_3', $row['co_2025_3'])
                                ->where('or_2025_3', $row['or_2025_3'])
                                ->where('icld_2025_4', $row['icld_2025_4'])
                                ->where('icde_2025_4', $row['icde_2025_4'])
                                ->where('sgpe_2025_4', $row['sgpe_2025_4'])
                                ->where('sgps_2025_4', $row['sgps_2025_4'])
                                ->where('sgpapsb_2025_4', $row['sgpapsb_2025_4'])
                                ->where('rped_2025_4', $row['rped_2025_4'])
                                ->where('sgr_2025_4', $row['sgr_2025_4'])
                                ->where('cr_2025_4', $row['cr_2025_4'])
                                ->where('g_2025_4', $row['g_2025_4'])
                                ->where('co_2025_4', $row['co_2025_4'])
                                ->where('or_2025_4', $row['or_2025_4'])
                                ->where('icld_2026_1', $row['icld_2026_1'])
                                ->where('icde_2026_1', $row['icde_2026_1'])
                                ->where('sgpe_2026_1', $row['sgpe_2026_1'])
                                ->where('sgps_2026_1', $row['sgps_2026_1'])
                                ->where('sgpapsb_2026_1', $row['sgpapsb_2026_1'])
                                ->where('rped_2026_1', $row['rped_2026_1'])
                                ->where('sgr_2026_1', $row['sgr_2026_1'])
                                ->where('cr_2026_1', $row['cr_2026_1'])
                                ->where('g_2026_1', $row['g_2026_1'])
                                ->where('co_2026_1', $row['co_2026_1'])
                                ->where('or_2026_1', $row['or_2026_1'])
                                ->where('icld_2026_2', $row['icld_2026_2'])
                                ->where('icde_2026_2', $row['icde_2026_2'])
                                ->where('sgpe_2026_2', $row['sgpe_2026_2'])
                                ->where('sgps_2026_2', $row['sgps_2026_2'])
                                ->where('sgpapsb_2026_2', $row['sgpapsb_2026_2'])
                                ->where('rped_2026_2', $row['rped_2026_2'])
                                ->where('sgr_2026_2', $row['sgr_2026_2'])
                                ->where('cr_2026_2', $row['cr_2026_2'])
                                ->where('g_2026_2', $row['g_2026_2'])
                                ->where('co_2026_2', $row['co_2026_2'])
                                ->where('or_2026_2', $row['or_2026_2'])
                                ->where('icld_2026_3', $row['icld_2026_3'])
                                ->where('icde_2026_3', $row['icde_2026_3'])
                                ->where('sgpe_2026_3', $row['sgpe_2026_3'])
                                ->where('sgps_2026_3', $row['sgps_2026_3'])
                                ->where('sgpapsb_2026_3', $row['sgpapsb_2026_3'])
                                ->where('rped_2026_3', $row['rped_2026_3'])
                                ->where('sgr_2026_3', $row['sgr_2026_3'])
                                ->where('cr_2026_3', $row['cr_2026_3'])
                                ->where('g_2026_3', $row['g_2026_3'])
                                ->where('co_2026_3', $row['co_2026_3'])
                                ->where('or_2026_3', $row['or_2026_3'])
                                ->where('icld_2026_4', $row['icld_2026_4'])
                                ->where('icde_2026_4', $row['icde_2026_4'])
                                ->where('sgpe_2026_4', $row['sgpe_2026_4'])
                                ->where('sgps_2026_4', $row['sgps_2026_4'])
                                ->where('sgpapsb_2026_4', $row['sgpapsb_2026_4'])
                                ->where('rped_2026_4', $row['rped_2026_4'])
                                ->where('sgr_2026_4', $row['sgr_2026_4'])
                                ->where('cr_2026_4', $row['cr_2026_4'])
                                ->where('g_2026_4', $row['g_2026_4'])
                                ->where('co_2026_4', $row['co_2026_4'])
                                ->where('or_2026_4', $row['or_2026_4'])
                                ->where('icld_2027_1', $row['icld_2027_1'])
                                ->where('icde_2027_1', $row['icde_2027_1'])
                                ->where('sgpe_2027_1', $row['sgpe_2027_1'])
                                ->where('sgps_2027_1', $row['sgps_2027_1'])
                                ->where('sgpapsb_2027_1', $row['sgpapsb_2027_1'])
                                ->where('rped_2027_1', $row['rped_2027_1'])
                                ->where('sgr_2027_1', $row['sgr_2027_1'])
                                ->where('cr_2027_1', $row['cr_2027_1'])
                                ->where('g_2027_1', $row['g_2027_1'])
                                ->where('co_2027_1', $row['co_2027_1'])
                                ->where('or_2027_1', $row['or_2027_1'])
                                ->where('icld_2027_2', $row['icld_2027_2'])
                                ->where('icde_2027_2', $row['icde_2027_2'])
                                ->where('sgpe_2027_2', $row['sgpe_2027_2'])
                                ->where('sgps_2027_2', $row['sgps_2027_2'])
                                ->where('sgpapsb_2027_2', $row['sgpapsb_2027_2'])
                                ->where('rped_2027_2', $row['rped_2027_2'])
                                ->where('sgr_2027_2', $row['sgr_2027_2'])
                                ->where('cr_2027_2', $row['cr_2027_2'])
                                ->where('g_2027_2', $row['g_2027_2'])
                                ->where('co_2027_2', $row['co_2027_2'])
                                ->where('or_2027_2', $row['or_2027_2'])
                                ->where('icld_2027_3', $row['icld_2027_3'])
                                ->where('icde_2027_3', $row['icde_2027_3'])
                                ->where('sgpe_2027_3', $row['sgpe_2027_3'])
                                ->where('sgps_2027_3', $row['sgps_2027_3'])
                                ->where('sgpapsb_2027_3', $row['sgpapsb_2027_3'])
                                ->where('rped_2027_3', $row['rped_2027_3'])
                                ->where('sgr_2027_3', $row['sgr_2027_3'])
                                ->where('cr_2027_3', $row['cr_2027_3'])
                                ->where('g_2027_3', $row['g_2027_3'])
                                ->where('co_2027_3', $row['co_2027_3'])
                                ->where('or_2027_3', $row['or_2027_3'])
                                ->where('icld_2027_4', $row['icld_2027_4'])
                                ->where('icde_2027_4', $row['icde_2027_4'])
                                ->where('sgpe_2027_4', $row['sgpe_2027_4'])
                                ->where('sgps_2027_4', $row['sgps_2027_4'])
                                ->where('sgpapsb_2027_4', $row['sgpapsb_2027_4'])
                                ->where('rped_2027_4', $row['rped_2027_4'])
                                ->where('sgr_2027_4', $row['sgr_2027_4'])
                                ->where('cr_2027_4', $row['cr_2027_4'])
                                ->where('g_2027_4', $row['g_2027_4'])
                                ->where('co_2027_4', $row['co_2027_4'])
                                ->where('or_2027_4', $row['or_2027_4'])            
                                ->where('estado_pf', $row['estado_pf'])                
                                ->exists();
        }

        //dd($row);

        if (!$existe) {
            // Crear el registro si no existe
            ProgramarFinanciero::create([
                'id_ip' => $row['id_ip'],
                'ICLD_2024_3'=>$row['icld_2024_3'],
                'ICDE_2024_3'=>$row['icde_2024_3'],
                'SGPE_2024_3'=>$row['sgpe_2024_3'],
                'SGPS_2024_3'=>$row['sgps_2024_3'],
                'SGPAPSB_2024_3'=>$row['sgpapsb_2024_3'],
                'RPED_2024_3'=>$row['rped_2024_3'],
                'SGR_2024_3'=>$row['sgr_2024_3'],
                'CR_2024_3'=>$row['cr_2024_3'],
                'G_2024_3'=>$row['g_2024_3'],
                'CO_2024_3'=>$row['co_2024_3'],
                'OR_2024_3'=>$row['or_2024_3'],
                'ICLD_2024_4'=>$row['icld_2024_4'],
                'ICDE_2024_4'=>$row['icde_2024_4'],
                'SGPE_2024_4'=>$row['sgpe_2024_4'],
                'SGPS_2024_4'=>$row['sgps_2024_4'],
                'SGPAPSB_2024_4'=>$row['sgpapsb_2024_4'],
                'RPED_2024_4'=>$row['rped_2024_4'],
                'SGR_2024_4'=>$row['sgr_2024_4'],
                'CR_2024_4'=>$row['cr_2024_4'],
                'G_2024_4'=>$row['g_2024_4'],
                'CO_2024_4'=>$row['co_2024_4'],
                'OR_2024_4'=>$row['or_2024_4'],
                'ICLD_2025_1'=>$row['icld_2025_1'],
                'ICDE_2025_1'=>$row['icde_2025_1'],
                'SGPE_2025_1'=>$row['sgpe_2025_1'],
                'SGPS_2025_1'=>$row['sgps_2025_1'],
                'SGPAPSB_2025_1'=>$row['sgpapsb_2025_1'],
                'RPED_2025_1'=>$row['rped_2025_1'],
                'SGR_2025_1'=>$row['sgr_2025_1'],
                'CR_2025_1'=>$row['cr_2025_1'],
                'G_2025_1'=>$row['g_2025_1'],
                'CO_2025_1'=>$row['co_2025_1'],
                'OR_2025_1'=>$row['or_2025_1'],
                'ICLD_2025_2'=>$row['icld_2025_2'],
                'ICDE_2025_2'=>$row['icde_2025_2'],
                'SGPE_2025_2'=>$row['sgpe_2025_2'],
                'SGPS_2025_2'=>$row['sgps_2025_2'],
                'SGPAPSB_2025_2'=>$row['sgpapsb_2025_2'],
                'RPED_2025_2'=>$row['rped_2025_2'],
                'SGR_2025_2'=>$row['sgr_2025_2'],
                'CR_2025_2'=>$row['cr_2025_2'],
                'G_2025_2'=>$row['g_2025_2'],
                'CO_2025_2'=>$row['co_2025_2'],
                'OR_2025_2'=>$row['or_2025_2'],
                'ICLD_2025_3'=>$row['icld_2025_3'],
                'ICDE_2025_3'=>$row['icde_2025_3'],
                'SGPE_2025_3'=>$row['sgpe_2025_3'],
                'SGPS_2025_3'=>$row['sgps_2025_3'],
                'SGPAPSB_2025_3'=>$row['sgpapsb_2025_3'],
                'RPED_2025_3'=>$row['rped_2025_3'],
                'SGR_2025_3'=>$row['sgr_2025_3'],
                'CR_2025_3'=>$row['cr_2025_3'],
                'G_2025_3'=>$row['g_2025_3'],
                'CO_2025_3'=>$row['co_2025_3'],
                'OR_2025_3'=>$row['or_2025_3'],
                'ICLD_2025_4'=>$row['icld_2025_4'],
                'ICDE_2025_4'=>$row['icde_2025_4'],
                'SGPE_2025_4'=>$row['sgpe_2025_4'],
                'SGPS_2025_4'=>$row['sgps_2025_4'],
                'SGPAPSB_2025_4'=>$row['sgpapsb_2025_4'],
                'RPED_2025_4'=>$row['rped_2025_4'],
                'SGR_2025_4'=>$row['sgr_2025_4'],
                'CR_2025_4'=>$row['cr_2025_4'],
                'G_2025_4'=>$row['g_2025_4'],
                'CO_2025_4'=>$row['co_2025_4'],
                'OR_2025_4'=>$row['or_2025_4'],
                'ICLD_2026_1'=>$row['icld_2026_1'],
                'ICDE_2026_1'=>$row['icde_2026_1'],
                'SGPE_2026_1'=>$row['sgpe_2026_1'],
                'SGPS_2026_1'=>$row['sgps_2026_1'],
                'SGPAPSB_2026_1'=>$row['sgpapsb_2026_1'],
                'RPED_2026_1'=>$row['rped_2026_1'],
                'SGR_2026_1'=>$row['sgr_2026_1'],
                'CR_2026_1'=>$row['cr_2026_1'],
                'G_2026_1'=>$row['g_2026_1'],
                'CO_2026_1'=>$row['co_2026_1'],
                'OR_2026_1'=>$row['or_2026_1'],
                'ICLD_2026_2'=>$row['icld_2026_2'],
                'ICDE_2026_2'=>$row['icde_2026_2'],
                'SGPE_2026_2'=>$row['sgpe_2026_2'],
                'SGPS_2026_2'=>$row['sgps_2026_2'],
                'SGPAPSB_2026_2'=>$row['sgpapsb_2026_2'],
                'RPED_2026_2'=>$row['rped_2026_2'],
                'SGR_2026_2'=>$row['sgr_2026_2'],
                'CR_2026_2'=>$row['cr_2026_2'],
                'G_2026_2'=>$row['g_2026_2'],
                'CO_2026_2'=>$row['co_2026_2'],
                'OR_2026_2'=>$row['or_2026_2'],
                'ICLD_2026_3'=>$row['icld_2026_3'],
                'ICDE_2026_3'=>$row['icde_2026_3'],
                'SGPE_2026_3'=>$row['sgpe_2026_3'],
                'SGPS_2026_3'=>$row['sgps_2026_3'],
                'SGPAPSB_2026_3'=>$row['sgpapsb_2026_3'],
                'RPED_2026_3'=>$row['rped_2026_3'],
                'SGR_2026_3'=>$row['sgr_2026_3'],
                'CR_2026_3'=>$row['cr_2026_3'],
                'G_2026_3'=>$row['g_2026_3'],
                'CO_2026_3'=>$row['co_2026_3'],
                'OR_2026_3'=>$row['or_2026_3'],
                'ICLD_2026_4'=>$row['icld_2026_4'],
                'ICDE_2026_4'=>$row['icde_2026_4'],
                'SGPE_2026_4'=>$row['sgpe_2026_4'],
                'SGPS_2026_4'=>$row['sgps_2026_4'],
                'SGPAPSB_2026_4'=>$row['sgpapsb_2026_4'],
                'RPED_2026_4'=>$row['rped_2026_4'],
                'SGR_2026_4'=>$row['sgr_2026_4'],
                'CR_2026_4'=>$row['cr_2026_4'],
                'G_2026_4'=>$row['g_2026_4'],
                'CO_2026_4'=>$row['co_2026_4'],
                'OR_2026_4'=>$row['or_2026_4'],
                'ICLD_2027_1'=>$row['icld_2027_1'],
                'ICDE_2027_1'=>$row['icde_2027_1'],
                'SGPE_2027_1'=>$row['sgpe_2027_1'],
                'SGPS_2027_1'=>$row['sgps_2027_1'],
                'SGPAPSB_2027_1'=>$row['sgpapsb_2027_1'],
                'RPED_2027_1'=>$row['rped_2027_1'],
                'SGR_2027_1'=>$row['sgr_2027_1'],
                'CR_2027_1'=>$row['cr_2027_1'],
                'G_2027_1'=>$row['g_2027_1'],
                'CO_2027_1'=>$row['co_2027_1'],
                'OR_2027_1'=>$row['or_2027_1'],
                'ICLD_2027_2'=>$row['icld_2027_2'],
                'ICDE_2027_2'=>$row['icde_2027_2'],
                'SGPE_2027_2'=>$row['sgpe_2027_2'],
                'SGPS_2027_2'=>$row['sgps_2027_2'],
                'SGPAPSB_2027_2'=>$row['sgpapsb_2027_2'],
                'RPED_2027_2'=>$row['rped_2027_2'],
                'SGR_2027_2'=>$row['sgr_2027_2'],
                'CR_2027_2'=>$row['cr_2027_2'],
                'G_2027_2'=>$row['g_2027_2'],
                'CO_2027_2'=>$row['co_2027_2'],
                'OR_2027_2'=>$row['or_2027_2'],
                'ICLD_2027_3'=>$row['icld_2027_3'],
                'ICDE_2027_3'=>$row['icde_2027_3'],
                'SGPE_2027_3'=>$row['sgpe_2027_3'],
                'SGPS_2027_3'=>$row['sgps_2027_3'],
                'SGPAPSB_2027_3'=>$row['sgpapsb_2027_3'],
                'RPED_2027_3'=>$row['rped_2027_3'],
                'SGR_2027_3'=>$row['sgr_2027_3'],
                'CR_2027_3'=>$row['cr_2027_3'],
                'G_2027_3'=>$row['g_2027_3'],
                'CO_2027_3'=>$row['co_2027_3'],
                'OR_2027_3'=>$row['or_2027_3'],
                'ICLD_2027_4'=>$row['icld_2027_4'],
                'ICDE_2027_4'=>$row['icde_2027_4'],
                'SGPE_2027_4'=>$row['sgpe_2027_4'],
                'SGPS_2027_4'=>$row['sgps_2027_4'],
                'SGPAPSB_2027_4'=>$row['sgpapsb_2027_4'],
                'RPED_2027_4'=>$row['rped_2027_4'],
                'SGR_2027_4'=>$row['sgr_2027_4'],
                'CR_2027_4'=>$row['cr_2027_4'],
                'G_2027_4'=>$row['g_2027_4'],
                'CO_2027_4'=>$row['co_2027_4'],
                'OR_2027_4'=>$row['or_2027_4'],
                'estado_pf' => $row['estado_pf'],
                'created_at' => now(),  // Fecha y hora actual
                'updated_at' => now(),  // Fecha y hora actual
            ]);
            $this->cantidadNuevos++; // Incrementar el contador de registros nuevos
        } else {
            $this->cantidadExistentes++; // Incrementar el contador de registros existentes
        }
        return null;
    }
}
