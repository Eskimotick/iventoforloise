<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AtividadeResource extends JsonResource
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
            'ID' => $this->id,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'palestrante' => $this->palestrante,
            'data_inicio' => $this->data_inicio,
            'data_fim' => $this->data_fim,
            'vagas' => $this->vagas,
            'vagas_ocupadas' => $this->vagas_ocupadas,
            'status' => $this->status,
            'pacotes' => $this->pacotes
        ];
    }
}
