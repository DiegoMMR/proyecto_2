<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentasTerceros extends Model
{
    protected $table = 'cuentas_terceros';

    protected $fillable = [
        'user_id', 'cuenta_externa_id', 'alias'
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function cuenta(){
        return $this->belongsTo('App\CuentasExternas', 'cuenta_externa_id');
    }
}
