<?php

namespace App\Imports;

use App\Models\IndicadorProducto;
use App\Models\LogroIndicador;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportLogroIP implements ToModel, WithHeadingRow
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
        $logroLimpio = preg_replace('/\s+/', ' ', trim($row['logro'])); // 👈 limpieza
        $relacion = IndicadorProducto::where('id', $row['id_ip']);
        
        if ($relacion) {
            // Verificar si el registro ya existe
            $existe = LogroIndicador::where('logro', $logroLimpio)
                                ->where('anio_lip', $row['anio_lip'])
                                ->where('trimestre_lip', $row['trimestre_lip'])
                                ->where('id_ip', $row['id_ip'])
                                ->where('estado_lip', $row['estado_lip'])                
                                ->exists();
        }

        if (!$existe) {
            // Crear el registro si no existe
            LogroIndicador::create([
                'logro' => $logroLimpio,
                'anio_lip' => $row['anio_lip'],
                'trimestre_lip' => $row['trimestre_lip'],
                'id_ip' => $row['id_ip'],
                'estado_lip' => $row['estado_lip'],
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