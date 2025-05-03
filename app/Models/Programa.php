<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Programa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_p',
        'estado_p',
        'id_s',
    ];

    public function sectorial(): BelongsTo {
        return $this->belongsTo(Sector::class, 'id_s', 'id');
    }
}
