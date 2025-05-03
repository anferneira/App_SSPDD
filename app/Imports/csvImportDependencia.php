<?php

namespace App\Imports;

use App\Models\Dependencia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportDependencia implements ToModel, WithHeadingRow
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
        $existe = Dependencia::where('nombre_d', $row['nombre_d'])
                            ->where('estado_d', $row['estado_d'])
                            ->exists();

        if (!$existe) {
            // Crear el registro si no existe
            Dependencia::create([
                'nombre_d' => $row['nombre_d'],
                'estado_d' => $row['estado_d'],
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
