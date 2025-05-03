<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dependencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_d',
        'estado_d',
    ];

    public function dependencia(): HasMany {
        return $this->HasMany(User::class, 'id');
    }

    public function dependencias(): HasMany {
        return $this->HasMany(DependenciaEstrategia::class, 'id');
    }

    public function sectordependencia(): HasMany {
        return $this->HasMany(Sector::class, 'id');
    }

    public function indicadordependencia(): HasMany {
        return $this->HasMany(User::class, 'id');
    }

}