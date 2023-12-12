<?php

namespace App\Http\Requests\Animal;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Query\Builder;

class StoreUpdateFotoAnimalRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {

        $regras = [
            'imagens' => [
                'required',
                // 'image',
                // 'mimes:jpeg,png,jpg',
                // 'max:8192',
            ],
            'id_animal' => [
                'required',
                Rule::exists('animal')->where(function (Builder $query) {
                    return $query->where('id_animal', $this->id_animal);
                }),
            ],
        ];

        if (!empty($this->id_foto_animal)) {

            $regras = [
                'imagens.*' => [
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg',
                    'max:8192',
                ],
                'id_foto_animal' => [
                    'required',
                    Rule::exists('foto_animal')->where(function (Builder $query) {
                        return $query->where('id_animal', $this->id_animal)->whereIn('id_foto_animal', [(array) $this->id_foto_animal]);
                    }),
                ],
                'id_animal' => [
                    'required',
                    Rule::exists('animal')->where(function (Builder $query) {
                        return $query->where('id_animal', $this->id_animal);
                    }),
                ],
            ];
        }

        return $regras;
    }

    public function messages(): array
    {
        return [
            // 'imagens.required' => 'E necessário Fotos do Animal',
            // 'imagens.image' => 'E necessário Fotos do Animal em (jpg)',
            // 'imagens.mimes:jpeg,png,jpg' => 'E necessário Fotos do Animal em (jpeg,png,jpg)',
            'id_animal.exists' => 'Animal não encontrado(s)',
            'id_foto_animal.exists' => 'Foto(s) não encontrada(s)',
        ];
    }
}
