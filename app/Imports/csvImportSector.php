<?php

namespace App\Imports;

use App\Models\Sector;
use App\Models\Dependencia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportSector implements ToModel, WithHeadingRow
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
        // Verifica si existe alguna relación
        $relacion = Dependencia::find($row['id_d']);
        if ($relacion) {
            // Verificar si el registro ya existe
            $existe = Sector::where('codigo_s', $row['codigo_s'])
                                ->where('nombre_s', $row['nombre_s'])
                                ->where('id_d', $row['id_d'])
                                ->where('estado_s', $row['estado_s'])
                                ->exists();
        }

        if (!$existe) {
            // Crear el registro si no existe
            Sector::create([
                'codigo_s' => $row['codigo_s'],
                'nombre_s' => $row['nombre_s'],
                'id_d' => $row['id_d'],
                'estado_s' => $row['estado_s'],
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
