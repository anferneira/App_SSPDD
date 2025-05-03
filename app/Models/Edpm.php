<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edpm extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_edpm',
        'programa_edpm',
        'estado_edpm',
    ];
}
