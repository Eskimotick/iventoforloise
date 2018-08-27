<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateLoteRequest extends FormRequest
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
            'descricao' => 'string|min:10|max:300',
            'vagas' => 'integer|min:1',
            'valor' => array('regex:/^[1-9][0-9]+\.[0-9]{2}$/'), 
            'vencimento' => array('regex:/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\s([0-1][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/') ,
        ];
    }

    public function messages(){
        return [
            'descricao.min' => 'A descrição deve ter no mínimo 10 caracteres.',
            'descricao.max' => 'A descrição deve ter no máximo 300 caracteres',
            'vagas.integer' => 'O número de vagas deve ser um número inteiro.',
            'vagas.min' => 'O número de vagas deve ser maior que zero.',
            'valor.regex' => 'O valor deve obedecer o seguinte formato: 10.00',
            'vencimento.regex' => 'O vencimento deve obedecer o seguinte formato: ano-mes-dia hora:min:seg',
        ];
    }
}
