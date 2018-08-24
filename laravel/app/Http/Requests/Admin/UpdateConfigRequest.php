<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateConfigRequest extends FormRequest
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
        $formato_data = array('regex:/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\s([0-1][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/');

        return [
            'status' => 'integer|min:0|max:3',
            'inicio_inscricoes' => $formato_data,
            'fim_inscricoes' => $formato_data,
            'inicio_evento' => $formato_data,
            'fim_evento' => $formato_data,
            'fim_pagamentos' => $formato_data,
            // 'background_img_path' => ,
            // 'logo_img_path' => ,
            // 'favicon_img_path' => ,
            // 'nome_evento' => ,
        ];
    }

    public function messages(){
        return [
            'status.integer' => 'O código do status é armazenado como número.',
            'status.min' => 'Código do status inválido, abaixo dos permitidos.',
            'status.max' => 'Código do status inválido, acima dos permitidos.',
            'inicio_inscricoes.regex' => 'A data deve obedecer o seguinte formato: 2018-10-04 00:00:00',
            'fim_inscricoes.regex' => 'A data deve obedecer o seguinte formato: 2018-10-10 23:59:59',
            'inicio_evento.regex' => 'A data deve obedecer o seguinte formato: 2018-10-12 00:00:00',
            'fim_evento.regex' => 'A data deve obedecer o seguinte formato: 2018-10-12 23:59:59',
            'fim_pagamentos.regex' => 'A data deve obedecer o seguinte formato: 2018-10-31 23:59:59',
        ];
    }
}

