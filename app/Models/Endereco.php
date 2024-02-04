<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Endereco extends Model
{

    use HasFactory;

    protected $table = 'endereco';
    protected $primaryKey = 'id_endereco';
    public $timestamps = false;
    protected $attributes = [
        'principal' => 0,
    ];

    protected $fillable = [
        "id_endereco",
        "cep",
        "bairro",
        "numero",
        "complemento",
        "dt_registro",
        "id_usuario",
        "principal"
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
