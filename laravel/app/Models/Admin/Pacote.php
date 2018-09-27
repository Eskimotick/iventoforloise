<?php

namespace App\Models\Admin;

use App\Models\Admin\Lote;
use Illuminate\Database\Eloquent\Model;

class Pacote extends Model
{
    //
    protected $fillable = [];

    public function quartos(){
        return $this->belongsToMany('App\Models\Admin\Quarto', 'pacotes_quartos');
    }

    public function createPacote($request){

        $this->nome = $request->nome;
        $this->descricao = $request->descricao;
        $this->lotes = $request->lotes;
        $this->vagas = $request->vagas;

        $this->save();

        //cria todos os lotes do pacote
        $this->geraLotesPacote(1, $this->lotes);

        //atualiza vagas dos lotes
        $this->atualizaVagasLotes($this->vagas, $this->lotes);
        
    }

    public function updatePacote($request){
        
        //atualiza nome do pacote
        if($request->nome){
            $this->nome = $request->nome;
        }
        //atualiza descrição
        if($request->descricao){
            $this->descricao = $request->descricao;
        }
        
        //## também mexe na tabela lotes ##
        if($request->lotes){
            
            //lotes novos menores que lotes do pacote
            if($request->lotes < $this->lotes){
            
                if($this->lote_atual > $request->lotes and !$request->lote_atual){
                    $this->lote_atual = $request->lotes;
                }
                
                //apaga os lotes acima do total de lotes novo do pacote
                Lote::where('pacote_id', $this->id)
                    ->where('lote', '>', $request->lotes)->delete();
                
                //atualizar vagas dos lotes
                $this->atualizaVagasLotes($this->vagas, $request->lotes);

                $this->lotes = $request->lotes;
            }
            
            // se lotes novos maiores que os lotes do pacote
            if($request->lotes > $this->lotes){
                
                //cria lotes do pacote
                $this->geraLotesPacote($this->lotes+1, $request->lotes);
                
                //atualiza vagas dos lotes
                $this->atualizaVagasLotes($this->vagas ,$request->lotes);

                $this->lotes = $request->lotes;
            }
        }

        //## também mexe na tabela lotes ##
        if($request->vagas){

            //atualiza vagas dos lotes
            $this->atualizaVagasLotes($request->vagas ,$this->lotes);

            $this->vagas = $request->vagas;
        }

        if($request->lote_atual){
            $this->lote_atual = $request->lote_atual;
        }
        
        $this->save();
    }

    //cria todos os lotes referentes ao pacote
    // $inicio = valor inicial do loop
    // $lotes = valor final do loop
    public function geraLotesPacote($inicio, $lotes){
        
        $dados = [
            'pacote_id' => $this->id,
            'vagas' => 0,
        ];
        
        $dados = (object) $dados;

        //cria os novos lotes
        for($i = $inicio; $i <= $lotes; ++$i){
            $lote = new Lote;
            $lote->createLote($dados, $i);
        }

    }

    //atualiza as vagas dos lotes existentes caso:
    // 1 - tenha alterado quantidade total de lotes do pacote
    // 2- tenha alterado a quantidade total de vagas do pacote
    public function atualizaVagasLotes($vagasTotais,$lotesPacote){
        $lotes = Lote::where('pacote_id', $this->id)->get();
        
        $vagas = round($vagasTotais/$lotesPacote);

        foreach($lotes as $lote){
            
            if($lote->lote == $lotesPacote){
                $vagasLotes = Lote::where('pacote_id', $this->id)
                            ->where('lote','<',$lotesPacote)->sum('vagas');
                
                $lote->vagas = $vagasTotais - $vagasLotes;
                $lote->save();
            }
            else{
                $lote->vagas = $vagas;
                $lote->save();
            }
            
        }
    }
}
