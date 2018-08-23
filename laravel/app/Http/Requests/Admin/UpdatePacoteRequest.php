<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePacoteRequest extends FormRequest
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
      throw new HttpResponseException(response()->json($validator->errors(), 400));
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'string|min:10|max:50',
            'descricao' => 'string|min:10|max:300',
            'lotes' => 'integer|min:1',
            'vagas' => 'integer|min:1',
            'lote_atual' => 'integer|min:1|lte:lotes',
        ];
    }

    public function messages(){
        return [
            'nome.min' => 'O nome deve conter no mínimo 10 caracteres',
            'nome.max' => 'O nome deve conter no máximo 50 caracteres',
            'descricao.string' => 'A descrição precisa ser um texto',
            'descricao.min' => 'A descrição deve conter no mínimo 10 caracteres',
            'descricao.max' => 'A descrição deve conter no máximo 300 caracteres',
            'lotes.integer' => 'A quantidade de lotes deve ser um número',
            'lotes.min' => 'O número de lotes tem que ser maior que zero.',
            'vagas.integer' => 'A quantidade de vagas deve ser um número',
            'vagas.min' => 'O número de vagas tem que ser maior que zero.',
            'lote_atual.integer' => 'O valor do lote atual deve ser um número',
            'lote_atual.min' => 'O número do lote atual tem que ser maior que zero.',
            'lote_atual.lte' => 'O número do lote_atual não pode ser maior que o número de lotes.',
        ];
    }
}
