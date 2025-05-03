<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_r',
        'estado_r',
    ];

    public function rol(): HasMany {
        return $this->HasMany(User::class, 'id');
    }
}
