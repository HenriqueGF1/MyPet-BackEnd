<?php

namespace App\Http\Resources\Animal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaAnimalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_categoria" => $this->id_categoria,
            "descricao" => $this->descricao,
            "dt_registro" => $this->dt_registro,
            "dt_inativacao" => $this->dt_inativacao,
            "dt_exclusao" => $this->dt_exclusao
        ];
    }
}
