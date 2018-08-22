<?php

namespace App\Models\Admin;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $fillable = [];

    public function createLote($dados, $lote){

        $this->lote = $lote;
        $this->pacote_id = $dados->pacote_id;
        $this->vagas = $dados->vagas;
        $this->descricao = 'NAO PAGAR ESTE LOTE! Avise ao admin sobre este problema';
        $this->valor = '100000.00';
        $this->vencimento = '2099-12-31 23:59:59';

        $this->save();        

    }

    public function updateLote($request){

        if($request->vagas){
            $this->vagas = $request->vagas;
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
}
