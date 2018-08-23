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

        if($request->vagas){

            $resposta = $this->verificaVagas($request->vagas);
            if(gettype($resposta) == 'string'){
                return $resposta;
            } 
            else{
                $this->vagas = $request->vagas;
            }
            
        }
        if($request->descricao){
            $this->descricao = $request->descricao;
        }
        if($request->valor){
            $this->valor = $request->valor;
        }
        if($request->vencimento){
            $this->vencimento = $request->vencimento;
        }

        $this->save();
        
    }

    public function verificaVagas($vagas){

        //pega o pacote pai do lote
        $pacote = $this->belongsTo('App\Models\Admin\Pacote', 'id')->first();
        
        // se o número de vagas da request for maior que 
        if($vagas >= $pacote->vagas){
            return 'Número de vagas deve ser menor que o número total de vagas do Pacote';
        }

        if($vagas > $this->vagas){
            $ultimoLote = Lote::where('pacote_id', $pacote->id)->where('lote', $pacote->lotes)->first();
            $vagas = $vagas - $this->vagas;
            if($ultimoLote->vagas <= $vagas){
                return 'O número de vagas disponíveis é menor que o número digitado';
            }
            else{
                
            }
        }

        if($vagas < $this->vagas){

        }

    }

}
