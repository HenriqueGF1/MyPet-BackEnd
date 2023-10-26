<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FotoAnimal extends Model
{
    use HasFactory;
    protected $table = 'foto_animal';
    protected $primaryKey = 'id_foto_animal';
    public $timestamps = false;
    protected $fillable = [
        "id_foto_animal",
        "nome_arquivo",
        "nome_arquivo_original",
        "url",
        "dt_registro",
        "id_animal"
    ];

    public function animal(): BelongsToMany
    {
        return $this->belongsToMany(Animal::class, 'id_animal', 'id_animal');
    }
}
