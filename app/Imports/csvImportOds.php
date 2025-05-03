<?php

namespace App\Imports;

use App\Models\Ods;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportOds implements ToModel, WithHeadingRow
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
        $existe = Ods::where('nombre_ods', $row['nombre_ods'])
                            ->where('estado_ods', $row['estado_ods'])
                            ->where('codigo_ods', $row['codigo_ods'])
                            ->exists();

        if (!$existe) {
            // Crear el registro si no existe
            Ods::create([
                'codigo_ods' => $row['codigo_ods'],
                'nombre_ods' => $row['nombre_ods'],
                'estado_ods' => $row['estado_ods'],
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
