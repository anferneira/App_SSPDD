<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_m',
        'nombre_m',
        'longitud_m',
        'latitud_m',
        'estado_m',
        'id_p',
    ];

    public function provincia(): BelongsTo {
        return $this->belongsTo(Provincia::class, 'id_p', 'id');
    }

    public function municipios(): HasMany {
        return $this->HasMany(Poblacion::class, 'id');
    }
}
