<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DimensionPobreza extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_dp',
        'codigo_dp',
        'estado_dp',
    ];

    public function dimension(): HasMany {
        return $this->HasMany(VariablePobreza::class, 'id');
    }
}
