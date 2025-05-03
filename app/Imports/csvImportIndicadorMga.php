<?php

namespace App\Imports;

use App\Models\IndicadorMga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportIndicadorMga implements ToModel, WithHeadingRow
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
        $existe = IndicadorMga::where('codigo_mga', $row['codigo_mga'])
                            ->where('producto_mga', $row['producto_mga'])
                            ->where('estado_mga', $row['estado_mga'])
                            ->exists();

        if (!$existe) {
            // Crear el registro si no existe
            IndicadorMga::create([
                'codigo_mga' => $row['codigo_mga'],
                'producto_mga' => $row['producto_mga'],
                'estado_mga' => $row['estado_mga'],
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
