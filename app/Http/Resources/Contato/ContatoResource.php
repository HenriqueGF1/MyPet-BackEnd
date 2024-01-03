<?php

namespace App\Http\Resources\Contato;

use App\Http\Resources\Usuario\UsuarioResource;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContatoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id_contato" => $this->id_contato,
            "id_usuario" => $this->id_usuario,
            // 'usuario' => new UsuarioResource($this->whenLoaded('usuario')),
            'usuario' => Usuario::where('id_usuario', $this->id_usuario)->get(['nome', 'email', 'idade']),
            // 'usuario' => Usuario::find($this->id_usuario),
            "dd" => $this->dd,
            "numero" => $this->numero,
            "numero_completo" => "(" . $this->dd . ") " . $this->numero,
            "principal" => $this->principal,
            "isPrincipal" => $this->principal == 1 ? "Sim" : "Não",
            "dt_registro" => $this->dt_registro,
        ];
    }
}
