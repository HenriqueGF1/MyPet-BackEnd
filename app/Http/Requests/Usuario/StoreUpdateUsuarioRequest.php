<?php

namespace App\Http\Requests\Usuario;

use App\Rules\Sobrenome;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Usuario\Contato\StoreUpdateContatoRequest;
use App\Http\Requests\Usuario\Endereco\StoreUpdateEnderecoRequest;

class StoreUpdateUsuarioRequest extends FormRequest
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
            StoreUpdateContatoRequest::class,
            StoreUpdateEnderecoRequest::class,
        ];

        $regras = [
            'nome' => [
                'required',
                new Sobrenome,
                'max:255',
                'min:4',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:usuario',
            ],
            'idade' => [
                'required',
                'date',
            ],
            'password' => [
                'required',
                'max:8',
                'min:6',
            ],
        ];

        foreach ($formRequests as $source) {
            $regras = array_merge(
                $regras,
                (new $source)->rules()
            );
        }

        // Update
        if ($this->isMethod('put') || $this->isMethod('patch')) {

            $regras = [
                'nome' => [
                    'nullable',
                    new Sobrenome,
                    'max:255',
                    'min:4',
                ]
            ];
        }

        return $regras;
    }
}
