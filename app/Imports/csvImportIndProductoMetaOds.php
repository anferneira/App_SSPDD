<?php

namespace App\Imports;

use App\Models\IndicadorProductoMetaOds;
use App\Models\IndicadorProducto;
use App\Models\MetaOds;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportIndProductoMetaOds implements ToModel, WithHeadingRow
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
        $id_mods = array_map('trim', explode(',', $row['id_mo'])); // Elimina espacios innecesarios
        foreach ($id_mods as $id_mod) {
            $relacion1 = IndicadorProducto::where('id', $row['id_ip']);
            $relacion2 = MetaOds::where('id', $id_mod);
            if ($relacion1 && $relacion2) {
                // Verificar si el registro ya existe
                $existe = IndicadorProductoMetaOds::where('id_ip', $row['id_ip'])
                                    ->where('id_mo', $id_mod)
                                    ->where('estado_imo', $row['estado_imo'])                
                                    ->exists();
            }

            //dd($row);

            if (!$existe) {
                // Crear el registro si no existe
                IndicadorProductoMetaOds::create([
                    'id_ip' => $row['id_ip'],
                    'id_mo' => $id_mod,
                    'estado_imo' => $row['estado_imo'],
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