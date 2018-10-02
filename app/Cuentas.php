<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuentas extends Model
{
    protected $table = 'cuentas';

    protected $fillable = [
        'cliente_id', 'nombre', 'saldo', 'estado'
    ];

    public function cliente(){
        return $this->belongsTo('App\Cliente', 'cliente_id');
    }

}
