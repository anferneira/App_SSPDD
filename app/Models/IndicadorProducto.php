<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IndicadorProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_ip',
        'nombre_ip',
        'descripcion_ip',
        'id_ir',
        'id_d',
        'id_a',
        'id_s',
        'id_p',
        'id_mga',
        'linea_ip',
        'id_mp',
        'frecuencia_ip',
        'fuente_ip',
        'meta_ip',
        'abrigo_ip',
        'id_o',
        'id_vp',
        'id_lu',
        'id_edpm',
        'meta_ip_real',
        'estado_ip',
    ];

    public function dependencia(): BelongsTo {
        return $this->belongsTo(Dependencia::class, 'id_d', 'id');
    }

    public function apuesta(): BelongsTo {
        return $this->belongsTo(Apuesta::class, 'id_a', 'id');
    }

    public function programa(): BelongsTo {
        return $this->belongsTo(Programa::class, 'id_p', 'id');
    }

    public function mga(): BelongsTo {
        return $this->belongsTo(IndicadorMga::class, 'id_mga', 'id');
    }

    public function medida(): BelongsTo {
        return $this->belongsTo(MedidaProducto::class, 'id_mp', 'id');
    }

    public function meta_ods(): BelongsTo {
        return $this->belongsTo(MetaOds::class, 'id_mo', 'id');
    }

    public function orientar(): BelongsTo {
        return $this->belongsTo(Orientacion::class, 'id_o', 'id');
    }

    public function variable(): BelongsTo {
        return $this->belongsTo(VariablePobreza::class, 'id_vp', 'id');
    }

    public function logro(): BelongsTo {
        return $this->belongsTo(Logro::class, 'id_lu', 'id');
    }

    public function edpm(): BelongsTo {
        return $this->belongsTo(Edpm::class, 'id_edpm', 'id');
    }

    public function resultado(): BelongsTo {
        return $this->belongsTo(IndicadorResultado::class, 'id_ir', 'id');
    }

    public function producto(): HasMany {
        return $this->HasMany(Actividad::class, 'id');
    }

    public function productos(): HasMany {
        return $this->HasMany(IndicadorProductoMetaOds::class, 'id');
    }

    public function indproducto(): HasMany {
        return $this->HasMany(ProgramarFinanciero::class, 'id_ip', 'id');
    }

    public function indproducto1(): HasMany {
        return $this->HasMany(AvanceFinanciero::class, 'id');
    }

    public function indproducto2(): HasMany {
        return $this->hasMany(ProgramarEstrategico::class, 'id');
    }

    public function indproducto3(): HasMany {
        return $this->hasMany(AvanceEstrategico::class, 'id_ip', 'id');
    }

    public function evidencias(): HasMany {
        return $this->hasMany(Evidencias::class, 'id');
    }

    public function logros(): HasMany {
        return $this->hasMany(LogroIndicador::class, 'id');
    }
}
