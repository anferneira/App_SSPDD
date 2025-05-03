<?php

namespace App\Imports;

use App\Models\ProyectoMunicipio;
use App\Models\LineaInversion;
use App\Models\ProyectoConvergencia;
use App\Models\Municipio;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportProMunicipio implements ToModel, WithHeadingRow
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
        $relacion1 = LineaInversion::where('id', $row['id_li']);
        $relacion2 = ProyectoConvergencia::where('id', $row['id_pc']);
        $relacion3 = Municipio::where('id', $row['id_m']);
        if ($relacion1 && $relacion2 && $relacion3) {
            // Verificar si el registro ya existe
            $existe = ProyectoMunicipio::where('id_li', $row['id_li'])
                                ->where('id_pc', $row['id_pc'])
                                ->where('id_m', $row['id_m'])
                                ->where('proyecto_pm', $row['proyecto_pm'])
                                ->where('estado_pm', $row['estado_pm'])
                                ->exists();
        }

        if (!$existe) {
            // Crear el registro si no existe
            ProyectoMunicipio::create([
                'proyecto_pm' => $row['proyecto_pm'],
                'id_li' => $row['id_li'],
                'id_pc' => $row['id_pc'],
                'id_m' => $row['id_m'],
                'estado_pm' => $row['estado_pm'],
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