<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Artesaos\Defender\Traits\HasDefender;
use Artesaos\Defender\Role;

class User extends Authenticatable
{
    use Notifiable, HasDefender;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_token', 'cliente_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function esAdministrador()
    {
        return $this->hasRole('administrador');
    }

    public function esEmpleado()
    {
        return $this->hasRole('empleado');
    }

    public function esCliente()
    {
        return $this->hasRole('cliente');
    }

    public function estaVerificado()
    {
        if ($this->verified) {
            return true;
        }else {
            return false;
        }
    }
}
