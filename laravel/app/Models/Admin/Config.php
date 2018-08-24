<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{

    // metodo para setar datas das inscricoes
    public function updateInscricoes($request){

        if($request->inicio_inscricoes){
            $hoje = date('Y-m-d');
            $inicio_inscricoes = explode(' ',$request->inicio_inscricoes, 2)[0];            

            if($hoje >= $inicio_inscricoes){
                return 'A data de inicio das inscricoes deve ser uma data futura.';
            }
            else{
                $this->inicio_inscricoes = $request->inicio_inscricoes;
                $this->save();
            }
            
        }

        if($request->fim_inscricoes){

            if($this->inicio_inscricoes >= $request->fim_inscricoes){
                return 'A data de fim das inscrições deve ser após a data de inicio das inscrições.';
            }
            else{
                $this->fim_inscricoes = $request->fim_inscricoes;
                $this->save();
            }
            
        }
        
    }

    // método para setar datas do evento
    public function updateEvento($request){
        
        if($request->inicio_evento){

            if($this->fim_inscricoes >= $request->inicio_evento){
                return 'A data de inicio do evento deve ser após o fim das inscrições.';
            }
            else{
                $this->inicio_evento = $request->inicio_evento;
                $this->save();
            }
            
        }

        if($request->fim_evento){          

            if($this->inicio_evento >= $request->fim_evento){
                return 'A data de fim do evento deve ser após a data de inicio do evento.';
            }
            else{
                $this->fim_evento = $request->fim_evento;
                $this->save();
            }
            
        }
    }

    // metódo para trancar/abrir inscrições manualmente
    public function adminChangeStatus($status){

        // $status = 0 - evento aberto;
        // $status = 2 - evento trancado pelo admin
        $hoje = date('Y-m-d');
        $fim_inscricoes = explode(' ',$this->fim_inscricoes, 2)[0];            
        
        if($hoje >= $fim_inscricoes){
            return 'Não é mais possível abrir/fechar as inscrições pois elas já se encerraram.';
        }
        else{
            $this->status = $status;
            $this->save();
        }
    }
}
