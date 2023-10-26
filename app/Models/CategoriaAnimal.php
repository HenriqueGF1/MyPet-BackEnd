<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriaAnimal extends Model
{
    use HasFactory;

    protected $table = 'categoria_animal';
    protected $primaryKey = 'id_categoria';
    public $timestamps = false;
    protected $fillable = [
        "id_categoria",
        "descricao",
        "dt_registro",
        "dt_inativacao"
    ];
    protected $attributes = [
        'dt_inativacao' => null
    ];
}
