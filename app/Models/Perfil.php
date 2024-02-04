<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perfil extends Model
{

    use HasFactory;

    protected $table = 'perfil';
    protected $primaryKey = 'id_perfil';
    public $timestamps = false;

    protected $fillable = [
        "id_perfil",
        "descricao",
        "dt_registro",
        "dt_inativacao"
    ];

    public function usuario(): HasMany
    {
        return $this->hasMany(Perfil_Usuario::class, 'id_perfil_usuario', 'id_perfil_usuario');
    }
}
