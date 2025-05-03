<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedidaResultado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_mr',
        'estado_mr',
    ];

    public function medidas(): HasMany {
        return $this->HasMany(IndicadorResultado::class, 'id');
    }
}
