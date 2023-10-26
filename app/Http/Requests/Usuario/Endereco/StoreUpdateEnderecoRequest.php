<?php

namespace App\Http\Requests\Usuario\Endereco;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateEnderecoRequest extends FormRequest
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

        // dd($this->getMethod());

        $regras = [
            'cep' => [
                'required',
                'max:8',
                'min:5',
            ],
            'bairro' => [
                'required',
                'max:255',
                'min:5',
            ],
            'numero_endereco' => [
                'required',
                'max:255',
                'min:2',
            ],
            'complemento' => [
                'required',
                'max:255',
                'min:5',
            ]
        ];

        // Atualizando
        if ($this->isMethod('put') || $this->isMethod('patch')) {

            $regras = [
                'cep' => [
                    'nullable',
                    'max:8',
                    'min:5',
                ],
                'bairro' => [
                    'nullable',
                    'max:255',
                    'min:5',
                ],
                'numero_endereco' => [
                    'nullable',
                    'max:255',
                    'min:1',
                ],
                'complemento' => [
                    'nullable',
                    'max:255',
                    'min:5',
                ]
            ];
        }

        return $regras;
    }
}
