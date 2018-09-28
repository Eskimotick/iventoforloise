<?php

namespace App\Http\Requests;

use App\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CampoRequest extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required|string|min:1|max:40',
            'tipo' => 'required',
            'outro' => 'required|boolean',
            //'qtd' => 'numeric|min:2'
        ];
    }

    // Mensagens de falha na validação.
    public function messages()
    {
        return [
            'nome.required' => 'É necessário fornecer um nome.',
            'nome.max' => 'O nome deve ter no máximo 40 caracteres.',
            'tipo.required' => 'É necessário preencher o tipo do campo.',
            'outro.required' => 'É necessário informar se necessita de item outro',
            'qtd.numeric' => 'A quantidade de itens deve ser um inteiro',
            //'qtd.min' => 'É necessário ter pelo menos 2 itens em um campo select',
        ];
    }
}
