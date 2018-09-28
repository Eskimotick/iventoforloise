<?php

namespace App\Models\Admin;

use App\Models\Admin\Quarto;
use Illuminate\Database\Eloquent\Model;

class Hospedagem extends Model
{
    protected $fillable = [];

    public function createHospedagem($request){

        $this->nome = $request->nome;
        $this->descricao = $request->descricao;
        $this->localizacao = $request->localizacao;
        $this->vagas = $request->vagas;

        //lógica para o upload de imagens.
        if(!Storage::exists('localPhotos/')){
            Storage::makeDirectory('localPhotos/', 0775, true);
        }
        
        //decodifica a string em base64 e a atribui a uma variável
        $image = base64_decode($request->img_path);
        
        //gera um nome único para o arquivo e concatena seu nome com a
        //extensão ‘.png’ para termos de fato uma imagem
        $imgName = uniqid() . '.png';
        
        //atribui a variável o caminho para a imagem que é constituída do
        //caminho das pastas e o nome do arquivo
        $path = storage_path('/app/localPhotos/'.$imgName);
        
        //salva o que está na variável $image como o arquivo definido em $path
        file_put_contents($path,$image);
        $this->img_path = $imgName;


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
            $vagasQuartos = $this->hasMany('App\Models\Admin\Quarto')->sum('vagas');
            if($request->vagas < $vagasQuartos){
                return "Quantidade de vagas é menor que a quantidade de vagas já ocupadas pelos quartos.".
                        " Favor deletar os quartos antes de alterar as vagas.";
            }
            $this->vagas = $request->vagas;
        }

        if($request->img_path){
            Storage::delete('localPhotos/'.$atividade->img_path);
            //lógica para o upload de imagens.
            if(!Storage::exists('localPhotos/')){
                Storage::makeDirectory('localPhotos/', 0775, true);
                //decodifica a string em base64 e a atribui a uma variável
            }
            
            $image = base64_decode($request->img_path);
            
            //gera um nome único para o arquivo e concatena seu nome com a    
            //extensão ‘.png’ para termos de fato uma imagem
            $imgName = uniqid() . '.png';
            
            //atribui a variável o caminho para a imagem que é constituída do 
            //caminho das pastas e o nome do arquivo
            $path = storage_path('/app/localPhotos/'.$imgName);
            
            //salva o que está na variável $image como o arquivo definido em $path
            file_put_contents($path,$image);
            $this->img_path = $imgName;
        }

        
        $this->save();

    }

    public function validaCriacaoQuartos($request){
        
        $vagasQuartos = Quarto::where('hospedagem_id', $this->id)->sum('vagas');
        $nomeExiste = Quarto::where('nome','LIKE', $request->nome." -%")->count();
        
        //verifica se já existem quartos com esse nome.
        if($nomeExiste != 0){
            return "Já existem quartos com esse nome = ".$request->nome;
        }
        
        $resposta = $this->verificaVagasDisponiveis($vagasQuartos, $request->vagas, $request->qnt_quartos);

        if(gettype($resposta) == 'string'){
            return $resposta;
        }

        for($i = 1; $i <= $request->qnt_quartos; $i++){
            
            // verifica se o numero do quarto é menor que 10 para adicionar o 0 antes do número
            // para ficar bonitinho no nome.
            $nome = $i < 10 ?  $request->nome.' - 0'.$i : $request->nome.' - '.$i;
            $dados = [
                'nome' => $nome,
                'descricao' => $request->descricao,
                'hospedagem_id' => $this->id,
                'vagas' => $request->vagas,
                'pacotes' => $request->pacotes
            ];

            $dados = (object)$dados;

            $novoQuarto = new Quarto;
            $novoQuarto->createQuarto($dados);
        }

    }

    public function verificaVagasDisponiveis($vagasQuartos, $requestVagas, $qntQuartos){
        
        //verificar vagas disponiveis com quantidade de vagas.
        $vagasDisponiveis = $this->vagas - $vagasQuartos;
        
        if($vagasDisponiveis <= 0){
            return 'Quantidade de vagas livres esgotadas.';
        }
        
        $quartosPossiveis = (integer)($vagasDisponiveis / $requestVagas);

        if($quartosPossiveis < $qntQuartos){
            return 'O máximo de quartos possíveis a ser criados'. 
                    ' com este número de vagas é '.$quartosPossiveis.
                    '. Quantidade de vagas livres disponíveis = '.$vagasDisponiveis;
        }

    }

    public function getQuartos(){
        
        $listaQuartos = $this->hasMany('App\Models\Admin\Quarto')->get();

        return $listaQuartos;
    }
}
