<?php

namespace App\Imports;

use App\Models\DimensionPobreza;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportDimPobreza implements ToModel, WithHeadingRow
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
        $existe = DimensionPobreza::where('nombre_dp', $row['nombre_dp'])
                            ->where('estado_dp', $row['estado_dp'])
                            ->where('codigo_dp', $row['codigo_dp'])
                            ->exists();

        if (!$existe) {
            // Crear el registro si no existe
            DimensionPobreza::create([
                'codigo_dp' => $row['codigo_dp'],
                'nombre_dp' => $row['nombre_dp'],
                'estado_dp' => $row['estado_dp'],
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
