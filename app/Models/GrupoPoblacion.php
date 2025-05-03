<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GrupoPoblacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_gp',
        'nombre_gp',
        'estado_gp',
    ];

    public function poblacion(): HasMany {
        return $this->HasMany(poblacion::class, 'id');
    }
}
