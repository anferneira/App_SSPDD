<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ods extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_ods',
        'nombre_ods',
        'estado_ods',
    ];

    public function ods(): HasMany {
        return $this->HasMany(MetaOds::class, 'id');
    }
}
