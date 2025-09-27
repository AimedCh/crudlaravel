<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlquileresReserva extends Model
{
    use HasFactory;

    protected $table = 'alquileres_reservas';

    protected $fillable = [
        'user_id',
        'nombre_cliente',
        'email_cliente',
        'telefono_cliente',
        'tipo_equipo',
        'descripcion_equipo',
        'fecha_inicio',
        'fecha_fin',
        'precio_dia',
        'total',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'precio_dia' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeConfirmadas($query)
    {
        return $query->where('estado', 'confirmado');
    }

    public function scopeEnUso($query)
    {
        return $query->where('estado', 'en_uso');
    }

    /**
     * Verificar si hay conflictos de fechas para un tipo de habitación
     * Retorna true si hay conflicto (no disponible), false si está disponible
     */
    public static function checkAvailability($tipo_equipo, $fecha_entrada, $fecha_salida, $excludeId = null)
    {
        $query = self::where('tipo_equipo', $tipo_equipo)
            ->where('estado', '!=', 'cancelado') // Excluir reservas canceladas
            ->where(function ($q) use ($fecha_entrada, $fecha_salida) {
                // Verificar si las fechas se superponen
                $q->where(function ($subQ) use ($fecha_entrada, $fecha_salida) {
                    // La nueva reserva empieza antes de que termine la existente
                    $subQ->where('fecha_inicio', '<=', $fecha_salida)
                         ->where('fecha_fin', '>=', $fecha_entrada);
                });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Obtener reservas que se superponen con las fechas dadas
     */
    public static function getConflictingReservations($tipo_equipo, $fecha_entrada, $fecha_salida, $excludeId = null)
    {
        $query = self::where('tipo_equipo', $tipo_equipo)
            ->where('estado', '!=', 'cancelado')
            ->where(function ($q) use ($fecha_entrada, $fecha_salida) {
                // Verificar si las fechas se superponen
                $q->where(function ($subQ) use ($fecha_entrada, $fecha_salida) {
                    // La nueva reserva empieza antes de que termine la existente
                    $subQ->where('fecha_inicio', '<=', $fecha_salida)
                         ->where('fecha_fin', '>=', $fecha_entrada);
                });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->get();
    }
}
