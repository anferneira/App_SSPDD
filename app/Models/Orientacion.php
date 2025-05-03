<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orientacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_or',
        'estado_or',
    ];

    public function orientacion(): HasMany {
        return $this->HasMany(IndicadorProducto::class, 'id');
    }
}
