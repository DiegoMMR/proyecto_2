<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    protected $table = 'movimientos';

    protected $fillable = [
        'cuenta_id', 'cuenta_terceros_id', 'tipo', 'monto', 'saldo_anterior' , 'saldo_nuevo'
    ];

    public function cuenta(){
        return $this->belongsTo('App\Cuentas', 'cuenta_id');
    }
}
