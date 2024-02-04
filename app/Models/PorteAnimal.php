<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PorteAnimal extends Model
{

    use HasFactory;

    protected $table = 'porte_animal';
    protected $primaryKey = 'id_porte';
    public $timestamps = false;

    protected $fillable = [
        "descricao",
        "dt_registro",
        "dt_inativacao"
    ];
}
