<?php

namespace App\Imports;

use App\Models\GrupoPoblacion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportGruPoblacion implements ToModel, WithHeadingRow
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
        
        // Verificar si el registro ya existe
        $existe = GrupoPoblacion::where('codigo_gp', $row['codigo_gp'])
                            ->where('nombre_gp', $row['nombre_gp'])
                            ->where('estado_gp', $row['estado_gp'])
                            ->exists();
        
        if (!$existe) {
            // Crear el registro si no existe
            GrupoPoblacion::create([
                'codigo_gp' => $row['codigo_gp'],
                'nombre_gp' => $row['nombre_gp'],
                'estado_gp' => $row['estado_gp'],
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
