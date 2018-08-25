<?php

namespace App\Http\Controllers\API;

use DB;
use Auth;
use App\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewEmailRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\confirmRegisterRequest;
use App\Notifications\Auth\Email\ConfirmEmailNotification;
use App\Notifications\Auth\Email\EmailConfirmedNotification;
use App\Notifications\Auth\Password\PasswordResetNotification;
use App\Notifications\Auth\Password\PasswordChangedNotification;

class AuthController extends Controller
{
  public $successStatus = 200;

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
      return response()->success(['success' => $success], $this->successStatus);
    }
    else
    {
      return response()->error(['error' => 'Falha de autenticação'], 401);
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
    return response()->success(['success' => $success], 204);
  }

  // Função para o cadastro de novos usuários.
  public function register(UserRequest $request)
  {
    $newUser = new User;

    // Cria um novo usuário com nome, email e senha criptografada.
    $newUser->nickname = $request->nickname;
    $newUser->email = $request->email;
    $newUser->password = bcrypt($request->password);

    // $success guarda o token e o nome do usuário correspondente.
    $success['message'] = 'Usuário Cadastrado com Sucesso!';
    $success['nickname'] = $newUser->nickname;
	  $success['token'] = $newUser->createToken('iVento')->accessToken;

    $newUser->save();

    $newUser->sendConfirmEmailNotification();

    // Passa na response o token e nome do usuário, com status 200 (tudo ok).
	  return response()->success(['success' => $success]);
  }

  public function fetchUser(ConfirmRegisterRequest $request)
  {
    //recebe o usuário do código de confirmação
    $user_confirm = User::where('confirmation_code', $request->confirmation_code)->first();

    return response()->success(['User' => $user_confirm]);
  }

  public function confirmRegister(ConfirmRegisterRequest $request)
  {
    //pega o usuário correspondente ao códifgo de confirmação enviado por e-mail.
    $user_confirm = User::where('confirmation_code', $request->confirmation_code)->first();

    //preenche o CPF, nome e confirma o cadastro do usuário
    $user_confirm->cpf = $request->cpf;
    $user_confirm->nome_completo = $request->nome_completo;
    $user_confirm->confirmed = 1;

    //mensagem de cadastro concluído com sucesso.
    $success['message'] = 'Cadastro concluído com sucesso '.$user_confirm->nome_completo.'!';

    $user_confirm->save();

    //envia um e-mail confirmando que o cadastro foi concluído.
    $user_confirm->sendEmailConfirmedNotification();

    return response()->success($success);
  }

  /*Função chamada quando o usuário clica em "esqueci minha senha".
  Ela envia um e-mail com um código para efetuar a mudança da senha.*/
  public function forgotPassword(Request $request)
  {
    //O usuário que irá redefinir a senha é o que preencheu seu e-mail no campo.
    $user_forgot = User::where('email', $request->email)->first();
    //O e-mail é enviado a este usuário.
    $user_forgot->sendPasswordNotification();
    //Retorna uma resource com os dados do usuário, incluindo o código para alterar a senha.
    return new UserResource($user_forgot);
  }

  //Função chamada na hora de preencher a nova senha.
  public function resetPassword(PasswordResetRequest $request)
  {
    //Pega o usuário de acordo com o código de redefinição de senha.
    $new_password_user = User::where('password_reset_code', $request->password_reset_code)->first();
    //Caso esse usuário tenha um código...
    if($new_password_user->password_reset_code)
    {
      //Usuário preenche a nova senha.
      $new_password_user->password = ($request->password);
      //A nova senha é guardada (com confirmação).
      $new_password_user->save();
      //Envia e-mail confirmando a troca de senha.
      $new_password_user->sendPasswordChangedNotification();
      //Mensagem de sucesso.
      $success['message'] = $new_password_user->nickname.' sua senha foi alterada com sucesso!';
      //Return bem-sucedido.
      return response()->success($success);
    }
    //Senão...
    else
    {
      //Mensagem de erro.
      $error = 'Erro. Token não encontrado.';
      //Return falho.
      return response()->error($error, 422);
    }
  }

  public function confirmNewEmail(NewEmailRequest $request)
  {
    $current_email = $request->current_email;

    $user_new_email = User::where('email', $current_email)->first();
    $user_new_email->sendConfirmOldEmailNotification();

    $user_new_email->new_email = $request->new_email;
    $user_new_email->sendConfirmNewEmailNotification();

    $user_new_email->save();

    return response()->success($user_new_email);
  }

  public function newEmailConfirmed(Request $request)
  {
    $user_change_email = User::where('new_email_code', $request->new_email_code)->where('old_email_code', $request->old_email_code)->first();

    if($request->new_email_code && $request->old_email_code)
    {
      $user_change_email->email = $user_change_email->new_email;
      $user_change_email->new_email = null;
      $user_change_email->save();
      return response()->success($user_change_email);
    }
  }

}
