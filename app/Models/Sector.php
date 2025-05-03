<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_s',
        'nombre_s',
        'estado_s',
        'id_d',
    ];

    public function sectordependencia(): BelongsTo {
        return $this->belongsTo(Dependencia::class, 'id_d', 'id');
    }

    public function sectorial(): HasMany {
        return $this->HasMany(Programa::class, 'id');
    }

    public function sector(): HasMany {
        return $this->HasMany(Indicador::class, 'id');
    }
}
