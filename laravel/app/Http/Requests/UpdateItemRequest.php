<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required|string|min:1|max:30',
        ];
    }

    // Mensagens de falha na validação.
    public function messages()
    {
        return [
            'nome.required' => 'É necessário fornecer um nome para o Item.',
            'nome.max' => 'O nome do item deve ter no máximo 30 caracteres.'
        ];
    }
}
