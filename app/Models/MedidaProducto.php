<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedidaProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        'medido_mp',
        'unidad_mp',
        'estado_mp',
    ];

    public function medidas(): HasMany {
        return $this->HasMany(IndicadorResultado::class, 'id');
    }
}
