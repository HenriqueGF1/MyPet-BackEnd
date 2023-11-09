<?php

namespace App\Http\Resources\Usuario;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\Contato\ContatoResource;
use App\Http\Resources\Endereco\EnderecoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
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
            "id_usuario" => $this->id_usuario,
            "id_perfil" => $this->id_perfil,
            "nome" => $this->nome,
            "email" => $this->email,
            // "password" => $this->password,
            "idade" => Carbon::parse($this->idade)->format('d/m/Y'),
            "dt_registro" => Carbon::parse($this->dt_registro)->format('d/m/Y H:m:s'),
            "qtd_denuncia" => $this->qtd_denuncia,
            'contatos' => ContatoResource::collection($this->contatos),
            'enderecos' => EnderecoResource::collection($this->enderecos)
        ];
    }
}
