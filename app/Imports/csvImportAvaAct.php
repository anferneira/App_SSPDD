<?php

namespace App\Imports;

use App\Models\Actividad;
use App\Models\AvanceActividad;
use App\Models\AvanceEstrategico;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportAvaAct implements ToModel, WithHeadingRow
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
        $relacion = Actividad::where('id', $row['id_a']);
        
        if ($relacion) {
            // Verificar si el registro ya existe
            $existe = AvanceActividad::where('id_a', $row['id_a'])
                                ->where('avance_aa', $row['avance_aa'])
                                ->where('anio_aa', $row['anio_aa'])
                                ->where('trimestre_aa', $row['trimestre_aa'])
                                ->where('logro_aa', $row['logro_aa'])
                                ->where('estado_aa', $row['estado_aa'])                
                                ->exists();
        }

        //dd($row);

        if (!$existe) {
            // Crear el registro si no existe
            AvanceActividad::create([
                'id_a' => $row['id_a'],
                'avance_aa' => $row['avance_aa'],
                'anio_aa' => $row['anio_aa'],
                'trimestre_aa' => $row['trimestre_aa'],
                'logro_aa' => $row['logro_aa'],
                'estado_aa' => $row['estado_aa'],
                'created_at' => now(),  // Fecha y hora actual
                'updated_at' => now(),  // Fecha y hora actual
            ]);
            $this->cantidadNuevos++; // Incrementar el contador de registros nuevos
            
            // Obtener el id_ip desde la relación de la actividad
            $relacion = Actividad::where('id', $row['id_a'])->get();
            foreach ($relacion as $r)
                $id_ip = $r->id_ip;

            // Buscar si ya existe un registro de avance_estrategico para ese id_ip, año y trimestre
            $avanceEstrategico = AvanceEstrategico::where('id_ip', $id_ip)
                                ->where('anio_ae', $row['anio_aa'])
                                ->where('trimestre_ae', $row['trimestre_aa'])
                                ->first();

            if ($avanceEstrategico) {
                // Si existe, sumarle el avance actual
                $valorAA = str_replace(',', '.', $row['avance_aa']);
                $avanceActual = str_replace(',', '.', $avanceEstrategico->avance_ae);
                $avanceEstrategico->avance_ae = floatval($avanceActual) + floatval($valorAA);
                $avanceEstrategico->updated_at = now();
                $avanceEstrategico->save();
            } else {
                // Si no existe, crear uno nuevo
                AvanceEstrategico::create([
                    'id_ip' => $id_ip,
                    'avance_ae' => $row['avance_aa'],
                    'anio_ae' => $row['anio_aa'],
                    'trimestre_ae' => $row['trimestre_aa'],
                    'estado_ae' => $row['estado_aa'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } else {
            $this->cantidadExistentes++; // Incrementar el contador de registros existentes
        }
        return null;
    }   
}