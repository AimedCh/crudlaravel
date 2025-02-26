<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direcciones extends Model
{
    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'direccion', 'email', 'telefono', 'cliente_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }
}
    