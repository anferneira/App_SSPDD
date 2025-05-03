<?php

namespace App\Imports;

use App\Models\Logro;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportLogro implements ToModel, WithHeadingRow
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
        $existe = Logro::where('nombre_lu', $row['nombre_lu'])
                            ->where('estado_lu', $row['estado_lu'])
                            ->where('codigo_lu', $row['codigo_lu'])
                            ->exists();

        if (!$existe) {
            // Crear el registro si no existe
            Logro::create([
                'codigo_lu' => $row['codigo_lu'],
                'nombre_lu' => $row['nombre_lu'],
                'estado_lu' => $row['estado_lu'],
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
