<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentasExternas extends Model
{
    protected $table = 'cuentas_externas';

    protected $fillable = [
        'nombre', 'saldo', 'estado', 'limite_monto', 'limite_transacciones'
    ];
}
