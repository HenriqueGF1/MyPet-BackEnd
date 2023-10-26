<?php

namespace App\Http\Resources\Animal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FotoAnimalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_foto_animal" => $this->id_foto_animal,
            "nome_arquivo" => $this->nome_arquivo,
            "nome_arquivo_original" => $this->nome_arquivo_original,
            "url" => $this->url,
            "dt_registro" => $this->dt_registro,
            "id_animal" => $this->id_animal
        ];
    }
}
