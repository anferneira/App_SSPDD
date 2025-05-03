<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DependenciaEstrategia extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_d',
        'id_e',
        'estado_de',
    ];

    public function dependencias(): BelongsTo {
        return $this->belongsTo(Dependencia::class, 'id_d', 'id');
    }

    public function estrategias(): BelongsTo {
        return $this->belongsTo(Estrategia::class, 'id_e', 'id');
    }
}
