<?php

namespace App\Http\Resources\Animal;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\Usuario\UsuarioResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Animal\FotoAnimalResource;
use App\Http\Resources\Animal\PorteAnimalResource;
use App\Http\Resources\Animal\CategoriaAnimalResource;

class AnimalResource extends JsonResource
{

    public function calcularIdade($dataNascimento)
    {
        $idade = Carbon::parse($dataNascimento);
        return $idade->diffInYears() > 0
            ? $idade->diffInYears() . ($idade->diffInYears() > 1 ? " anos" : " ano")
            : ($idade->diffInMonths() > 0 ? $idade->diffInMonths() . ($idade->diffInMonths() > 1 ? " meses" : " mês") : "Recém nascido");
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id_animal" => $this->id_animal,
            "nome" => $this->nome,
            "descricao" => $this->descricao,
            // "idade" => Carbon::parse($this->idade)->format('d/m/Y'),
            "idade" => $this->calcularIdade($this->idade),
            "idadeEUA" =>  date('Y-m-d', strtotime($this->idade)),
            "sexo" => $this->sexo,
            "dt_registro" => $this->dt_registro,
            "dt_inativacao" => $this->dt_inativacao,
            "qtd_denuncia" => $this->qtd_denuncia,
            "id_categoria" => $this->id_categoria,
            'categoria' => new CategoriaAnimalResource($this->categoria),
            "id_porte" => $this->id_porte,
            'porte' => new PorteAnimalResource($this->porte),
            'fotos' => $this->unless(
                $request->routeIs('animaisFoto.index'), // Exclui a relação 'fotos' se a rota for 'animaisFoto.index'
                function () {
                    return FotoAnimalResource::collection($this->fotos);
                }
            ),
            "id_usuario" => $this->id_usuario,
            'usuario' => new UsuarioResource($this->usuario),
            'favoritoUsuario' => $this->favoritoUsuario($this->id_animal),
            'denunciasUsuario' => $this->denunciasUsuario($this->id_animal),
            'respostaDenuncia' => $this->respostaDenuncia($this->id_animal),
            "adotado" => $this->adotado,
        ];
    }
}
