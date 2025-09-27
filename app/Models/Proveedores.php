<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
        'ciudad',
        'codigo_postal',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
