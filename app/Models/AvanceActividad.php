<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AvanceActividad extends Model
{
    use HasFactory;

    protected $fillable = [
        'avance_aa',
        'anio_aa',
        'trimestre_aa',
        'descripcion_aa',
        'estado_aa',
        'id_a',
    ];

    public function actividad(): BelongsTo {
        return $this->belongsTo(Actividad::class, 'id_a', 'id');
    }

    /*public function evidencias(): HasMany {
        return $this->hasMany(Evidencias::class, 'id');
    }*/
}