<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evidencias extends Model
{
    use HasFactory;

    protected $fillable = [
        'evidencia',
        'anio_eip',
        'trimestre_eip',
        'estado_e',
        'id_ip',
    ];

    public function evidencias(): BelongsTo {
        return $this->belongsTo(IndicadorProducto::class, 'id_ip', 'id');
    }
}
