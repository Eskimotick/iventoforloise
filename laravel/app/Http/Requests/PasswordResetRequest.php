<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
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
          'password' => 'required|min:6',
          'c_password' => 'required|same:password',
         ];
     }

     public function messages()
      {
        return [
          'password.required' => 'Entre com sua nova senha.',
          'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
          'c_password.required' => 'Por favor confirme sua senha.',
          'c_password.same' => 'As senhas não batem.',
        ];
      }
}
