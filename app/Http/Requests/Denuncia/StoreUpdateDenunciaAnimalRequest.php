<?php

namespace App\Http\Requests\Denuncia;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Query\Builder;

class StoreUpdateDenunciaAnimalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $regras = [
            'descricao' => [
                'required',
                'min:5',
                'max:255',
            ],
            'id_tipo' => [
                'required',
                Rule::exists('denuncia_tipo')->where(function (Builder $query) {
                    return $query->where('id_tipo', $this->id_tipo);
                }),
            ],
            // 'id_usuario_denunciante' => [
            //     'required',
            //     Rule::exists('usuario')->where(function (Builder $query) {
            //         return $query->where('id_usuario', $this->id_usuario);
            //     }),
            // ],
            'id_usuario' => [
                'required',
                Rule::exists('usuario')->where(function (Builder $query) {
                    return $query->where('id_usuario', $this->id_usuario);
                }),
            ],
            'id_animal' => [
                'required',
                Rule::exists('animal')->where(function (Builder $query) {
                    return $query->where('id_animal', $this->id_animal);
                }),
            ],

        ];

        // Quando nao vai cadastrar
        if (!$this->isMethod('post')) {

            $regras = [
                'descricao' => [
                    'required',
                    'min:5',
                    'max:255',
                ],
            ];
        }

        return $regras;
    }

    public function messages(): array
    {
        return [
            'id_tipo.exists' => 'Tipo de Denuncia não encontrado',
            'id_usuario.exists' => 'Usuário não encontrado',
            'id_animal.exists' => 'Animal não encontrado',
        ];
    }
}
