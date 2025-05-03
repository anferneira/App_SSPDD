<?php

namespace App\Imports;

use App\Models\DependenciaApuesta;
use App\Models\Dependencia;
use App\Models\Apuesta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportDepApuesta implements ToModel, WithHeadingRow
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
        //dd($row['id_Apuesta']);
        // Convertir `id_Apuesta` en un array separado por comas
        $id_Apuestas = array_map('trim', explode(',', $row['id_apu'])); // Elimina espacios innecesarios
        
        foreach ($id_Apuestas as $ida) {
            // Verifica si existe alguna relación
            $relacion1 = Dependencia::where('id', $row['id_dep']);
            $relacion2 = Apuesta::where('id', $ida);
            if ($relacion1 && $relacion2) {
                // Verificar si el registro ya existe
                $existe = DependenciaApuesta::where('id_dep', $row['id_dep'])
                                    ->where('id_apu', $ida)
                                    ->where('estado_da', $row['estado_da'])
                                    ->exists();
            }

            if (!$existe) {
                // Crear el registro si no existe
                DependenciaApuesta::create([
                    'id_dep' => $row['id_dep'],
                    'id_apu' => $ida,
                    'estado_da' => $row['estado_da'],
                    'created_at' => now(),  // Fecha y hora actual
                    'updated_at' => now(),  // Fecha y hora actual
                ]);
                $this->cantidadNuevos++; // Incrementar el contador de registros nuevos
            } else {
                $this->cantidadExistentes++; // Incrementar el contador de registros existentes
            }
        }

        return null;
    }
}