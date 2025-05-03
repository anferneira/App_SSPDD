<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndicadorProductoMetaOds extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_ip',
        'id_mo',
        'estado_imo',
    ];

    public function producto(): BelongsTo {
        return $this->belongsTo(IndicadorProducto::class, 'id_ip', 'id');
    }

    public function meta_ods(): BelongsTo {
        return $this->belongsTo(MetaOds::class, 'id_mo', 'id');
    }
}
