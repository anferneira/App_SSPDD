<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indicador extends Model
{
    use HasFactory;
    // codigo_interno, nombre, descripcion, medido_a_traves, unidad_medida, frecuencia_reporte, meta_2024_3, meta_2024_4, meta_2024, meta_2025_1, meta_2025_2, meta_2025_3, meta_2025_4, meta_2025, meta_2026_1, meta_2026_2, meta_2026_3, meta_2026_4, meta_2026, meta_2027_1, meta_2027_2, meta_2027_3, meta_2027_4, meta_2027, meta_cuatrenio, plan_abrigo, id_sector, id_mga, id_apuesta, id_tipo_indicador, estado, created_at, updated_at
    protected $fillable = [
        'codigo_interno_indicador',
        'nombre_indicador',
        'descripcion_indicador',
        'medido_a_traves_indicador',
        'unidad_medida_indicador',
        'frecuencia_reporte_indicador',
        'meta_2024_3_indicador',
        'meta_2024_4_indicador',
        'meta_2024_indicador',
        'meta_2025_1_indicador',
        'meta_2025_2_indicador',
        'meta_2025_3_indicador',
        'meta_2025_4_indicador',
        'meta_2025_indicador',
        'meta_2026_1_indicador',
        'meta_2026_2_indicador',
        'meta_2026_3_indicador',
        'meta_2026_4_indicador',
        'meta_2026_indicador',
        'meta_2027_1_indicador',
        'meta_2027_2_indicador',
        'meta_2027_3_indicador',
        'meta_2027_4_indicador',
        'meta_2027_indicador',
        'meta_cuatrenio_indicador',
        'plan_abrigo_indicador',
        'id_sector',
        'id_mga',
        'id_apuesta',
        'id_tipo_indicador',
        'id_dependencia',
        'estado_indicador',
    ];

    public function sector(): BelongsTo {
        return $this->belongsTo(Sector::class, 'id_sector', 'id');
    }

    public function mga(): BelongsTo {
        return $this->belongsTo(IndicadorMga::class, 'id_mga', 'id');
    }

    public function apuesta(): BelongsTo {
        return $this->belongsTo(Apuesta::class, 'id_apuesta', 'id');
    }

    public function tipo_indicador(): BelongsTo {
        return $this->belongsTo(TipoIndicador::class, 'id_tipo_indicador', 'id');
    }

    public function indicadordependencia(): BelongsTo {
        return $this->belongsTo(Dependencia::class, 'id_dependencia', 'id');
    }
}
