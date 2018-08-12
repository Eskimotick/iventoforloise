<?php

namespace App\Http\Requests;

use App\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
  public function authorize()
  {
      return true;
  }

  protected function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json($validator->errors(), 422));
  }

  // Regras de validação para o usuário.
  public function rules()
  {
    return [
      'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
      'email' => 'required|email|max:255',
      'password' => 'required|min:6',
      'c_password' => 'required|same:password',
    ];
  }

  // Mensagens de falha na validação.
  public function messages()
   {
     return [
       'name.required' => 'É necessário fornecer um nome.',
       'name.regex' => 'O nome deve consistir apenas de caracteres alfabéticos.',
       'name.max' => 'O nome deve ter no máximo 255 caracteres.',
       'email.required' => 'É necessário preencher o campo de e-mail.',
       'email.email' => 'O e-mail não está no formato correto',
       'email.max' => 'O e-mail deve ter no máximo 255 caracteres.',
       'password.required' => 'É necessário entrar com uma senha.',
       'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
       'c_password.required' => 'Por favor confirme sua senha.',
       'c_password.same' => 'As senhas não batem.',
     ];
   }
}
