<?php

namespace App\Http\Requests\Usuario\Contato;

use App\Http\DTO\Contato\ContatoDTO;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateContatoRequest extends FormRequest
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
            'dd' => [
                'required',
                'max:2',
                'min:2',
            ],
            'numero' => [
                'required',
                'telefone',
                'max:9',
                'min:8',
            ],
        ];

        return $regras;
    }
}
