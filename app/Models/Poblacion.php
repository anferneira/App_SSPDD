<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Poblacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'm_0_5', 'm_6_12', 'm_13_17', 'm_18_29', 'm_30_59', 'm_60',
        'h_0_5', 'h_6_12', 'h_13_17', 'h_18_29', 'h_30_59', 'h_60',
        'beneficio', 'cantidad', 'estado_ap', 'anio_ap', 'trimestre_ap',
        'id_af', 'id_mun', 'id_gp',
    ];

    public function municipios(): BelongsTo {
        return $this->belongsTo(Municipio::class, 'id_mun', 'id');
    }

    public function poblacion(): BelongsTo {
        return $this->belongsTo(GrupoPoblacion::class, 'id_gp', 'id');
    }

    public function avancefin(): BelongsTo {
        return $this->belongsTo(AvanceFinanciero::class, 'id_af', 'id');
    }
}
