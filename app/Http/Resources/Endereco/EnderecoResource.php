<?php

namespace App\Http\Resources\Endereco;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnderecoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_endereco" => $this->id_endereco,
            "id_usuario" => $this->id_usuario,
            "cep" => $this->cep,
            "bairro" => $this->bairro,
            "numero" => $this->numero,
            "complemento" => $this->complemento,
            "dt_registro" => $this->dt_registro,
        ];
    }
}
