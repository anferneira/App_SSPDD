<?php

namespace App\Imports;

use App\Models\Edpm;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportEdpm implements ToModel, WithHeadingRow
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
        $existe = Edpm::where('nombre_edpm', $row['nombre_edpm'])
                            ->where('programa_edpm', $row['programa_edpm'])
                            ->where('estado_edpm', $row['estado_edpm'])
                            ->exists();

        if (!$existe) {
            // Crear el registro si no existe
            Edpm::create([
                'nombre_edpm' => $row['nombre_edpm'],
                'programa_edpm' => $row['programa_edpm'],
                'estado_edpm' => $row['estado_edpm'],
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
