<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'cliente';

    protected $fillable = [
        'dpi', 'nombre', 'email', 'direccion', 'telefono'
    ];

    public function Cuentas(){
        return $this->hasMany('App\Cuentas');
    }
    
}
