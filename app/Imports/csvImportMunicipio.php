<?php

namespace App\Imports;

use App\Models\Municipio;
use App\Models\Provincia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportMunicipio implements ToModel, WithHeadingRow
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
        // Dividir los valores en cada índice
        /*$datos1 = explode(';', $row[0]);
        $datos2 = explode(';', $row[1]);
        $datos3 = explode(';', $row[2]);
        
        $codigo = str_replace(',', '.', $datos1[0]); // Reemplaza coma por punto decimal
        $nombre = $datos1[1];
        $latitud = $datos1[2].'.'.$datos2[0];
        $longitud = $datos2[1].'.'.$datos3[0];
        $id_p = $datos3[1];
        $estado = $datos3[2];*/

        // Verifica si existe alguna relación
        $relacion = Provincia::find($row['id_p']);
        if ($relacion) {
            // Verificar si el registro ya existe
            $existe = Municipio::where('codigo_m', $row['codigo_m'])
                                ->where('nombre_m', $row['nombre_m'])
                                ->where('latitud_m', $row['latitud_m'])
                                ->where('longitud_m', $row['longitud_m'])
                                ->where('id_p', $row['id_p'])
                                ->where('estado_m', $row['estado_m'])
                                ->exists();
        }

        if (!$existe) {
            // Crear el registro si no existe
            Municipio::create([
                'codigo_m' => $row['codigo_m'],
                'nombre_m' => $row['nombre_m'],
                'latitud_m' => $row['latitud_m'],
                'longitud_m' => $row['longitud_m'],
                'id_p' => $row['id_p'],
                'estado_m' => $row['estado_m'],
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
