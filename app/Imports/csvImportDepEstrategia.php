<?php

namespace App\Imports;

use App\Models\DependenciaEstrategia;
use App\Models\Dependencia;
use App\Models\Estrategia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportDepEstrategia implements ToModel, WithHeadingRow
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
        //dd($row['id_estrategia']);
        // Convertir `id_estrategia` en un array separado por comas
        $id_estrategias = array_map('trim', explode(',', $row['id_e'])); // Elimina espacios innecesarios
        
        foreach ($id_estrategias as $ide) {
            // Verifica si existe alguna relación
            $relacion1 = Dependencia::where('id', $row['id_d']);
            $relacion2 = Estrategia::where('id', $ide);
            if ($relacion1 && $relacion2) {
                // Verificar si el registro ya existe
                $existe = DependenciaEstrategia::where('id_d', $row['id_d'])
                                    ->where('id_e', $ide)
                                    ->where('estado_de', $row['estado_de'])
                                    ->exists();
            }

            if (!$existe) {
                // Crear el registro si no existe
                DependenciaEstrategia::create([
                    'id_d' => $row['id_d'],
                    'id_e' => $ide,
                    'estado_de' => $row['estado_de'],
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