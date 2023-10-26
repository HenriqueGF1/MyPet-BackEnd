<?php

namespace App\Http\Requests\Denuncia;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

class StoreDenunciaRespostaRequest extends FormRequest
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
        return [
            'resposta' => [
                'required',
                'max:100',
                'min:10',
            ],
            'aceite' => [
                'required',
            ],
            'id_denuncia' => [
                'required',
                Rule::exists('denuncia')->where(function (Builder $query) {
                    return $query->where('id_denuncia', $this->id_denuncia);
                }),
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'id_denuncia.exists' => 'Denuncia não encontrado',
        ];
    }
}
