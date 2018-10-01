<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class HospedagemResource extends JsonResource
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
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'localizacao' => $this->localizacao,
            'vagas' => $this->vagas,
            'vagas_ocupadas' => $this->vagas_ocupadas,
            'status' => $this->status,
            'img' => base64_encode(file_get_contents(storage_path('app/localPhotos/'.$this->img_path)))
        ];
    }
}
