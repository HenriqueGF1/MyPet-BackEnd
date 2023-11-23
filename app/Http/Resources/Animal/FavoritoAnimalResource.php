<?php

namespace App\Http\Resources\Animal;

use Illuminate\Http\Request;
use App\Http\Resources\Animal\AnimalResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoritoAnimalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this);
        return [
            "id_favorito" => $this->id_favorito,
            "id_usuario" => $this->id_usuario,
            "id_animal" => $this->id_animal,
            "animal" => new AnimalResource($this->animal),
            "dt_registro" => $this->dt_registro
        ];
    }
}
