<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Atividade extends Model
{
  use Notifiable;

  protected $fillable = [
    'titulo', 'descricao', 'data_inicio', 'data_fim', 'vagas', 'vagas_ocupadas', 'img_path', 'status'
  ];

  // Função para criar novas atividades.
  public function createActivity(Request $request)
  {
    $this->titulo = $request->titulo;
    $this->descricao = $request->descricao;
    $this->data_inicio = $request->data_inicio;
    $this->data_fim = $request->data_fim;
    $this->vagas = $request->vagas;
    $this->vagas_ocupadas = $request->vagas_ocupadas;
    $this->status = $request->status;

    //falta fazer o tratamento para o upload de imagens

    $this->save();
  }

  // Função para editar dados de atividades.
  public function updateActivity(Request $request, Atividade $atividade)
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
    if($request->vagas_ocupadas)
    {
      $this->vagas_ocupadas = $request->vagas_ocupadas;
    }
    if($request->status){
      $this->status = $request->status;
    }
    $this->save();
  }

  // Função para deletar atividades.
  public function deleteActivity(Ativcidade $atividade)
  {
    // Deleta a atividade passada na função.
    User::destroy($atividade->id);
  }
}
