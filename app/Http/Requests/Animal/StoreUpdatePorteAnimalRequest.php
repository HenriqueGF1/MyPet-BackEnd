<?php

namespace App\Http\Requests\Animal;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdatePorteAnimalRequest extends FormRequest
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
                'max:255',
                'min:4',
            ],
        ];

        // Cadastro
        if (!$this->isMethod('post')) {

            $regras = [
                'descricao' => [
                    'nullable',
                    'max:255',
                    'min:4',
                ]
            ];
        }

        return $regras;
    }
}
