<?php

namespace App\Http\Resources\Denuncia;

use Illuminate\Http\Request;
use App\Http\Resources\Usuario\UsuarioResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DenunciaRespostaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_resposta" => $this->id_resposta,
            "resposta" => $this->resposta,
            "aceite" => $this->aceite,
            "id_denuncia" => $this->id_denuncia,
            "denuncia" => new DenunciaAnimalResource($this->denuncia),
            "dt_resposta" => $this->dt_resposta,
            "id_usuario" => $this->id_usuario,
            "usuario" => new UsuarioResource($this->usuario)
        ];
    }
}
