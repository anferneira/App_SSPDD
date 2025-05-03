<?php

namespace App\Imports;

use App\Models\Actividad;
use App\Models\Dependencia;
use App\Models\IndicadorProducto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportActividad implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // Variables para contar los registros procesados
    public $cantidadNuevos = 0;
    public $cantidadExistentes = 0;
    private $existe = true;
    
    public function model(array $row)
    {
        //ini_set('max_execution_time', 3600);
        // Verifica si existe alguna relación
        $relacion1 = IndicadorProducto::find($row['id_ip']);
        $relacion2 = Dependencia::find($row['id_dep']);
        if ($relacion1 && $relacion2) {
            // Verificar si el registro ya existe
            $existe = Actividad::where('codigo_a', $row['codigo_a'])
                                ->where('nombre_a', $row['nombre_a'])
                                ->where('id_ip', $row['id_ip'])
                                ->where('id_dep', $row['id_dep'])
                                ->where('anio_a', $row['anio_a'])
                                ->where('trimestre_a', $row['trimestre_a'])
                                ->where('meta_a', $row['meta_a'])
                                ->where('aporte_a', $row['aporte_a'])
                                ->where('estado_a', $row['estado_a'])
                                ->exists();

            if (!$existe) {
                // Crear el registro si no existe
                Actividad::create([
                    'codigo_a' => $row['codigo_a'],
                    'nombre_a' => $row['nombre_a'],
                    'id_ip' => $row['id_ip'],
                    'id_dep' => $row['id_dep'],
                    'anio_a' => $row['anio_a'],
                    'trimestre_a' => $row['trimestre_a'],
                    'meta_a' => $row['meta_a'],
                    'aporte_a' => $row['aporte_a'],
                    'estado_a' => $row['estado_a'],
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
