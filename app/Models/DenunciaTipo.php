<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DenunciaTipo extends Model
{
    use HasFactory;

    protected $table = 'denuncia_tipo';
    protected $primaryKey = 'id_tipo';
    public $timestamps = false;
    protected $attributes = [];

    protected $fillable = [
        "id_tipo",
        "descricao",
        "dt_registro",
        "dt_inativacao",
        "dt_exclusao"
    ];
}
