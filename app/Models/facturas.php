<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class facturas extends Model
{
    protected $fillable = ['cliente_id','fecha', 'total'];
    protected $casts = [
        'fecha' => 'date', 
    ];
    
    

    public function cliente()
    {
        return $this->belongsTo(clientes::class, 'cliente_id');
    }

    public function recibos(){
        return $this->hasMany('App\Models\recibos');

    }

    /*public function lineas(){
         return $this->hasMany(LineasFacturas::class);

    }*/
}