<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreHospedagemRequest extends FormRequest
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
            'localizacao' => 'required|string|min:10|max:500',
            'vagas' => 'required|integer|min:1'
        ];
    }

    public function messages(){
        return [
            'nome.required' => 'Digite um nome para a Hospedagem.',
            'nome.min' => 'O nome deve conter no mínimo 10 caracteres',
            'nome.max' => 'O nome deve conter no máximo 50 caracteres',
            'descricao.required' => 'Uma descrição é necessária',
            'descricao.min' => 'A descrição deve conter no mínimo 10 caracteres',
            'descricao.max' => 'A descrição deve conter no máximo 300 caracteres',
            'localizacao.required' => 'Uma localização é necessária',
            'localizacao.min' => 'A localização deve conter no mínimo 10 caracteres',
            'localizacao.max' => 'A localização deve conter no máximo 500 caracteres',
            'vagas.required' => 'É necessário fornecer o número de vagas total da Hospedagem.',
            'vagas.integer' => 'A quantidade de vagas deve ser um número',
            'vagas.min' => 'O número de vagas tem que ser maior que zero.',
        ];
    }
}
