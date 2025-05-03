<?php

namespace App\Imports;

use App\Models\IndicadorProducto;
use App\Models\AvanceEstrategico;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportAvaEst implements ToModel, WithHeadingRow
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
            $existe = AvanceEstrategico::where('id_ip', $row['id_ip'])
                                ->where('avance_ae', $row['avance_ae'])
                                ->where('anio_ae', $row['anio_ae'])
                                ->where('trimestre_ae', $row['trimestre_ae'])
                                ->where('estado_ae', $row['estado_ae'])                
                                ->exists();
        }

        //dd($row);

        if (!$existe) {
            // Crear el registro si no existe
            AvanceEstrategico::create([
                'id_ip' => $row['id_ip'],
                'avance_ae' => $row['avance_ae'],
                'anio_ae' => $row['anio_ae'],
                'trimestre_ae' => $row['trimestre_ae'],
                'estado_ae' => $row['estado_ae'],
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
