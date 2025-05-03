<?php

namespace App\Imports;

use App\Models\Estrategia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportEstrategia implements ToModel, WithHeadingRow
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
        $existe = Estrategia::where('codigo_e', $row['codigo_e'])
                            ->where('nombre_e', $row['nombre_e'])
                            ->where('estado_e', $row['estado_e'])
                            ->exists();

        if (!$existe) {
            // Crear el registro si no existe
            Estrategia::create([
                'codigo_e' => $row['codigo_e'],
                'nombre_e' => $row['nombre_e'],
                'estado_e' => $row['estado_e'],
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
