<?php

namespace App\Models;

use App\Models\DenunciaAnimal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DenunciaResposta extends Model
{

    use HasFactory;

    protected $table = 'denuncia_resposta';
    protected $primaryKey = 'id_resposta';
    public $timestamps = false;
    protected $attributes = [];
    protected $fillable = [
        "id_resposta",
        "id_denuncia",
        "dt_resposta",
        "aceite",
        "id_usuario",
        "resposta"
    ];

    public function denuncia(): BelongsTo
    {
        return $this->belongsTo(DenunciaAnimal::class, 'id_denuncia', 'id_denuncia');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
