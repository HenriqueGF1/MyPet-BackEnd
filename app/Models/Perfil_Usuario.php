<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Perfil_Usuario extends Model
{

    use HasFactory;

    protected $table = 'perfil_usuario';
    protected $primaryKey = 'id_perfil_usuario';
    public $timestamps = false;
    protected $fillable = [
        "id_perfil_usuario",
        "id_perfil",
        "id_usuario",
        "dt_registro"
    ];

    protected $attributes = [];

    /**
     * Retorna o ID do Usuario Logado
     */
    public static function getIdUsuarioLoged()
    {
        return Auth::id();
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function perfil(): BelongsTo
    {
        return $this->belongsTo(Perfil::class, 'id_perfil', 'id_perfil');
    }
}
