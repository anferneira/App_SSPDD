<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Actividad extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_a',
        'nombre_a',
        'anio_a',
        'trimestre_a',
        'meta_a',
        'aporte_a',
        'estado_a',
        'id_ip',
        'id_dep',
    ];

    public function producto(): BelongsTo {
        return $this->belongsTo(IndicadorProducto::class, 'id_ip', 'id');
    }

    public function avanceactividad(): HasMany {
        return $this->hasMany(AvanceActividad::class, 'id');
    }
}
