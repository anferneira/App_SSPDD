<?php

namespace App\Imports;

use App\Models\Rol;
use App\Models\User;
use App\Models\Dependencia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class csvImportUsuario implements ToModel, WithHeadingRow
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
        $relacion1 = Dependencia::find($row['id_d']);
        $relacion2 = Rol::find($row['id_r']);
        if ($relacion1 && $relacion2) {
            // Verificar si el registro ya existe
            $existe = User::where('name', $row['name'])
                                ->where('email', $row['email'])
                                ->where('password', bcrypt($row['password']))
                                ->where('estado_u', $row['estado_u'])
                                ->where('id_r', $row['id_r'])
                                ->where('id_d', $row['id_d'])
                                ->exists();
        }

        if (!$existe) {
            // Crear el registro si no existe
            User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'email_verified_at' => $row['email_verified_at'],
                'password' => bcrypt($row['password']),
                'estado_u' => $row['estado_u'],
                'id_r' => $row['id_r'],
                'id_d' => $row['id_d'],
                'remember_token' => $row['remember_token'],
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
