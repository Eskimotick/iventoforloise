<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Atividade;
use App\PacoteAtividade;
use App\UsuarioAtividade;
use App\Models\Admin\Lote;
use App\Models\Admin\Pacote;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource as UserResource;

class UserController extends Controller
{

    //Recebe um usuário e lista esse usuário.
    public function show($id)
    {
      // Acha o usuário passado na função
      $user = User::findOrFail($id);
      return response()->success(new UserResource($user));
    }

    //Função para listar todos os usuários cadastrados.
    public function index()
    {
      return UserResource::collection(User::all());
    }

    // Função para administradores inserirem novos usuários manualmente.
    public function store(UserRequest $request)
    {
      // Pega o usuário logado.
      $user = Auth::user();
      // Se for um admin pode inserir novos usuários.
      if($user->admin == 1)
      {
        $novoUser = new User;
        $novoUser->createUsers($request);
        return response()->success(new UserResource($novoUser));
      }
      // Se não for, mensagem de erro.
      else
      {
        return response()->error('ERRO. Operação não autorizada.', 403);
      }
    }

    /* Usuários podem modificar seus dados e administradores
    podem modificar os dados de qualquer um. */
    public function update(UpdateUserRequest $request, $id)
    {
      // Pega o usuário logado.
      $user_log = Auth::user();
      // Acha o usuário passado na função
      $user = User::findOrFail($id);
      // Se for admin, pode modificar os dados de qualquer usuário.
      if($user_log->admin == 1)
      {
        $user->updateUsers($request, $user);
        return response()->success(new UserResource($user));
      }
      // Se não for, pode modificar apenas os próprios.
      else{
        $user_log->updateUsers($request, $user_log);
        return response()->success(new UserResource($user_log));
      }
    }

    /* Usuários podem deletar suas contas e administradores
    podem deletar qualquer usuário. */
    public function delete($id)
    {
      // Pega o usuário logado.
      $user_log = Auth::user();
      // Acha o usuário passado na função
      $user = User::findOrFail($id);
      // Se for admin, pode deletar qualquer usuário.
      if($user_log->admin == 1)
      {
        $user->deleteUsers($user);
        return response()->success('Usuário Deletado com Sucesso!');
      }
      // Se não for, pode deletar apenas a si mesmo.
      else
      {
        $user_log->deleteUsers($user_log);
        return response()->success('Usuário Deletado com Sucesso!');
      }
    }

    //Função para por um lote no user.
    public function lote(Request $request)
    {
      //Pega o usuário logado.
      $user_log = Auth::user();
      //Passa seu lote ID pela request.
      $user_log->lote_id = $request->lote_id;
      //salva no BD.
      $user_log->save();
    }

    //Função para um usuário ver as atividades de seu pacote.
    public function myPackageActivities()
    {
      //Pega o usuário logado.
      $user = Auth::user();
      //Pega as atividades dele.
      $myActivities = UsuarioAtividade::where('usuario_id', $user->id)->get();
      //Guarda elas num array.
      $myPackageActivities = [];
      //Para cada elemento do array.
      foreach ($myActivities as $atividade)
      {
        //Variável auxiliar 1, para pegar uma atividade do pacote temporariamente.
        $aux = PacoteAtividade::where('atividade_id', $atividade->atividade_id)->select('atividade_id')->first();
        //Variável auxiliar 2, para pegar e colocar essa atividade no array de "Atividades do meu pacote".
        $aux2 = Atividade::where('id', $aux->atividade_id)->first();
        //Coloca essa atividade no array.
        array_push($myPackageActivities, $aux2);
      }
      //Response de sucesso.
      return response()->success($myPackageActivities);
    }

    //Função para que os usuários se inscrevam em atividades de seus pacotes.
    public function inscreveAtividadePacote($id_ativ)
    {
      //Pega o user logado.
      $user = Auth::user();
      //Pega o pacote da atividade que o user quer se inscrever.
      $atividade_pacote = PacoteAtividade::findOrFail($id_ativ);
      //Pega o lote desse usuário.
      $lote_usuario = Lote::findOrFail($user->lote_id);
      //Pega o pacote do usuário pelo lote.
      $pacote_usuario = Pacote::findOrFail($lote_usuario->pacote_id);

      //Se o pacote da atividade for o mesmo do usuário...
      if($pacote_usuario->id == $atividade_pacote->pacote_id)
      {
        //Cria uma nova inscrição.
        $inscricao = new UsuarioAtividade;
        //Inscreve o usuário.
        $inscricao->usuario_id = $user->id;
        //E a atividade dele
        $inscricao->atividade_id = $atividade_pacote->atividade_id;
        $inscricao->status = 'ok';
        //save() pra guardar no BD;
        $inscricao->save();
        //Response de bem-sucedido.
        return response()->success('Usuário Inscrito com Sucesso!');
      }
      //senão...
      else
      {
        //Response de erro.
        return response()->error('Essa atividade não faz parte do seu pacote! Por favor selecione outra.');
      }
    }

    //Função para remover o usuário de uma atividade inscrtita.
    public function desinscreveAtividade($id_ativ)
    {
      //Pega o usuário logado.
      $user_logado = Auth::user();
      //Pega a atividade passada na função.
      $activity = Atividade::findOrFail($id_ativ);
      //Pega a inscrição do usuário na atividade a partir do ID
      $userActivity = UsuarioAtividade::where('usuario_id', $user_logado->id)->where('atividade_id', $activity->id)->first();
      //Caso haja inscrição do usuário em alguma inscrição:
      if(!$userActivity == null)
      {
        //Remove a inscrição do usuário da atividade passada na função.
        UsuarioAtividade::destroy($userActivity->id);
        //Return de success.
        return response()->success('Você foi removido da atividade com sucesso!');
      }
      //Caso não haja...
      else
      {
        //Return de erro.
        return response()->error('Você não pode ser removido de uma atividade em que não está inscrito! Por favor selecione outra atividade.');
      }
    }
      
    public function enterQuarto($quartoId){
      $user = Auth::user();
      
      $resposta = $user->alocaUserQuarto($quartoId);

      if(gettype($resposta) == 'string'){
        return response()->error($resposta, 400);
      }

      $resposta = implode('/', $resposta);
      return response()->success('User alocado com sucesso! user/quarto => '.$resposta);

    }

    public function exitQuarto(){

      $user = Auth::user();
      $resposta = $user->desalocaUserQuarto();

      if(gettype($resposta) == 'string'){
          return response()->error($resposta, 400);
      }

      $resposta = implode('/', $resposta);
      return response()->success('User desalocado com sucesso! user/quarto => '.$resposta);
    }

    //ainda tem que testar estas duas funções abaixo
    public function showPacoteQuartos(){
      
      $user = Auth::user();

      $quartos = $user->getQuartos();

      if($quartos->count() == 0){
        return response()->error('Seu pacote ainda não possui quartos. 
        Entre em contato com os organizadores', 400);
      }

      return response()->success($quartos);

    }

    public function showQuarto($id){
      $user = Auth::user();

      $quarto = $user->showQuarto($id);

      if(gettype($quarto) == 'string'){
        return response()->error($quarto, 400);
      }

      return response()->success($quarto);

    }
}
