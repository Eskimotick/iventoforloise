<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsuarioController extends Controller
{

    public function create(Request $request)
    {
      $dados = $request->dados;
      $validator = Validator::make($dados, [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255',
        'password' => 'required|min:6|confirmed'
      ]);

      $user = User::create([
        'name' => $dados->name,
        'email' => $dados->email,
        'password' => bcrypt($dados->password),
      ]);

      return response()->success([
        'mensagem' => 'Usuário criado com sucesso.',
        'user' => $user
      ]);
    }

    /**
     * Edita usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $dados = $request->dados;
      $validator = Validator::make($dados, [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255',
      ]);

      if ($validator->fails()) {
        return response()->error('Erro de validação.', 400, $validator->errors());
      }

      $user = User::find($id);
      $user->fill($dados);
      $user->save();

      return response()->success([
        'message' => 'Usuário editado com sucesso.',
        'user' => $user
      ]);

    }
    
}
