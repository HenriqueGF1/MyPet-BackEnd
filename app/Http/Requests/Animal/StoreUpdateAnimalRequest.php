<?php

namespace App\Http\Requests\Animal;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Animal\StoreUpdateFotoAnimalRequest;

class StoreUpdateAnimalRequest extends FormRequest
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

        $formRequests = [
            StoreUpdateFotoAnimalRequest::class,
        ];

        $regras =  [
            'nome' => [
                'required',
                'string',
                'min:3',
            ],
            'descricao' => [
                'required',
                'min:5',
                'max:255',
                'string',
            ],
            'idade' => [
                'required',
            ],
            'sexo' => [
                'required',
                'min:1',
                'max:1',
            ],
            'id_categoria' => [
                'required',
                Rule::exists('categoria_animal')->where(function (Builder $query) {
                    return $query->where('id_categoria', $this->id_categoria);
                }),
            ],
            'id_porte' => [
                'required',
                Rule::exists('porte_animal')->where(function (Builder $query) {
                    return $query->where('id_porte', $this->id_porte);
                }),
            ],
            // 'id_usuario' => [
            //     'required',
            // ]
        ];

        foreach ($formRequests as $source) {
            $regras = array_merge(
                $regras,
                (new $source)->rules()
            );
        }

        // Atualizando
        if ($this->isMethod('put') || $this->isMethod('patch')) {

            $regras = [
                'nome' => [
                    'nullable',
                    'string',
                    'min:3',
                ],
                'descricao' => [
                    'nullable',
                    'min:5',
                    'max:255',
                    'string',
                ],
                'idade' => [
                    'nullable',
                ],
                'sexo' => [
                    'nullable',
                    'min:1',
                    'max:1',
                ],
                'id_categoria' => [
                    'nullable',
                    Rule::exists('categoria_animal')->where(function (Builder $query) {
                        return $query->where('id_categoria', $this->id_categoria);
                    }),
                ],
                'id_porte' => [
                    'nullable',
                    Rule::exists('porte_animal')->where(function (Builder $query) {
                        return $query->where('id_porte', $this->id_porte);
                    }),
                ],
            ];
        }

        // dd($regras);

        return $regras;
    }
    public function messages(): array
    {
        return [
            'id_categoria.exists' => 'Categoria não encontrado',
            'id_porte.exists' => 'Porte não encontrado',
        ];
    }
}
