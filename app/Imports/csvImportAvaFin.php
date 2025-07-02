<?php

namespace App\Imports;

use App\Models\IndicadorProducto;
use App\Models\AvanceFinanciero;
use App\Models\ProgramarFinanciero;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportAvaFin implements ToModel, WithHeadingRow
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
        $rel = ProgramarFinanciero::find($row['id_pf']);
        $relacion = IndicadorProducto::where('id', $rel->id_ip);
        if ($relacion) {
            // Verificar si el registro ya existe
            $existe = AvanceFinanciero::where('id_pf', $row['id_pf'])
                                ->where('anio_af', $row['anio_af'])
                                ->where('trimestre_af', $row['trimestre_af'])
                                ->where('bpin_af', $row['bpin_af'])
                                ->where('ICLD', $row['icld'])
                                ->where('ICDE', $row['icde'])
                                ->where('SGPE', $row['sgpe'])
                                ->where('SGPS', $row['sgps'])
                                ->where('SGPAPSB', $row['sgpapsb'])
                                ->where('RPED', $row['rped'])
                                ->where('SGR', $row['sgr'])
                                ->where('CR', $row['cr'])
                                ->where('G', $row['g'])
                                ->where('CO', $row['co'])
                                ->where('OR', $row['or'])
                                ->where('logro_af', $row['logro_af'])
                                ->where('estado_af', $row['estado_af'])
                                ->exists();
        }

        //dd($row);

        if (!$existe) {
            // Crear el registro si no existe
            AvanceFinanciero::create([
                'id_pf' => $row['id_pf'],
                'anio_af' => $row['anio_af'],
                'trimestre_af' => $row['trimestre_af'],
                'bpin_af' => $row['bpin_af'],
                'ICLD'=>$row['icld'],
                'ICDE'=>$row['icde'],
                'SGPE'=>$row['sgpe'],
                'SGPS'=>$row['sgps'],
                'SGPAPSB'=>$row['sgpapsb'],
                'RPED'=>$row['rped'],
                'SGR'=>$row['sgr'],
                'CR'=>$row['cr'],
                'G'=>$row['g'],
                'CO'=>$row['co'],
                'OR'=>$row['or'],
                'logro_af'=>$row['logro_af'],
                'estado_af'=>$row['estado_af'],
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
