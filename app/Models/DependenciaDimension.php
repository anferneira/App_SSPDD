<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DependenciaDimension extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dep',
        'id_dim',
        'estado_dd',
    ];

    public function dependenciass(): BelongsTo {
        return $this->belongsTo(Dependencia::class, 'id_dep', 'id');
    }

    public function dimensiones(): BelongsTo {
        return $this->belongsTo(Dimension::class, 'id_dim', 'id');
    }
}
