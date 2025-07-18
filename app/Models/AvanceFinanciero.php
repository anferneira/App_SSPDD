<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AvanceFinanciero extends Model
{
    use HasFactory;

    protected $fillable = [
        'ICLD', 'ICDE', 'SGPE', 'SGPS', 'SGPAPSB',
        'RPED', 'SGR', 'CR', 'G', 'CO', 'OR',
        'estado_af', 'anio_af', 'trimestre_af',
        'id_pf', 'bpin_af', 'logro_af'
    ];

    public function indproducto1(): BelongsTo {
        return $this->belongsTo(IndicadorProducto::class, 'id_ip', 'id');
    }

    public function avancefin(): BelongsTo {
        return $this->belongsTo(ProgramarFinanciero::class, 'id_pf', 'id');
    }
}