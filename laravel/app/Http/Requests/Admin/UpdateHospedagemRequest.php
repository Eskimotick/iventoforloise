<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateHospedagemRequest extends FormRequest
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
            'localizacao' => 'string|min:10|max:500',
            'vagas' => 'integer|min:1',
            //'status' => 'integer|min:0|max:1',
        ];
    }

    public function messages(){
        return [
            'nome.min' => 'O nome deve conter no mínimo 10 caracteres',
            'nome.max' => 'O nome deve conter no máximo 50 caracteres',
            'descricao.string' => 'A descrição precisa ser um texto',
            'descricao.min' => 'A descrição deve conter no mínimo 10 caracteres',
            'descricao.max' => 'A descrição deve conter no máximo 300 caracteres',
            'localizacao.min' => 'A localização deve conter no mínimo 10 caracteres',
            'localizacao.max' => 'A localização deve conter no máximo 500 caracteres',
            'vagas.integer' => 'A quantidade de vagas deve ser um número',
            'vagas.min' => 'O número de vagas tem que ser maior que zero.',
            // 'status.integer' => 'O valor do status deve ser um número',
            // 'status.min' => 'O número do status tem que ser maior ou igual a zero.',
            // 'status.max' => 'O número do status não pode ser maior que 1',
        ];
    }
}
