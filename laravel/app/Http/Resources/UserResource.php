<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    // Retorna os dados de User como um array em JSON.
    public function toArray($request)
    {
      return [
        'ID' => $this->id,
        'Nome' => $this->nickname,
        'e-mail' => $this->email,
        'CPF' => $this->cpf,
        'Nome Completo' => $this->nome_completo,
        'Admin' => $this->admin,
        'Código de Confirmação de e-mail' => $this->confirmation_code,
        'Código de Redefinição de Senha' => $this->password_reset_code,
        'Campos' => $this->campos
      ];
    }
}
