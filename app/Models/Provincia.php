<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provincia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_p',
        'estado_p',
    ];

    public function provincia(): HasMany {
        return $this->HasMany(Municipio::class, 'id');
    }
}
