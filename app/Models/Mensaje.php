<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'asunto',
        'mensaje',
        'estado',
        'respuesta_admin',
        'fecha_respuesta',
        'admin_id',
    ];

    protected $casts = [
        'fecha_respuesta' => 'datetime',
    ];

    // Relationships
    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'admin_id');
    }

    // Scopes
    public function scopeNuevos($query)
    {
        return $query->where('estado', 'nuevo');
    }

    public function scopeNoRespondidos($query)
    {
        return $query->whereIn('estado', ['nuevo', 'leido']);
    }

    public function scopeRespondidos($query)
    {
        return $query->where('estado', 'respondido');
    }
}
