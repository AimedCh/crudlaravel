<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recibos extends Model
{
    //

    protected $table = 'recibos';
    protected $primaryKey = 'recibo_id';
    public $incrementing = true; 
    protected $fillable = ['factura_id', 'fecha', 'importe'];
    
    public function factura()
    {
        return $this->belongsTo(facturas::class, 'factura_id');
    }
}
