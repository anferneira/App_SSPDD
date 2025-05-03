<?php

namespace App\Imports;

use App\Models\IndicadorResultado;
use App\Models\MetaOds;
use App\Models\MedidaResultado;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportIndResultado implements ToModel, WithHeadingRow
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
        $id_mods = array_map('trim', explode(',', $row['id_mo'])); // Elimina espacios innecesarios
        
        foreach ($id_mods as $idmod) {
            // Verifica si existe alguna relación
            $relacion1 = MedidaResultado::where('id', $row['id_mr']);
            $relacion2 = MetaOds::where('id', $idmod);
            if ($relacion1 && $relacion2) {
                // Verificar si el registro ya existe
                $existe = IndicadorResultado::where('codigo_ir', $row['codigo_ir'])
                                    ->where('nombre_ir', $row['nombre_ir'])
                                    ->where('linea_ir', $row['linea_ir'])
                                    ->where('fuente_ir', $row['fuente_ir'])
                                    ->where('meta_ir', $row['meta_ir'])
                                    ->where('transformacion_ir', $row['transformacion_ir'])
                                    ->where('id_mr', $row['id_mr'])
                                    ->where('id_mo', $idmod)
                                    ->where('estado_ir', $row['estado_ir'])
                                    ->exists();
            }

            //dd($row);

            if (!$existe) {
                // Crear el registro si no existe
                IndicadorResultado::create([
                    'codigo_ir' => $row['codigo_ir'],
                    'nombre_ir' => $row['nombre_ir'],
                    'linea_ir' => $row['linea_ir'],
                    'fuente_ir' => $row['fuente_ir'],
                    'meta_ir' => $row['meta_ir'],
                    'transformacion_ir' => $row['transformacion_ir'],
                    'id_mr' => $row['id_mr'],
                    'id_mo' => $idmod,
                    'estado_ir' => $row['estado_ir'],
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