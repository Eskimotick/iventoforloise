<?php

namespace App\Http\Controllers;

use App\Atividade;
use App\Models\Admin\Pacote;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $nova_atividade = new Atividade;
        $nova_atividade->createActivity($request);
        return response()->success($nova_atividade);
    }

    public function update(Request $request, $id)
    {
        $atividade_alt = Atividade::findOrFail($id);
        $atividade_alt->updateActivity($request, $atividade_alt);
        return response()->success($atividade_alt);
    }

    public function delete($id)
    {
        $atividade_del = Atividade::findOrFail($id);
        $atividade_del->deleteActivity($atividade_del);
        return response()->success('Atividade Deletada com Sucesso!');
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
      foreach ($usuariosPacote as $user)
      {
        $user->notify(new NovaAtividadePacoteNotification());
      }
    }
}
