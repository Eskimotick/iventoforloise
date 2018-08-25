<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewEmailRequest extends FormRequest
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
          'current_email' => 'required|email|max:80',
          'new_email' => 'required|email|max:80'
        ];
    }

    // Mensagens de falha na validação.
    public function messages()
     {
       return [
         'current_email.required' => 'É necessário preencher o campo de e-mail.',
         'current_email.email' => 'O e-mail não está no formato correto.',
         'current_email.max' => 'O e-mail deve ter no máximo 80 caracteres.',
         'new_email.required' => 'É necessário preencher o campo de e-mail.',
         'new_email.email' => 'O e-mail não está no formato correto.',
         'new_email.max' => 'O e-mail deve ter no máximo 80 caracteres.'
       ];
     }
}
