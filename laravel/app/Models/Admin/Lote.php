<?php

namespace App\Models\Admin;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $fillable = [];

    // método só é chamado pela model de pacotes
    public function createLote($dados, $lote){

        $this->lote = $lote;
        $this->pacote_id = $dados->pacote_id;
        $this->vagas = $dados->vagas;
        $this->descricao = 'NAO PAGAR ESTE LOTE! Avise ao admin sobre este problema';
        $this->valor = '100000.00';
        $this->vencimento = '2099-12-31 23:59:59';

        $this->save();        

    }

    //método utilizado pelo admin
    public function updateLote($request){
        
        //pega quantidade de lotes do Pacote
        $lotesPacote = $this->belongsTo('App\Models\Admin\Pacote', 'pacote_id')->max('lotes');
        
        if($request->vagas){
            
            //faz as validações das quantidades de vagas entre os lotes
            $resposta = $this->verificaVagas($request->vagas);

            if(gettype($resposta) == 'string'){
                return $resposta;
            } 
            else{
                $this->vagas = $resposta;
            }
            
        }
        if($request->descricao){
            $this->descricao = $request->descricao;
        }
        if($request->valor){
            $this->valor = $request->valor;
        }
        if($request->vencimento){
            $hoje = date('Y-m-d');
            $vencimento = explode(' ',$request->vencimento, 2)[0];            

            if($hoje >= $vencimento){
                return 'A data de vencimento deve ser uma data futura.';
            }
            else{
                $this->vencimento = $request->vencimento;
            }
            
        }
        
        //se for ultimo lote o vencimento é a data final das inscrições
        // if($this->lote == $lotesPacote){
        //     $this->vencimento = $config->fim_inscricoes;
        // }

        $this->save();
        
    }

    public function verificaVagas($vagas){

        //pega o pacote pai do lote
        $pacote = $this->belongsTo('App\Models\Admin\Pacote', 'pacote_id')->first();
        
        // se for o ultimo lote
        if($this->lote == $pacote->lotes){
            return 'Para alterar as vagas do último Lote, adicione ou remova vagas dos lotes anteriores.';
        }
        
        //se o numero de vagas for igual ao das vagas atuais nao faz nada
        if($vagas == $this->vagas){
            return $this->vagas;
        }
        
        // se o número de vagas da request for maior que as vagas do Pacote pai
        if($vagas >= $pacote->vagas){
            return 'Número de vagas deve ser menor que o número total de vagas do Pacote';
        }

        // se o número de vagas da request for maior que as vagas do Lote 
        if($vagas > $this->vagas){
            
            $ultimoLote = Lote::where('pacote_id', $pacote->id)->where('lote', $pacote->lotes)->first();
            $vagas = $vagas - $this->vagas;
            if($ultimoLote->vagas <= $vagas){
                return 'O número de vagas disponíveis é menor que o número digitado';
            }
            else{
                $ultimoLote->vagas -= $vagas;
                $ultimoLote->save();
                $vagas += $this->vagas;
                return $vagas;
            }
        }

        // se o número de vagas da request for menor que as vagas do Lote
        if($vagas < $this->vagas){

            $ultimoLote = Lote::where('pacote_id', $pacote->id)->where('lote', $pacote->lotes)->first();
            $vagasRequest = 0;
            $vagasRequest += $vagas;
            
            $vagas = $this->vagas - $vagas;
            if($vagas < 0){
                return 'As vagas não podem ser maior que o número de vagas do lote';
            }
            else{
                $ultimoLote->vagas += $vagas;
                $ultimoLote->save();    
                return $vagasRequest;
            }

        }

    }

}
