<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contato extends Model
{
    use HasFactory;
    protected $table = 'contato';
    protected $primaryKey = 'id_contato';
    public $timestamps = false;
    protected $attributes = [
        'principal' => 0,
    ];
    protected $fillable = [
        "id_contato",
        "dd",
        "numero",
        "dt_registro",
        "id_usuario",
        "principal"
    ];
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
