<?php

namespace App\Imports;

use App\Models\Provincia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportProvincia implements ToModel, WithHeadingRow
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
        $existe = Provincia::where('nombre_p', $row['nombre_p'])
                            ->where('estado_p', $row['estado_p'])
                            ->exists();

        if (!$existe) {
            // Crear el registro si no existe
            Provincia::create([
                'nombre_p' => $row['nombre_p'],
                'estado_p' => $row['estado_p'],
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
