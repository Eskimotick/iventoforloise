<?php

namespace App\Models\Admin;

use App\User;
use App\Models\Admin\Hospedagem;
use Illuminate\Database\Eloquent\Model;

class Quarto extends Model
{
    protected $fillable = [];

    public function pacotes(){
        return $this->belongsToMany('App\Models\Admin\Pacote', 'pacotes_quartos');
    }

    public function associaQuartoPacotes($pacotes){
        $this->pacotes()->withTimestamps()->attach($pacotes);
    }

    public function desassociaQuartoPacotes($excluirPacotes){
        $this->pacotes()->detach($excluirPacotes);
    }

    public function createQuarto($request){

        $this->nome = $request->nome;
        $this->descricao = $request->descricao;
        $this->hospedagem_id = $request->hospedagem_id;
        $this->vagas = $request->vagas;

        $this->save();

        $pacotes = $this->stringToArray($request->pacotes);
        $this->associaQuartoPacotes($pacotes);

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
        
        // // ver como fazer o update dependendo se vier com novos pacotes ou pacotes a menos
        // pensando q vai ser melhor criar função separada pra adicionar e remover os pacotes...
        // if($request->pacotes){
        //     $requestPacotes = $this->stringToArray($request->pacotes);
        //     $qnt_pacotes = $this->pacotes()->count();
        //     $pacotes = $this->pacotes()->select('pacote_id')->get();
        //     $pacotes = $pacots->pluck('pacote_id');

        //     if($qnt_pacotes < count($requestPacotes)){
        //         for($i = $qnt_pacotes; $i <= count($requestPacotes); $i++){
        //             $this->associaQuartoPacotes($requestPacotes[$i]);
        //         }
        //     }
        //     elseif($qnt_pacotes > count($requestPacotes)){

        //     }
        // }

        if($request->nome){
            
            //atualiza o nome em todos os quartos de mesmo nome.
            foreach($quartos as $quarto){
                
                $num = explode('-', $quarto->nome, 2)[1];
                $quarto->nome = $request->nome.' -'.$num;
                $quarto->save();

            }
        
        }

        return $quartos;
        
    }

    // função para converter a string com ids de pacote para array
    // formato da string = '1, 2, 3, 4'
    public function stringToArray($string){

        $string = str_replace(' ','', $string);
        $array = explode(',', $string, 3);

        return $array;
    }

    // ocupa uma vaga no quarto que chama a função
    public function preencheVaga(){
        if($this->vagas_ocupadas < $this->vagas ){
            $this->vagas_ocupadas++;
            $this->save();
        }
        else{
            return 'todas as vagas deste quarto estão ocupadas no momento.';
        }
    }

    //remove uma vaga do quarto que chama a função
    public function removeVaga(){
        $this->vagas_ocupadas--;
        $this->save();
    }

    // função para admin alocar o user no quarto
    public function alocaUser($userCPF){

        //verifica se o cpf é valido
        if(!User::validar_cpf($userCPF)){
            return 'CPF inválido'; 
        }  

        $user = User::where('cpf', $userCPF)->first();
        
        if(!$user){
            return 'usuario não encontrado, verifique se o cpf está cadastrado no sistema.';
        }

        $resposta = $user->alocaUserQuarto($this->id);

        if(gettype($resposta) == 'string'){
            return $resposta;
        }

        return $resposta;
    }

    // função para admin desalocar o user do quarto
    public function desalocaUser($userCPF){
        
        //verifica se o cpf é valido
        if(!User::validar_cpf($userCPF)){
            return 'CPF inválido'; 
        }

        $user = User::where('cpf', $userCPF)->first();

        if(!$user){
            return 'usuario não encontrado, verifique se o cpf está cadastrado no sistema.';
        }

        return $user->desalocaUserQuarto();    

    }
}
