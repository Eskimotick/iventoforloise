<?php

namespace App\Http\Requests\Admin;

use App\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePacoteRequest extends FormRequest
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
            'nome' => 'required|string|min:10|max:50',
            'descricao' => 'required|string|min:10|max:300',
            'lotes' => 'required|integer|min:1',
            'vagas' => 'required|integer|min:1'
        ];
    }

    public function messages(){
        return [
            'nome.required' => 'Digite um nome para o pacote',
            'nome.string' => '',
            'nome.min' => 'O nome deve conter no mínimo 10 caracteres',
            'nome.max' => 'O nome deve conter no máximo 50 caracteres',
            'descricao.required' => 'Uma descrição é necessária',
            'descricao.string' => 'A descrição precisa ser um texto',
            'descricao.min' => 'A descrição deve conter no mínimo 10 caracteres',
            'descricao.max' => 'A descrição deve conter no máximo 300 caracteres',
            'lotes.required' => 'É necessário fornecer o número de lotes do pacote',
            'lotes.integer' => 'A quantidade de lotes deve ser um número',
            'lotes.min' => 'O número tem que ser maior que zero.',
            'vagas.required' => 'É necessário forncer o número de vagas total do pacote',
            'vagas.integer' => 'A quantidade de vagas deve ser um número',
            'vagas.min' => 'O número de vagas tem que ser maior que zero.',
        ];
    }
}
