<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmRegisterRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cpf' => 'required|cpf|formato_cpf',
            'nome_completo' => 'required|regex:/^[\pL\s\-]+$/u|max:80',
        ];
    }

    // Mensagens de falha na validação.
    public function messages()
    {
        return [
            'cpf.required' => 'É necessário entrar com o CPF.',
            'cpf.cpf' => 'CPF inválido.',
            'cpf.cpf_formato' => 'O CPF precisa estar no formato xxx.xxx.xxx-xx.',
            'nome_completo.required' => 'Por favor preencha seu nome.',
            'nome_completo.regex' => 'O nome só pode conter caracteres alfabéticons, espaços e hífen.',
            'nome_completo.max' => 'O nome deve ter no máximo 80 caracteres.',            
    ];
  }
}
