<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IndicadorMga extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_mga',
        'producto_mga',
        'estado_mga',
    ];

    public function mga(): HasMany {
        return $this->HasMany(Indicador::class, 'id');
    }
}
