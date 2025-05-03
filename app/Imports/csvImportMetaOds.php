<?php

namespace App\Imports;

use App\Models\MetaOds;
use App\Models\Ods;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportMetaOds implements ToModel, WithHeadingRow
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
        $relacion = Ods::find($row['id_ods']);
        if ($relacion) {
            // Verificar si el registro ya existe
            $existe = MetaOds::where('codigo_mo', $row['codigo_mo'])
                                ->where('nombre_mo', $row['nombre_mo'])
                                ->where('id_ods', $row['id_ods'])
                                ->where('estado_mo', $row['estado_mo'])
                                ->exists();
        }

        if (!$existe) {
            // Crear el registro si no existe
            MetaOds::create([
                'codigo_mo' => $row['codigo_mo'],
                'nombre_mo' => $row['nombre_mo'],
                'id_ods' => $row['id_ods'],
                'estado_mo' => $row['estado_mo'],
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
