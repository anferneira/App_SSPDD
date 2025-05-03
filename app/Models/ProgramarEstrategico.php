<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramarEstrategico extends Model
{
    use HasFactory;

    protected $fillable = [
        'p2024_3',
        'p2024_4',
        'p2025_1',
        'p2025_2',
        'p2025_3',
        'p2025_4',
        'p2026_1',
        'p2026_2',
        'p2026_3',
        'p2026_4',
        'p2027_1',
        'p2027_2',
        'p2027_3',
        'p2027_4',
        'calculo',
        'estado_pe',
        'id_ip',
    ];

    public function indproducto2(): BelongsTo {
        return $this->belongsTo(IndicadorProducto::class, 'id_ip', 'id');
    }
}