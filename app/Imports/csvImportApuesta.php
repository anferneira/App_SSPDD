<?php

namespace App\Imports;

use App\Models\Apuesta;
use App\Models\Dimension;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportApuesta implements ToModel, WithHeadingRow
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
        $relacion = Dimension::find($row['id_d']);
        if ($relacion) {
            // Verificar si el registro ya existe
            $existe = Apuesta::where('codigo_a', $row['codigo_a'])
                                ->where('nombre_a', $row['nombre_a'])
                                ->where('objetivo_a', $row['objetivo_a'])
                                ->where('estado_a', $row['estado_a'])
                                ->where('id_d', $row['id_d'])
                                ->exists();
        }

        if (!$existe) {
            // Crear el registro si no existe
            Apuesta::create([
                'codigo_a' => $row['codigo_a'],
                'nombre_a' => $row['nombre_a'],
                'objetivo_a' => $row['objetivo_a'],
                'estado_a' => $row['estado_a'],
                'id_d' => $row['id_d'],
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
