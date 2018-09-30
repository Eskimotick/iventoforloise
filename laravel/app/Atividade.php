<?php

namespace App;

use App\Http\Requests\UpdateAtividadeRequest;
use App\Http\Requests\StoreAtividadeRequest;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\UsuarioAtividade;
use Auth;

class Atividade extends Model
{
  use Notifiable;

  protected $fillable = [
    'titulo', 'descricao', 'data_inicio', 'data_fim', 'vagas', 'vagas_ocupadas', 'img_path', 'status'
  ];

    //retorna os pacotes relacionados a essa atividade
    public function pacotes(){
        return $this->belongsToMany('App\Models\Admin\Pacote', 'pacote_atividades');
    }

    //atrela um pacote para essa atividade
    public function associaPacotes($pacotes){
        $this->pacotes()->withTimestamps()->attach($pacotes);
    }

    //remove um pacote dessa atividade
    public function desassociaPacotes($excluirPacotes){
        $this->pacotes()->detach($excluirPacotes);
    }

  //Função para criar novas atividades.
  public function createActivity(StoreAtividadeRequest $request)
  {
    $this->titulo = $request->titulo;
    $this->descricao = $request->descricao;
    //$this->palestrante = $request->palestrante;
    $this->data_inicio = $request->data_inicio;
    $this->data_fim = $request->data_fim;
    $this->vagas = $request->vagas;
    //$this->vagas_ocupadas = $request->vagas_ocupadas;
    //$this->status = $request->status;
    //lógica para o upload de imagens.
    if(!Storage::exists('localPhotos/'))
    {
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
    $pacotes = explode(',',$request->pacotes);
    $this->associaPacotes($pacotes);

  }

  public function enrollActivity(Atividade $atividade)
  {
    $user = Auth::user();
    $minha_atividade = new UsuarioAtividade;
    $minha_atividade->usuario_id = $user->id;
    $minha_atividade->atividade_id = $this->id;

    $minha_atividade->save();
  }

  // Função para editar dados de atividades.
  public function updateActivity(UpdateAtividadeRequest $request, Atividade $atividade)
  {
    // Só modifica os dados que forem recebidos na request.
    if($request->titulo)
    {
      $this->titulo = $request->titulo;
    }
    if($request->descricao)
    {
      $this->descricao = $request->descricao;
    }
    if($request->palestrante)
    {
      $this->palestrante = $request->palestrante;
    }
    if($request->data_inicio)
    {
      $this->data_inicio = $request->data_inicio;
    }
    if($request->data_fim)
    {
      $this->data_fim = $request->data_fim;
    }
    if($request->vagas)
    {
      $this->vagas = $request->vagas;
    }
    /*if($request->vagas_ocupadas)
    {
      $this->vagas_ocupadas = $request->vagas_ocupadas;
    }*/
    /*if($request->status)
    {
      $this->status = $request->status;
    }*/
    if($request->img_path)
    {
      Storage::delete('localPhotos/'.$atividade->img_path);
      //lógica para o upload de imagens.
      if(!Storage::exists('localPhotos/'))
      {
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


      //atualiza a quais pacotes o quarto pertence.
      if($request->pacotes){

          $requestPacotes = explode(',',$request->pacotes);
          //dd($requestPacotes);
          $qnt_pacotes = $this->pacotes()->count();

          //pega todos os pacotes do pivot
          $pacotes = $this->pacotes()->select('pacote_id')->get();
          //transforma a collection em array só com os ids do pacote
          $pacotes = $pacotes->pluck('pacote_id')->toArray();

          if($qnt_pacotes < count($requestPacotes)){

              //verifica os ids que serão adicionados a tabela pivot
              $diferenca = array_diff($requestPacotes, $pacotes);
              $this->associaPacotes($diferenca);
              $this->save();
          }
          else{
              //verifica os ids que serão retirados da tabela pivot
              $diferenca = array_diff($pacotes, $requestPacotes);

              //testa se existe algum id que ainda não ta na tabela
              if(!empty($diferenca)){
                  $this->desassociaPacotes($diferenca);
                  $this->save();
              }

              // ##TESTAR -> verificar se vai causar algum conflito.
              $diferenca = array_diff($requestPacotes, $pacotes);

              if(!empty($diferenca)){
                  $this->associaPacotes($diferenca);
                  $this->save();
              }

          }
      }
    $this->save();

  }

  // Função para deletar atividades.
  public function deleteActivity(Atividade $atividade)
  {
    Storage::delete('localPhotos/' . $atividade->img_path);
    // Deleta a atividade passada na função.
    Atividade::destroy($atividade->id);
  }
}
