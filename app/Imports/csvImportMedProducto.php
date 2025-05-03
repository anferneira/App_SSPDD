<?php

namespace App\Imports;

use App\Models\MedidaProducto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportMedProducto implements ToModel, WithHeadingRow
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
        // Verificar si el registro ya existe
        $existe = MedidaProducto::where('medido_mp', $row['medido_mp'])
                            ->where('unidad_mp', $row['unidad_mp'])
                            ->where('estado_mp', $row['estado_mp'])
                            ->exists();

        if (!$existe) {
            // Crear el registro si no existe
            MedidaProducto::create([
                'medido_mp' => $row['medido_mp'],
                'unidad_mp' => $row['unidad_mp'],
                'estado_mp' => $row['estado_mp'],
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
