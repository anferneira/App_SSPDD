<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramarFinanciero extends Model
{
    use HasFactory;

    protected $fillable = [
        'ICLD_2024_3', 'ICDE_2024_3', 'SGPE_2024_3', 'SGPS_2024_3', 'SGPAPSB_2024_3',
        'RPED_2024_3', 'SGR_2024_3', 'CR_2024_3', 'G_2024_3', 'CO_2024_3', 'OR_2024_3',
        'ICLD_2024_4', 'ICDE_2024_4', 'SGPE_2024_4', 'SGPS_2024_4', 'SGPAPSB_2024_4',
        'RPED_2024_4', 'SGR_2024_4', 'CR_2024_4', 'G_2024_4', 'CO_2024_4', 'OR_2024_4',
        'ICLD_2025_1', 'ICDE_2025_1', 'SGPE_2025_1', 'SGPS_2025_1', 'SGPAPSB_2025_1',
        'RPED_2025_1', 'SGR_2025_1', 'CR_2025_1', 'G_2025_1', 'CO_2025_1', 'OR_2025_1',
        'ICLD_2025_2', 'ICDE_2025_2', 'SGPE_2025_2', 'SGPS_2025_2', 'SGPAPSB_2025_2',
        'RPED_2025_2', 'SGR_2025_2', 'CR_2025_2', 'G_2025_2', 'CO_2025_2', 'OR_2025_2',
        'ICLD_2025_3', 'ICDE_2025_3', 'SGPE_2025_3', 'SGPS_2025_3', 'SGPAPSB_2025_3',
        'RPED_2025_3', 'SGR_2025_3', 'CR_2025_3', 'G_2025_3', 'CO_2025_3', 'OR_2025_3',
        'ICLD_2025_4', 'ICDE_2025_4', 'SGPE_2025_4', 'SGPS_2025_4', 'SGPAPSB_2025_4',
        'RPED_2025_4', 'SGR_2025_4', 'CR_2025_4', 'G_2025_4', 'CO_2025_4', 'OR_2025_4',
        'ICLD_2026_1', 'ICDE_2026_1', 'SGPE_2026_1', 'SGPS_2026_1', 'SGPAPSB_2026_1',
        'RPED_2026_1', 'SGR_2026_1', 'CR_2026_1', 'G_2026_1', 'CO_2026_1', 'OR_2026_1',
        'ICLD_2026_2', 'ICDE_2026_2', 'SGPE_2026_2', 'SGPS_2026_2', 'SGPAPSB_2026_2',
        'RPED_2026_2', 'SGR_2026_2', 'CR_2026_2', 'G_2026_2', 'CO_2026_2', 'OR_2026_2',
        'ICLD_2026_3', 'ICDE_2026_3', 'SGPE_2026_3', 'SGPS_2026_3', 'SGPAPSB_2026_3',
        'RPED_2026_3', 'SGR_2026_3', 'CR_2026_3', 'G_2026_3', 'CO_2026_3', 'OR_2026_3',
        'ICLD_2026_4', 'ICDE_2026_4', 'SGPE_2026_4', 'SGPS_2026_4', 'SGPAPSB_2026_4',
        'RPED_2026_4', 'SGR_2026_4', 'CR_2026_4', 'G_2026_4', 'CO_2026_4', 'OR_2026_4',
        'ICLD_2027_1', 'ICDE_2027_1', 'SGPE_2027_1', 'SGPS_2027_1', 'SGPAPSB_2027_1',
        'RPED_2027_1', 'SGR_2027_1', 'CR_2027_1', 'G_2027_1', 'CO_2027_1', 'OR_2027_1',
        'ICLD_2027_2', 'ICDE_2027_2', 'SGPE_2027_2', 'SGPS_2027_2', 'SGPAPSB_2027_2',
        'RPED_2027_2', 'SGR_2027_2', 'CR_2027_2', 'G_2027_2', 'CO_2027_2', 'OR_2027_2',
        'ICLD_2027_3', 'ICDE_2027_3', 'SGPE_2027_3', 'SGPS_2027_3', 'SGPAPSB_2027_3',
        'RPED_2027_3', 'SGR_2027_3', 'CR_2027_3', 'G_2027_3', 'CO_2027_3', 'OR_2027_3',
        'ICLD_2027_4', 'ICDE_2027_4', 'SGPE_2027_4', 'SGPS_2027_4', 'SGPAPSB_2027_4',
        'RPED_2027_4', 'SGR_2027_4', 'CR_2027_4', 'G_2027_4', 'CO_2027_4', 'OR_2027_4',
        'estado_pf',
        'id_ip',
    ];

    public function indproducto(): BelongsTo {
        return $this->belongsTo(IndicadorProducto::class, 'id_ip', 'id');
    }

    public function avancefin(): BelongsTo {
        return $this->belongsTo(AvanceFinanciero::class, 'id_pf', 'id');
    }
}