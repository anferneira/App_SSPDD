<?php

namespace App\Imports;

use App\Models\Programa;
use App\Models\Sector;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportPrograma implements ToModel, WithHeadingRow
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
        $relacion = Sector::find($row['id_s']);
        if ($relacion) {
            // Verificar si el registro ya existe
            $existe = Programa::where('nombre_p', $row['nombre_p'])
                                ->where('id_s', $row['id_s'])
                                ->where('estado_p', $row['estado_p'])
                                ->exists();
        }

        if (!$existe) {
            // Crear el registro si no existe
            Programa::create([
                'nombre_p' => $row['nombre_p'],
                'id_s' => $row['id_s'],
                'estado_p' => $row['estado_p'],
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
