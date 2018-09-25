<?php

namespace App\Http\Requests;

use App\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAtividadeRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  protected function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json($validator->errors(), 422));
  }

  public function rules()
  {
    $formato_data = array('regex:/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\s([0-1][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/');

    return [
      'data_inicio' => $formato_data,
      'data_fim' => $formato_data,
    ];
  }

  //Mensagens de falha na validação.
  public function messages()
   {
     return [
       'data_inicio.regex' => 'A data deve estar no formato AAAA-MM-DD HH:MM:SS.',
       'data_fim.regex' => 'A data deve estar no formato AAAA-MM-DD HH:MM:SS.',
     ];
   }
}
