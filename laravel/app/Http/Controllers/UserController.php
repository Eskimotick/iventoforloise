<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource as UserResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{

    //Recebe um usuário e lista esse usuário.
    public function show($id)
    {
      // Acha o usuário passado na função
      $user = User::findOrFail($id);
      return new UserResource($user);
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
      if($user->admin == 'true')
      {
        $novoUser = new User;
        $novoUser->createUsers($request);
        return new UserResource($novoUser);
      }
      // Se não for, mensagem de erro.
      else
      {
        return response()->json(['message' => 'ERRO. Operação não autorizada.'], 403);
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
      if($user_log->admin == 'true')
      {
        $user->updateUsers($request, $user);
        return new UserResource($user);
      }
      // Se não for, pode modificar apenas os próprios.
      else{
        $user_log->updateUsers($request, $user_log);
        return new UserResource($user_log);
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
      if($user_log->admin == 'true')
      {
        $user->deleteUsers($user);
        return response()->json('Usuário Deletado com Sucesso!');
      }
      // Se não for, pode deletar apenas a si mesmo.
      else
      {
        $user_log->deleteUsers($user_log);
        return response()->json('Usuário Deletado com Sucesso!');
      }
    }
}
