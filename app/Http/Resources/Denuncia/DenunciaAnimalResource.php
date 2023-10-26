<?php

namespace App\Http\Resources\Denuncia;

use Illuminate\Http\Request;
use App\Http\Resources\Animal\AnimalResource;
use App\Http\Resources\Usuario\UsuarioResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DenunciaAnimalResource extends JsonResource
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
            "id_denuncia" => $this->id_denuncia,
            "descricao" => $this->descricao,
            "dt_inativacao" => $this->dt_inativacao,
            "dt_exclusao" => $this->dt_exclusao,
            "id_tipo" => $this->id_tipo,
            "tipo" => new DenunciaTipoResource($this->tipo),
            "id_usuario_denunciante" => $this->id_usuario_denunciante,
            "usuarioDenunciante" => new UsuarioResource($this->usuarioDenunciante),
            "id_usuario" => $this->id_usuario,
            "usuario" => new UsuarioResource($this->usuario),
            "id_animal" => $this->id_animal,
            "animal" => new AnimalResource($this->animal),
            // "respostas" => DenunciaRespostaResource::collection($this->respostas),
        ];
    }
}
