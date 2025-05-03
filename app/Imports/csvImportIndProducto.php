<?php

namespace App\Imports;

use App\Models\IndicadorProducto;
use App\Models\IndicadorResultado;
use App\Models\Dependencia;
use App\Models\MedidaProducto;
use App\Models\Apuesta;
use App\Models\Sector;
use App\Models\Programa;
use App\Models\IndicadorMga;
use App\Models\Orientacion;
use App\Models\VariablePobreza;
use App\Models\Logro;
use App\Models\Edpm;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportIndProducto implements ToModel, WithHeadingRow
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
        //dd($row); // Inspeccionar los datos antes de procesarlos
        // Verifica si existe alguna relación
        $relacion1 = Dependencia::where('id', $row['id_d']);
        $relacion2 = Apuesta::where('id', $row['id_a']);
        $relacion3 = Sector::where('id', $row['id_s']);
        $relacion4 = Programa::where('id', $row['id_p']);
        $relacion5 = IndicadorMga::where('id', $row['id_mga']);
        $relacion6 = MedidaProducto::where('id', $row['id_mp']);
        $relacion7 = Orientacion::where('id', $row['id_o']);
        $relacion8 = VariablePobreza::where('id', $row['id_vp']);
        $relacion9 = Logro::where('id', $row['id_lu']);
        $relacion10 = Edpm::where('id', $row['id_edpm']);
        $relacion11 = IndicadorResultado::where('id', $row['id_ir']);
        if ($relacion1 && $relacion2 && $relacion3 && $relacion4 && $relacion5 && $relacion6 && $relacion7 && $relacion8 && $relacion9 && $relacion10 && $relacion11) {
            // Verificar si el registro ya existe
            $existe = IndicadorProducto::where('codigo_ip', $row['codigo_ip'])
                                ->where('nombre_ip', $row['nombre_ip'])
                                ->where('descripcion_ip', $row['descripcion_ip'])
                                ->where('id_ir', $row['id_ir'])
                                ->where('id_d', $row['id_d'])
                                ->where('id_a', $row['id_a'])
                                ->where('id_s', $row['id_s'])
                                ->where('id_p', $row['id_p'])
                                ->where('id_mga', $row['id_mga'])
                                ->where('linea_ip', $row['linea_ip'])
                                ->where('id_mp', $row['id_mp'])
                                ->where('frecuencia_ip', $row['frecuencia_ip'])
                                ->where('fuente_ip', $row['fuente_ip'])
                                ->where('meta_ip', $row['meta_ip'])
                                ->where('abrigo_ip', $row['abrigo_ip'])
                                ->where('id_o', $row['id_o'])
                                ->where('id_vp', $row['id_vp'])
                                ->where('id_lu', $row['id_lu'])
                                ->where('id_edpm', $row['id_edpm'])
                                ->where('meta_ip_real', $row['meta_ip_real'])
                                ->where('estado_ip', $row['estado_ip'])                
                                ->exists();
        }

        if (!$existe) {
            // Crear el registro si no existe
            IndicadorProducto::create([
                'codigo_ip' => $row['codigo_ip'],
                'nombre_ip' => $row['nombre_ip'],
                'descripcion_ip' => $row['descripcion_ip'],
                'id_ir' => $row['id_ir'],
                'id_d' => $row['id_d'],
                'id_a' => $row['id_a'],
                'id_s' => $row['id_s'],
                'id_p' => $row['id_p'],
                'id_mga' => $row['id_mga'],
                'linea_ip' => $row['linea_ip'],
                'id_mp' => $row['id_mp'],
                'frecuencia_ip' => $row['frecuencia_ip'],
                'fuente_ip' => $row['fuente_ip'],
                'meta_ip' => $row['meta_ip'],
                'abrigo_ip' => $row['abrigo_ip'],
                'id_o' => $row['id_o'],
                'id_vp' => $row['id_vp'],
                'id_lu' => $row['id_lu'],
                'id_edpm' => $row['id_edpm'],
                'meta_ip_real' => $row['meta_ip_real'],
                'estado_ip' => $row['estado_ip'],
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