<?php

namespace App\Imports;

use App\Models\Dimension;
use App\Models\Estrategia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportDimension implements ToModel, WithHeadingRow
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
        $relacion = Estrategia::find($row['id_e']);
        if ($relacion) {
            // Verificar si el registro ya existe
            $existe = Dimension::where('codigo_d', $row['codigo_d'])
                                ->where('nombre_d', $row['nombre_d'])
                                ->where('id_e', $row['id_e'])
                                ->where('estado_d', $row['estado_d'])
                                ->exists();
        }

        if (!$existe) {
            // Crear el registro si no existe
            Dimension::create([
                'codigo_d' => $row['codigo_d'],
                'nombre_d' => $row['nombre_d'],
                'id_e' => $row['id_e'],
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
