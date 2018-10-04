<?php

namespace App\Models\Admin;

use App\User;
use App\Models\Admin\Hospedagem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Quarto extends Model
{
    protected $fillable = [];

    public function pacotes(){
        return $this->belongsToMany('App\Models\Admin\Pacote', 'pacotes_quartos');
    }

    public function associaPacotes($pacotes){
        $this->pacotes()->withTimestamps()->attach($pacotes);
    }

    public function desassociaPacotes($excluirPacotes){
        $this->pacotes()->detach($excluirPacotes);
    }
    public function users(){
        return $this->hasMany('App\User');
    }

    public function createQuarto($request){

        $this->nome = $request->nome;
        $this->descricao = $request->descricao;
        $this->hospedagem_id = $request->hospedagem_id;
        $this->vagas = $request->vagas;
        $this->img_path = $request->img_path;

        $this->save();

        $pacotes = $this->stringToArray($request->pacotes);
        $this->associaPacotes($pacotes);

    }

    public function updateQuarto($request){
        
        //corrigir tirar os espaços das palavras das variaveis quarto comum 2 
        $nome = explode('-', $this->nome, 2)[0];
        $quartos = Quarto::where('nome','LIKE', $nome."-%")->get();

        $nomeExiste = Quarto::where('nome','LIKE', $request->nome." -%")->count();
        
        //verifica se já existem quartos com esse nome.
        if($nomeExiste != 0){
            return "Já existem quartos com esse nome = ".$request->nome;
        }
        
        //imagem dos quartos
        if($request->img_path){
            
            $imgName = $this->updateImgPath($request->img_path);
            Quarto::where('nome','LIKE', $nome."-%")->update(['img_path' => $imgName]);
        }

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
        
        //atualiza a quais pacotes o quarto pertence.
        if($request->pacotes){
            
            $requestPacotes = $this->stringToArray($request->pacotes);
            $qnt_pacotes = $this->pacotes()->count();

            //pega todos os pacotes do pivot
            $pacotes = $this->pacotes()->select('pacote_id')->get();
            //transforma a collection em array só com os ids do pacote
            $pacotes = $pacotes->pluck('pacote_id')->toArray();

            if($qnt_pacotes < count($requestPacotes)){

                //verifica os ids que serão adicionados a tabela pivot
                $diferenca = array_diff($requestPacotes, $pacotes);
                foreach($quartos as $quarto){
                    $quarto->associaPacotes($diferenca);
                    $quarto->save();
                }
            }
            else{
                //verifica os ids que serão retirados da tabela pivot
                $diferenca = array_diff($pacotes, $requestPacotes);
                
                //testa se existe algum id que ainda não ta na tabela
                if(!empty($diferenca)){
                    
                    foreach($quartos as $quarto){
                        $quarto->desassociaPacotes($diferenca);
                        $quarto->save();
                    }
                }

                // ##TESTAR -> verificar se vai causar algum conflito.
                $diferenca = array_diff($requestPacotes, $pacotes);

                if(!empty($diferenca)){
                    
                    foreach($quartos as $quarto){
                        $quarto->associaPacotes($diferenca);
                        $quarto->save();
                    }
                }

            }
        }

        if($request->nome){
            
            //atualiza o nome em todos os quartos de mesmo nome.
            foreach($quartos as $quarto){
                
                //corrigir tirar os espaços do nome se der ruim
                $num = explode('-', $quarto->nome, 2)[1];
                $quarto->nome = $request->nome.' -'.$num;
                $quarto->save();

            }
            
            $quartos = Quarto::where('nome','LIKE', $request->nome." -%")->get();
        }
        
        return $quartos;
        
    }

    // função para converter a string com ids de pacote para array
    // formato da string = '1, 2, 3, 4'
    public function stringToArray($string){

        $string = str_replace(' ','', $string);
        $array = explode(',', $string);

        return $array;
    }

    // ocupa uma vaga no quarto que chama a função
    public function preencheVaga(){
        $hospedagem = Hospedagem::find($this->hospedagem_id);

        if($this->vagas_ocupadas < $this->vagas ){
            $this->vagas_ocupadas++;
            $this->save();
            
            $hospedagem->vagas_ocupadas++;
            $hospedagem->save();
        }
        else{
            return 'todas as vagas deste quarto estão ocupadas no momento.';
        }
    }

    //remove uma vaga do quarto que chama a função
    public function removeVaga(){
        $hospedagem = Hospedagem::find($this->hospedagem_id);

        $this->vagas_ocupadas--;
        $this->save();
        
        $hospedagem->vagas_ocupadas--;
        $hospedagem->save();
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

    public function updateImgPath($img){
        
        Storage::delete('localPhotos/'.$this->img_path);
        //lógica para o upload de imagens.
        if(!Storage::exists('localPhotos/')){
            Storage::makeDirectory('localPhotos/', 0775, true);
            //decodifica a string em base64 e a atribui a uma variável
        }
            
        $image = base64_decode($img);
            
        //gera um nome único para o arquivo e concatena seu nome com a    
        //extensão ‘.png’ para termos de fato uma imagem
        $imgName = uniqid() . '.png';
            
        //atribui a variável o caminho para a imagem que é constituída do 
        //caminho das pastas e o nome do arquivo
        $path = storage_path('/app/localPhotos/'.$imgName);
            
        //salva o que está na variável $image como o arquivo definido em $path
        file_put_contents($path,$image);

        return $imgName;
    }
}
