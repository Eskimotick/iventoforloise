<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreQuartoRequest extends FormRequest
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
            'nome' => 'required|string|min:10|max:50', //usar um regex para alfanumerico
            'descricao' => 'required|string|min:10|max:300',
            'hospedagem' => 'required|integer|min:1',
            'vagas' => 'required|integer|min:1',
            'qnt_quartos' => 'required|integer|min:1'
        ];
    }

    public function messages(){
        return [
            'nome.required' => 'Digite um nome para o Quarto',
            'nome.min' => 'O nome deve conter no mínimo 10 caracteres',
            'nome.max' => 'O nome deve conter no máximo 50 caracteres',
            'descricao.required' => 'Uma descrição é necessária',
            'descricao.min' => 'A descrição deve conter no mínimo 10 caracteres',
            'descricao.max' => 'A descrição deve conter no máximo 300 caracteres',
            'hospedagem.required' => 'É necessário fornecer a hospedagem ao qual o quarto se refere.',
            'hospedagem.integer' => 'A hospedagem deve ser um número',
            'hospedagem.min' => 'O número tem que ser maior que zero.',
            'vagas.required' => 'É necessário fornecer o número de vagas total do quarto',
            'vagas.integer' => 'A quantidade de vagas deve ser um número',
            'vagas.min' => 'O número de vagas tem que ser maior que zero.',
            'qnt_quartos.required' => 'É necessário fornecer a quantidade de quartos a ser criados',
            'qnt_quartos.integer' => 'A quantidade de quantidade de quartos deve ser um número',
            'qnt_quartos.min' => 'O número de quantidade de quartos tem que ser maior que zero.',

        ];
    }
}
