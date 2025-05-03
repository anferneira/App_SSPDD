<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProyectoMunicipio extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_li',
        'id_pc',
        'id_m',
        'proyecto_pm',
        'estado_pm',
    ];

    public function linea_inversion(): BelongsTo {
        return $this->belongsTo(LineaInversion::class, 'id_li', 'id');
    }

    public function proyecto_convergencia(): BelongsTo {
        return $this->belongsTo(ProyectoConvergencia::class, 'id_pc', 'id');
    }

    public function municipio(): BelongsTo {
        return $this->belongsTo(Municipio::class, 'id_m', 'id');
    }
}
