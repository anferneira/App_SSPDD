<?php

namespace App\Imports;

use App\Models\MedidaResultado;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportMedResultado implements ToModel, WithHeadingRow
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
        $existe = MedidaResultado::where('nombre_mr', $row['nombre_mr'])
                            ->where('estado_mr', $row['estado_mr'])
                            ->exists();

        if (!$existe) {
            // Crear el registro si no existe
            MedidaResultado::create([
                'nombre_mr' => $row['nombre_mr'],
                'estado_mr' => $row['estado_mr'],
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
