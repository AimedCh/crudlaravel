<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class apuntes extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'cartilla_id',
        'fecha',
        'concepto',
        'importe',
     ];
     
    public function cartilla()
    {
        return $this->belongsTo(Cartilla::class);
    }

}
