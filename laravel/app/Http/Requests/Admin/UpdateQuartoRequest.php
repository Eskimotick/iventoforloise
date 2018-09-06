<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateQuartoRequest extends FormRequest
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
            'nome' => array('regex:/^[0-9a-zA-ZÀ-Úà-ú\s]+$/',
                            'min:10','max:50'),
            'descricao' => 'string|min:10|max:300',
            'vagas' => 'integer|min:1',
            'pacotes' => 'string|min:1'//adicionar coisas relacionadas a pacotes
        ];
    }
    
    public function messages(){
        return [
            'nome.regex' => 'São aceitos somente letras e números para o nome',
            'nome.min' => 'O nome deve conter no mínimo 10 caracteres',
            'nome.max' => 'O nome deve conter no máximo 50 caracteres',
            'descricao.min' => 'A descrição deve conter no mínimo 10 caracteres',
            'descricao.max' => 'A descrição deve conter no máximo 300 caracteres',
            'vagas.integer' => 'A quantidade de vagas deve ser um número',
            'vagas.min' => 'O número de vagas tem que ser maior que zero.',
            'pacotes.min' => 'O número de pacotes tem que ser maior que zero.'
        ];
    }
}
