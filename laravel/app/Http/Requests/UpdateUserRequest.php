<?php

namespace App\Http\Requests;

use App\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
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
        'name' => 'regex:/^[\pL\s\-]+$/u|max:255',
        'email' => 'email|unique:users|max:255',
        'password' => 'min:6',
        'c_password' => 'same:password',
      ];
    }

    // Mensagens de falha na validação.
    public function messages()
     {

       return [
         'nickame.regex' => 'O nome deve consistir apenas de caracteres alfabéticos.',
         'nickame.max' => 'O nome deve ter no máximo 255 caracteres.',
         'email.email' => 'O e-mail não está no formato correto',
         'email.unique' => 'Este e-mail já foi cadastrado, entre com outro.',
         'email.max' => 'O e-mail deve ter no máximo 255 caracteres.',
         'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
         'c_password.same' => 'As senhas não batem.',
       ];
     }
  }
