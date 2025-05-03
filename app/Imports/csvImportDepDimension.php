<?php

namespace App\Imports;

use App\Models\DependenciaDimension;
use App\Models\Dependencia;
use App\Models\Dimension;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportDepDimension implements ToModel, WithHeadingRow
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
        //dd($row['id_Dimension']);
        // Convertir `id_Dimension` en un array separado por comas
        $id_Dimensiones = array_map('trim', explode(',', $row['id_dim'])); // Elimina espacios innecesarios
        
        foreach ($id_Dimensiones as $idd) {
            // Verifica si existe alguna relación
            $relacion1 = Dependencia::where('id', $row['id_dep']);
            $relacion2 = Dimension::where('id', $idd);
            
            if ($relacion1 && $relacion2) {
                // Verificar si el registro ya existe
                $existe = DependenciaDimension::where('id_dep', $row['id_dep'])
                                    ->where('id_dim', $idd)
                                    ->where('estado_dd', $row['estado_dd'])
                                    ->exists();
            }

            if (!$existe) {
                // Crear el registro si no existe
                DependenciaDimension::create([
                    'id_dep' => $row['id_dep'],
                    'id_dim' => $idd,
                    'estado_dd' => $row['estado_dd'],
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