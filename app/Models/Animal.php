<?php

namespace App\Models;

use App\Models\CategoriaAnimal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Animal extends Model
{
    use HasFactory;
    protected $table = 'animal';
    protected $primaryKey = 'id_animal';
    public $timestamps = false;
    protected $fillable = [
        "id_animal",
        "nome",
        "descricao",
        "idade",
        "sexo",
        "dt_registro",
        "dt_inativacao",
        "qtd_denuncia",
        "id_categoria",
        "id_porte",
        "adotado",
        "id_usuario"
    ];
    protected $attributes = [
        'adotado' => 0,
        'qtd_denuncia' => 0,
        'dt_inativacao' => null,
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaAnimal::class, 'id_categoria', 'id_categoria');
    }
    public function porte(): BelongsTo
    {
        return $this->belongsTo(PorteAnimal::class, 'id_porte', 'id_porte');
    }
    public function fotos(): HasMany
    {
        return $this->hasMany(FotoAnimal::class, 'id_animal', 'id_animal');
    }
    public function favoritos(): HasMany
    {
        return $this->hasMany(FavoritoAnimal::class, 'id_animal', 'id_animal');
    }
    public function denuncias(): HasMany
    {
        return $this->hasMany(DenunciaAnimal::class, 'id_animal', 'id_animal');
    }
}
