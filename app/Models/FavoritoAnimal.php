<?php

namespace App\Models;

use App\Models\Animal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FavoritoAnimal extends Model
{

    use HasFactory;

    protected $table = 'favorito_animal';
    protected $primaryKey = 'id_favorito';
    public $timestamps = false;
    protected $fillable = [
        "id_usuario",
        "id_animal"
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'id_animal', 'id_animal');
    }
}
