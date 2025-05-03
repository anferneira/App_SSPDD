<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dimension extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_d',
        'nombre_d',
        'estado_d',
        'id_e',
    ];

    public function estrategia_dimension(): BelongsTo {
        return $this->belongsTo(Estrategia::class, 'id_e', 'id');
    }

    public function dimension(): HasMany {
        return $this->HasMany(Apuesta::class, 'id');
    }
}
