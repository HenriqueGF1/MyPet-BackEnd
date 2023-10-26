<?php

namespace App\Models;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DenunciaAnimal extends Model
{
    use HasFactory;
    protected $table = 'denuncia';
    protected $primaryKey = 'id_denuncia';
    public $timestamps = false;
    protected $fillable = [
        "id_denuncia",
        "descricao",
        "dt_inativacao",
        "dt_exclusao",
        "id_tipo",
        "id_usuario_denunciante",
        "id_usuario",
        "id_animal"
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'id_animal', 'id_animal');
    }
    public function tipo(): HasOne
    {
        return $this->hasOne(DenunciaTipo::class, 'id_tipo', 'id_tipo');
    }
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
    public function usuarioDenunciante(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_denunciante', 'id_usuario');
    }
    public function respostas(): HasMany
    {
        return $this->hasMany(DenunciaResposta::class, 'id_denuncia', 'id_denuncia');
    }
}
