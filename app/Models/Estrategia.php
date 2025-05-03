<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estrategia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_e',
        'codigo_e',
        'estado_e',
    ];

    public function estrategias(): HasMany {
        return $this->HasMany(DependenciaEstrategia::class, 'id');
    }

    public function estrategia_dimension(): HasMany {
        return $this->HasMany(Dimension::class, 'id');
    }
}
