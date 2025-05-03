<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DependenciaApuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dep',
        'id_apu',
        'estado_da',
    ];

    public function dependenciasss(): BelongsTo {
        return $this->belongsTo(Dependencia::class, 'id_dep', 'id');
    }

    public function Apuestas(): BelongsTo {
        return $this->belongsTo(Apuesta::class, 'id_apu', 'id');
    }
}
