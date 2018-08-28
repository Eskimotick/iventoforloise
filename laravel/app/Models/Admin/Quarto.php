<?php

namespace App\Models\Admin;

use App\Models\Admin\Hospedagem;
use Illuminate\Database\Eloquent\Model;

class Quarto extends Model
{
    protected $fillable = [];


    public function createQuarto($request){

        $this->nome = $request->nome;
        $this->descricao = $request->descricao;
        $this->hospedagem_id = $request->hospedagem_id;
        $this->vagas = $request->vagas;

        $this->save();

    }

    public function updateQuarto($request, $vagasDisponiveis){
        // ver como vai ficar isso se tiver que editar para todos os quartos
        // de mesmo nome...
        if($request->nome){
            $num = explode('-', $this->nome, 2)[1];
            $this->nome = $request->nome.' - '.$num;
        }
        
        $this->descricao = $request->descricao;
        $this->vagas = $request->vagas;

        $this->save();
        

    }
}
