<?php

namespace App\Imports;

use App\Models\VariablePobreza;
use App\Models\DimensionPobreza;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportVarPobreza implements ToModel, WithHeadingRow
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
        $relacion = DimensionPobreza::find($row['id_dp']);
        if ($relacion) {
            // Verificar si el registro ya existe
            $existe = VariablePobreza::where('nombre_vp', $row['nombre_vp'])
                                ->where('id_dp', $row['id_dp'])
                                ->where('estado_vp', $row['estado_vp'])
                                ->exists();
        }

        if (!$existe) {
            // Crear el registro si no existe
            VariablePobreza::create([
                'nombre_vp' => $row['nombre_vp'],
                'id_dp' => $row['id_dp'],
                'estado_vp' => $row['estado_vp'],
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