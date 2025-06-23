<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogroIndicador extends Model
{
    use HasFactory;

    protected $fillable = [
        'logro',
        'anio_lip',
        'trimestre_lip',
        'id_ip',
        'estado_lip',
    ];

    public function logros(): BelongsTo {
        return $this->belongsTo(IndicadorProducto::class, 'id_ip', 'id');
    }
}
