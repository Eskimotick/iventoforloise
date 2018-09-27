<?php

namespace App\Http\Controllers;

use App\User;
use App\Atividade;
use App\PacoteAtividade;
use App\UsuarioAtividade;
use App\Models\Admin\Lote;
use App\Models\Admin\Pacote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreAtividadeRequest;
use App\Http\Requests\UpdateAtividadeRequest;
use App\Notifications\Atividade\NovaAtividadePacoteNotification;
use App\Notifications\Atividade\UpdateAtividadePacoteNotification;

class AtividadesController extends Controller
{

    public function show($id)
    {
        $atividade = Atividade::findOrFail($id);
        return response()->success($atividade);
    }

    public function index()
    {
        $all_activities = Atividade::all();
        return response()->success($all_activities);
    }

    public function store(StoreAtividadeRequest $request)
    {
        $nova_atividade = new Atividade;
        $nova_atividade->createActivity($request);
        return response()->success($nova_atividade);
    }

    public function update(UpdateAtividadeRequest $request, $id)
    {
        $atividade_alt = Atividade::findOrFail($id);
        $atividade_alt->updateActivity($request, $atividade_alt);
        $this->updateAtividadePacote($atividade_alt->id);
        return response()->success($atividade_alt);
    }

    public function delete($id)
    {
        $atividade_del = Atividade::findOrFail($id);
        $atividade_del->deleteActivity($atividade_del);
        return response()->success('Atividade Deletada com Sucesso!');
    }

    public function exibirFoto($id)
    {
      $atividade = Atividade::findOrFail($id);
      $filePath = storage_path('app/localPhotos/'.$atividade->img_path);
      return response()->download($filePath, $atividade->img_path);
    }

    public function downloadFoto($id)
    {
      $atividade = Atividade::findOrFail($id);
      $filePath = storage_path('app/localPhotos/'.$atividade->img_path);
      return response()->file($filePath);
    }

    public function insereAtividadePacote($id_ativ, $id_pacote)
    {
      $atividadePacote = new PacoteAtividade;
      $pacote = Pacote::findOrFail($id_pacote);
      $atividade = Atividade::findOrFail($id_ativ);
      $lote = Lote::findOrFail($pacote->lote_atual);
      $atividadePacote->pacote_id = $pacote->id;
      $atividadePacote->atividade_id = $atividade->id;
      $atividadePacote->save();
      $usuariosPacote = User::where('lote_id', $lote->id)->get();
      foreach($usuariosPacote as $user)
      {
        $user->notify(new NovaAtividadePacoteNotification());
      }
    }

    public function updateAtividadePacote($id_ativ)
    {
      $userAtividade = UsuarioAtividade::where('atividade_id', $id_ativ)->get();
      foreach($userAtividade as $user)
      {
        $userInscrito = User::findOrFail($user->usuario_id);
        $userInscrito->notify(new UpdateAtividadePacoteNotification());
      }
    }
}