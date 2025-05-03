<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_a',
        'nombre_a',
        'descripcion_a',
        'objetivo_a',
        'estado_a',
        'id_d',
    ];

    public function dimension(): BelongsTo {
        return $this->belongsTo(Dimension::class, 'id_d', 'id');
    }

    public function apuesta(): HasMany {
        return $this->HasMany(Indicador::class, 'id');
    }
}
