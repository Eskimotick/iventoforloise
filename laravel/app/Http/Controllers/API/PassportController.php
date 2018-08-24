<?php

namespace App\Http\Controllers\API;

use DB;
use Auth;
use App\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;
use App\Http\Requests\confirmRegisterRequest;
use App\Notifications\Auth\ConfirmEmailNotification;

class PassportController extends Controller
{
  public $successStatus = 200;

  // Função para o cadastro de novos usuários.
  public function register(UserRequest $request)
  {
    $newUser = new User;

    // Cria um novo usuário com nome, email e senha criptografada.
    $newUser->nickname = $request->nickname;
    $newUser->email = $request->email;
    $newUser->password = bcrypt($request->password);

    // $success guarda o token e o nome do usuário correspondente.
    $success['message'] = 'Usuário Cadastrado com Sucesso, '.$newUser->name.'!';
    $success['nickname'] = $newUser->nickname;
	  $success['token'] = $newUser->createToken('iVento')->accessToken;

    $newUser->save();

    $newUser->sendConfirmNotification();


    // Passa na response o token e nome do usuário, com status 200 (tudo ok).
	  return response()->json(['success' => $success], $this->successStatus);
  }


  public function fetchUser(ConfirmRegisterRequest $request)
  {
    //recebe o usuário do código de confirmação
    $user_confirm = User::where('confirmation_code', $request->confirmation_code)->first();

    return response()->json(['User' => $user_confirm]); 
  }

  public function confirmRegister(ConfirmRegisterRequest $request)
  {
    $user_confirm = User::where('confirmation_code', $request->confirmation_code)->first();

    //preenche o CPF, nome e confirma o cadastro do usuário
    $user_confirm->cpf = $request->cpf;
    $user_confirm->nome_completo = $request->nome_completo;
    $user_confirm->confirmed = 1; 

    $success['message'] = 'Cadastro concluído com sucesso '.$user_confirm->nome_completo.'!';

    $user_confirm->save();
    
    return response()->json(['success' => $success], $this->successStatus);
  }

  // Função de log-in.
  public function login()
  {
    /* attempt() pega o user do BD cujo campo 'email' corresponde ao email passado na request.
    Retorna true se a senha desse user no BD corresponder à senha passada na request */
    if (Auth::attempt(['email' => request('email'), 'password' => request('password')])){
      // Autentica o user encontrado e o guarda em $user.
      $user = Auth::user();
      // Cria um token para $user.
      $success['message'] = 'Log-in efetuado com sucesso, '.$user->name.'!';
      $success['token'] = $user->createToken('iVento')->accessToken;
      // Retorna o token, com status 200 (tudo ok).
      return response()->json(['success' => $success], $this->successStatus);
    }
    else
    {
      return response()->json(['error' => 'Falha de autenticação'], 401);
    }
  }
  // Função de logout.
  public function logout()
  {
    // Pega o token do usuário logado.
    $accessToken = Auth::user()->token();
    // Altera a coluna "revoked" para true no BD, salvando que o token foi invalidado.
    DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->update(['revoked' => true]);
    // Revoga o token armazenado.
    $accessToken->revoke();
    $success['message'] = 'Log-out efetuado com sucesso!';
    return response()->json(['success' => $success], 204);
  }

  // public function sendEmail(User $user)
  // {
  //   sendConfirmNotification();
  //   return response()->success($user);
  // }

}
