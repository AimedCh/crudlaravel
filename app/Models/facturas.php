<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class facturas extends Model
{
    public function cliente(){
        return $this->belongsto('App\Models\clientes');
    }
    
}