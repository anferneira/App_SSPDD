<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AvanceEstrategico extends Model
{
    use HasFactory;

    protected $fillable = [
        'avance_ae',
        'anio_ae',
        'trimestre_ae',
        'estado_ae',
        'id_ip',
    ];

    public function indproducto3(): BelongsTo {
        return $this->belongsTo(IndicadorProducto::class, 'id_ip', 'id');
    }
}