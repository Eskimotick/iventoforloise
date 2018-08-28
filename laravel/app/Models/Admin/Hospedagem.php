<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Hospedagem extends Model
{
    protected $fillable = [];

    public function createHospedagem($request){

        $this->nome = $request->nome;
        $this->descricao = $request->descricao;
        $this->localizacao = $request->localizacao;
        $this->vagas = $request->vagas;

        $this->save();
    }

    public function UpdateHospedagem($request){

        if($request->nome){
            $this->nome = $request->nome;
        }
        
        if($request->descricao){
            $this->descricao = $request->descricao;
        }
        
        if($request->localizacao){
            $this->localizacao = $request->localizacao;
        }
        
        if($request->vagas){
            //verificar se as vagas dos quartos sao maiores que as vagas da request
            //se forem impedir a mudança até o user deletar algum quarto.
            $this->vagas = $request->vagas;
        }
        
        $this->save();

    }
}
