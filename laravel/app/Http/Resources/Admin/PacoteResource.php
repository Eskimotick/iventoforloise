<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PacoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'descricao' => $this->descricao,
            'lotes' => $this->lotes,
            'vagas' => $this->vagas,
            'vagas_ocupadas' => $this->vagas_ocupadas,
            'status' => $this->status,
            'lote_atual' => $this->lote_atual,
            'pagamentos_abertos' => $this->pagamentos_abertos,
        ];
    }
}
