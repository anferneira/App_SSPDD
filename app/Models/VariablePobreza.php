<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariablePobreza extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_vp',
        'estado_vp',
        'id_dp',
    ];

    public function dimension(): BelongsTo {
        return $this->belongsTo(DimensionPobreza::class, 'id_dp', 'id');
    }
}