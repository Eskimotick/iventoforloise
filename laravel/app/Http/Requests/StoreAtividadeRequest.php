<?php

namespace App\Http\Requests;

use App\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAtividadeRequest extends FormRequest
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
    $formato_data = array('required','regex:/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\s([0-1][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/');

    return [
      'titulo' => 'required',
      'descricao' => 'required',
      //'palestrante' => 'required',
      'data_inicio' => $formato_data,
      'data_fim' => $formato_data,
      'vagas' => 'required',
      //'vagas_ocupadas' => 'required',
      //'status' => 'required',
      'pacotes' => 'required'
    ];
  }

  //Mensagens de falha na validação.
  public function messages()
   {
     return [
       'titulo.required' => 'Por favor preencha o título da atividade.',
       'descricao.required' => 'Por favor preencha a descrição da atividade.',
       'palestrante.required' => 'Por favor entre com os nomes dos palestrantes.',
       'data_inicio.required' => 'Entre com a data e o horário de início da atividade.',
       'data_inicio.regex' => 'A data deve estar no formato AAAA-MM-DD HH:MM:SS.',
       'data_fim.required' => 'Entre com a data e o horário do fim da atividade.',
       'data_fim.regex' => 'A data deve estar no formato AAAA-MM-DD HH:MM:SS.',
       'vagas.required' => 'Diga quantas vagas estão disponíveis para a atividade.',
       //'vagas_ocupadas.required' => 'Entre com a quantidade de vagas ocupadas.',
       //'status.required' => 'Entre com o status da atividade.',
       'pacotes.required' => 'É necessário pertencer a pelo menos um pacote',
     ];
   }
}
