<?php

namespace App\Models\Admin;
use App\Models\Admin\Lote;
use App\Http\Requests\Admin\StorePacoteRequest;
use App\Http\Requests\Admin\UpdatePacoteRequest;

use Illuminate\Database\Eloquent\Model;

class Pacote extends Model
{
    //
    protected $fillable = [];

    public function createPacote($request){

        $this->descricao = $request->descricao;
        $this->lotes = $request->lotes;
        $this->vagas = $request->vagas;

        $this->save();

        $vagas = round($this->vagas/$this->lotes);

        $dados = [
            'pacote_id' => $this->id,
            'vagas' => $vagas,
        ];

        $dados = (object) $dados;
        $vagas = 0;

        //cria todos os lotes
        for($i = 1; $i<= $this->lotes; $i++){

            $lote = new Lote;

            //se for ultimo lote atualiza o valor das vagas para
            // vagas_totais - vagas_lotes_anteriores
            if($i == $this->lotes){
                $dados->vagas = $this->vagas - $vagas;
            }

            $lote->createLote($dados, $i);
            $vagas += $dados->vagas;
        }
        
    }

    public function updatePacote($request){
        
        if($request->descricao){
            $this->descricao = $request->descricao;
        }
        if($request->lotes){
            $this->lotes = $request->lotes;
        }
        if($request->vagas){
            $this->vagas = $request->vagas;
        }
        if($request->lote_atual){
            $this->lote_atual = $request->lote_atual;
        }
        
        $this->save();
    }
}
