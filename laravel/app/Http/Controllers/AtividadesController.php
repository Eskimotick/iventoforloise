<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Atividade;
use App\UsuarioAtividade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreAtividadeRequest;
use App\Http\Requests\UpdateAtividadeRequest;
use App\Notifications\Atividade\UpdateAtividadePacoteNotification;

class AtividadesController extends Controller
{

    public function show($id)
    {
      $user_logado = Auth::user();
      if($user_logado->admin == 1)
      {
        $atividade = Atividade::findOrFail($id);
        return response()->success($atividade);
      }
      else
      {
        return response()->error('Você não possui a permissão necessária para ver essa atividade.');
      }
    }

    public function index()
    {
      $user_logado = Auth::user();
      if($user_logado->admin == 1)
      {
        $all_activities = Atividade::all();
        return response()->success($all_activities);
      }
      else
      {
        return response()->error('Você não possui a permissão necessária para ver essas atividades.');
      }
    }

    public function store(StoreAtividadeRequest $request)
    {
      $user_logado = Auth::user();
      if($user_logado->admin == 1)
      {
        $nova_atividade = new Atividade;
        $nova_atividade->createActivity($request);

        return response()->success($nova_atividade);
      }
      else
      {
        return response()->error('Você não possui a permissão necessária para ver essa atividade.');
      }
    }

    public function update(UpdateAtividadeRequest $request, $id)
    {

//        dd($request->pacotes);
      $user_logado = Auth::user();
      if($user_logado->admin == 1)
      {


        $atividade_alt = Atividade::findOrFail($id);
        $atividade_alt->updateActivity($request, $atividade_alt);

        return response()->success(Atividade::find($id));
      }
      else
      {
        return response()->error('Você não possui a permissão necessária para ver essa atividade.');
      }
    }

    public function delete($id)
    {
      $user_logado = Auth::user();
      if($user_logado->admin == 1)
      {
        $atividade_del = Atividade::findOrFail($id);
        $atividade_del->deleteActivity($atividade_del);
        return response()->success('Atividade Deletada com Sucesso!');
      }
      else
      {
        return response()->error('Você não possui a permissão necessária para ver essa atividade.');
      }
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

    //Temporariamente fora de uso
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