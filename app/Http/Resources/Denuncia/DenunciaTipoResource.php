<?php

namespace App\Http\Resources\Denuncia;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DenunciaTipoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_tipo" => $this->id_tipo,
            "descricao" => $this->descricao,
            "dt_registro" => $this->dt_registro,
            "dt_inativacao" => $this->dt_inativacao,
            "dt_exclusao" => $this->dt_exclusao
        ];
    }
}
