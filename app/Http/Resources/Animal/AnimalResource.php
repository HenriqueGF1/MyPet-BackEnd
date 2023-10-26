<?php

namespace App\Http\Resources\Animal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Animal\FotoAnimalResource;
use App\Http\Resources\Animal\PorteAnimalResource;
use App\Http\Resources\Animal\CategoriaAnimalResource;
use App\Http\Resources\Usuario\UsuarioResource;

class AnimalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id_animal" => $this->id_animal,
            "nome" => $this->nome,
            "descricao" => $this->descricao,
            "idade" => $this->idade,
            "sexo" => $this->sexo,
            "dt_registro" => $this->dt_registro,
            "dt_inativacao" => $this->dt_inativacao,
            "qtd_denuncia" => $this->qtd_denuncia,
            "id_categoria" => $this->id_categoria,
            'categoria' => new CategoriaAnimalResource($this->categoria),
            "id_porte" => $this->id_porte,
            'porte' => new PorteAnimalResource($this->porte),
            'fotos' => FotoAnimalResource::collection($this->fotos),
            "id_usuario" => $this->id_usuario,
            'usuario' => new UsuarioResource($this->usuario),
            "adotado" => $this->adotado,
        ];
    }
}
