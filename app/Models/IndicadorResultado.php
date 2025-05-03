<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndicadorResultado extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_ir',
        'nombre_ir',
        'linea_ir',
        'fuente_ir',
        'meta_ir',
        'transformacion_ir',
        'id_mr',
        'id_mo',
        'estado_ir',
    ];

    public function metas_ods(): BelongsTo {
        return $this->belongsTo(MetaOds::class, 'id_mo', 'id');
    }

    public function medidas(): BelongsTo {
        return $this->belongsTo(MedidaResultado::class, 'id_mr', 'id');
    }
}