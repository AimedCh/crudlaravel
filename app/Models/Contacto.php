<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $table = 'contacto';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'service',
        'status',
        'admin_notes',
        'replied_at'
    ];

    protected $casts = [
        'replied_at' => 'datetime'
    ];

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByService($query, $service)
    {
        return $query->where('service', $service);
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'new' => 'badge-primary',
            'read' => 'badge-info',
            'replied' => 'badge-success',
            'closed' => 'badge-secondary'
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }

    public function getServiceLabelAttribute()
    {
        $labels = [
            'airpods' => 'AirPods Store',
            'alquileres' => 'Alquileres',
            'taller' => 'Taller Automotriz',
            'general' => 'General'
        ];

        return $labels[$this->service] ?? 'General';
    }
}