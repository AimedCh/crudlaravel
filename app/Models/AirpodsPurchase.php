<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AirpodsPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'airpods_id',
        'product_name',
        'product_description',
        'product_category',
        'purchase_number',
        'quantity',
        'unit_price',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'shipping_address',
        'billing_address',
        'tracking_number',
        'notes',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con Airpods eliminada - tabla airpods ya no existe

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('order_status', 'pending');
    }

    public function scopeProcesando($query)
    {
        return $query->where('order_status', 'processing');
    }

    public function scopeEnviados($query)
    {
        return $query->where('order_status', 'shipped');
    }

    public function scopeEntregados($query)
    {
        return $query->where('order_status', 'delivered');
    }

    public function scopeCancelados($query)
    {
        return $query->where('order_status', 'cancelled');
    }

    public function scopePagoCompletado($query)
    {
        return $query->where('payment_status', 'completed');
    }

    public function scopePagoPendiente($query)
    {
        return $query->where('payment_status', 'pending');
    }

    // Métodos de utilidad
    public function generatePurchaseNumber()
    {
        $prefix = 'AP';
        $date = Carbon::now()->format('Ymd');
        $lastPurchase = self::where('purchase_number', 'like', $prefix . $date . '%')
                           ->orderBy('purchase_number', 'desc')
                           ->first();
        
        if ($lastPurchase) {
            $lastNumber = intval(substr($lastPurchase->purchase_number, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $date . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function canBeCancelled()
    {
        return in_array($this->order_status, ['pending', 'processing']);
    }

    public function canBeShipped()
    {
        return $this->order_status === 'processing' && $this->payment_status === 'completed';
    }

    public function canBeDelivered()
    {
        return $this->order_status === 'shipped';
    }
}
