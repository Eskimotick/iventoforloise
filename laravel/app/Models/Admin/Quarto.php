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

    public function updateQuarto($request){
        
        $nome = explode('-', $this->nome, 2)[0];
        $quartos = Quarto::where('nome','LIKE', $nome."-%")->get();
        
        if($request->vagas){
            // resgata a hospedagem do quarto
            $hospedagem = $this->belongsTo('App\Models\Admin\Hospedagem', 'hospedagem_id', 'id')->first();
            
            // soma as vagas de todos os quartos com mesma hospedagem
            $vagasQuartos = Quarto::where('hospedagem_id', $hospedagem->id)->sum('vagas');

            //verifica se as vagas requisitadas podem ser alocadas
            $resposta = $hospedagem->verificaVagasDisponiveis($vagasQuartos, $request->vagas, $quartos->count());

            if(gettype($resposta) == 'string'){
                return $resposta;
            }
        
            //atualiza as vagas em todos os quartos
            Quarto::where('nome','LIKE', $nome."-%")->update(['vagas' => $request->vagas]);
        }
        

        if($request->descricao){

            //atualiza a descrição em todos os quartos
            Quarto::where('nome','LIKE', $nome."-%")->update(['descricao' => $request->descricao]);
        }
        



        if($request->nome){
            
            //atualiza o nome em todos os quartos de mesmo nome.
            foreach($quartos as $quarto){
                
                $num = explode('-', $quarto->nome, 2)[1];
                $quarto->nome = $request->nome.'-'.$num;
                $quarto->save();

            }
        
        }

        // $this->save();
        

    }
}
