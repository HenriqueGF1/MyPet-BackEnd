<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        "id_usuario",
        "id_perfil",
        "nome",
        "email",
        "password",
        "idade",
        "dt_registro",
        "qtd_denuncia"
    ];

    protected $attributes = [
        // 'id_perfil' => 2,
        // 'dt_registro' => Carbon::now(),
        'qtd_denuncia' => 0,
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function perfil_usuario(): HasMany
    {
        return $this->hasMany(Perfil_Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function animais(): HasMany
    {
        return $this->hasMany(Animal::class, 'id_usuario', 'id_usuario');
    }

    public function contatos(): HasMany
    {
        return $this->hasMany(Contato::class, 'id_usuario', 'id_usuario');
    }

    public function enderecos(): HasMany
    {
        return $this->hasMany(Endereco::class, 'id_usuario', 'id_usuario');
    }
}
