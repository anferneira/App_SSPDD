<?php

namespace App\Imports;

use App\Models\IndicadorProducto;
use App\Models\ProgramarEstrategico;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportProEst implements ToModel, WithHeadingRow
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
            $existe = ProgramarEstrategico::where('id_ip', $row['id_ip'])
                                ->where('p2024_3', $row['p2024_3'])
                                ->where('p2024_4', $row['p2024_4'])
                                ->where('p2025_1', $row['p2025_1'])
                                ->where('p2025_2', $row['p2025_2'])
                                ->where('p2025_3', $row['p2025_3'])
                                ->where('p2025_4', $row['p2025_4'])
                                ->where('p2026_1', $row['p2026_1'])
                                ->where('p2026_2', $row['p2026_2'])
                                ->where('p2026_3', $row['p2026_3'])
                                ->where('p2026_4', $row['p2026_4'])
                                ->where('p2027_1', $row['p2027_1'])
                                ->where('p2027_2', $row['p2027_2'])
                                ->where('p2027_3', $row['p2027_3'])
                                ->where('p2027_4', $row['p2027_4'])
                                ->where('calculo', $row['calculo'])
                                ->where('estado_pe', $row['estado_pe'])                
                                ->exists();
        }

        //dd($row);

        if (!$existe) {
            // Crear el registro si no existe
            ProgramarEstrategico::create([
                'id_ip' => $row['id_ip'],
                'p2024_3' => $row['p2024_3'],
                'p2024_4' => $row['p2024_4'],
                'p2025_1' => $row['p2025_1'],
                'p2025_2' => $row['p2025_2'],
                'p2025_3' => $row['p2025_3'],
                'p2025_4' => $row['p2025_4'],
                'p2026_1' => $row['p2026_1'],
                'p2026_2' => $row['p2026_2'],
                'p2026_3' => $row['p2026_3'],
                'p2026_4' => $row['p2026_4'],
                'p2027_1' => $row['p2027_1'],
                'p2027_2' => $row['p2027_2'],
                'p2027_3' => $row['p2027_3'],
                'p2027_4' => $row['p2027_4'],
                'calculo' => $row['calculo'],
                'estado_pe' => $row['estado_pe'],
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
