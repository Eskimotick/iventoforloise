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
        'Nome' => $this->name,
        'e-mail' => $this->email,
        'Admin' => $this->admin,
      ];
    }
}
