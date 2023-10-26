<?php

namespace App\Http\Resources\Animal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PorteAnimalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_porte" => $this->id_porte,
            "descricao" => $this->descricao,
            "dt_inativacao" => $this->dt_inativacao
        ];
    }
}
