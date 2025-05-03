<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetaOds extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_mo',
        'nombre_mo',
        'id_ods',
        'estado_mo',
    ];

    public function ods(): BelongsTo {
        return $this->belongsTo(Ods::class, 'id_ods', 'id');
    }

    public function metas_ods(): HasMany {
        return $this->HasMany(IndicadorResultado::class, 'id');
    }

    public function meta_ods(): HasMany {
        return $this->HasMany(IndicadorProductoMetaOds::class, 'id');
    }
}
