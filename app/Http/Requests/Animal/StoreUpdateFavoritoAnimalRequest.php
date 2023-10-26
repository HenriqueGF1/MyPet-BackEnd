<?php

namespace App\Http\Requests\Animal;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Query\Builder;


class StoreUpdateFavoritoAnimalRequest extends FormRequest
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

        return $regras;
    }

    public function messages(): array
    {
        return [
            'id_usuario.exists' => 'Usuário não encontrado',
            'id_animal.exists' => 'Animal não encontrado',
        ];
    }
}
