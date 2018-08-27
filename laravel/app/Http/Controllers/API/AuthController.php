<?php

namespace App\Http\Controllers\API;

use DB;
use Auth;
use App\User;
use Carbon\Carbon;
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
  //Função de log-in.
  public function login()
  {
    /* attempt() pega o user do BD cujo campo 'email' corresponde ao email passado na request.
    Retorna true se a senha desse user no BD corresponder à senha passada na request */
    if (Auth::attempt(['email' => request('email'), 'password' => request('password')])){
      //Autentica o user encontrado e o guarda em $user.
      $user = Auth::user();
      //Cria um token para $user.
      $success['message'] = 'Log-in efetuado com sucesso, '.$user->name.'!';
      $success['token'] = $user->createToken('iVento')->accessToken;
      //Retorna o token, com status 200 (tudo ok).
      return response()->success(['success' => $success]);
    }
    else
    {
      return response()->error('Falha de autenticação', 401);
    }
  }
  //Função de logout.
  public function logout()
  {
    //Pega o token do usuário logado.
    $accessToken = Auth::user()->token();
    //Altera a coluna "revoked" para true no BD, salvando que o token foi invalidado.
    DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->update(['revoked' => true]);
    //Revoga o token armazenado.
    $accessToken->revoke();
    $success['message'] = 'Log-out efetuado com sucesso!';
    return response()->success($success);
  }

  //Função para o cadastro de novos usuários.
  public function register(UserRequest $request)
  {
    $newUser = new User;

    //Cria um novo usuário com nome, email e senha criptografada.
    $newUser->nickname = $request->nickname;
    $newUser->email = $request->email;
    $newUser->password = bcrypt($request->password);

    //$success guarda o token e o nome do usuário correspondente.
    $success['message'] = 'Usuário Cadastrado com Sucesso!';
    $success['nickname'] = $newUser->nickname;
	  $success['token'] = $newUser->createToken('iVento')->accessToken;

    $newUser->save();

    $newUser->sendConfirmEmailNotification();

    //Passa na response o token e nome do usuário, com status 200 (tudo ok).
	  return response()->success($success);
  }

  //Função para enviar o e-mail de confirmação de cadastro novamente.
  public function resendConfirmation(Request $request)
  {
    //Pega o usuário que está passando o e-mail.
    $user = User::where('email', $request->email)->first();
    //Se o e-mail for válido...
    if($user)
    {
      //Envia uma nova notificação para o e-mail passado.
      $user->sendConfirmEmailNotification();
      //Mensagem de e-mail enviado.
      $success['message'] = 'Mensagem enviada para '.$user->email.'. Confira seu e-mail!';
      return response()->success($success);
    }
    else
    {
      //Mensagem de e-mail inválido.
      $failure['message'] = 'E-mail inválido, tente novamente.';
      return response()->error($failure);
    }
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
    //Se estiver passando o código de confirmação correto.
    if($user_confirm)
      {
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
    //Senão...
    else
    {
      //retorna uma mensagem de falha.
      $failure['message'] = 'Código de confirmação incorreto. Tente novamente.';
    }
    return response()->error($failure);
  }

  /*Função chamada quando o usuário clica em "esqueci minha senha".
  Ela envia um e-mail com um código para efetuar a mudança da senha.*/
  public function forgotPassword(Request $request)
  {
    //O usuário que irá redefinir a senha é o que preencheu seu e-mail no campo.
    $user_forgot = User::where('email', $request->email)->first();
    //Se estiver passando o e-mail correto.
    if($user_forgot)
    {
      //O e-mail é enviado a este usuário.
      $user_forgot->sendPasswordNotification();
      //Mensagem dizendo que o e-mail foi enviado com sucesso.
      $success['message'] = 'Mensagem enviada para '.$user_forgot->email.'. Confira seu e-mail!';
      return response()->success($success);
    }
    //senão...
    else
    {
      //retorna uma mensagem de falha.
      $failure['message'] = 'E-mail inválido, tente novamente.';
      return response()->error($failure);
    }
  }

  //Função chamada na hora de preencher a nova senha.
  public function resetPassword(PasswordResetRequest $request)
  {
    //Pega o usuário de acordo com o código de redefinição de senha.
    $new_password_user = User::where('password_reset_code', $request->password_reset_code)->first();
    //Caso esse usuário tenha um código...
    if($new_password_user)
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
      $error = 'Erro. Token inválido, tente novamente.';
      //Return falho.
      return response()->error($error, 422);
    }
  }

  //Função para pedir a troca de e-mails.
  public function requestNewEmail(NewEmailRequest $request)
  {
    //Usuário entra com seu e-mail atual.
    $current_email = $request->current_email;
    //O usuário que deseja o e-mail novo é aquele que passou o e-mail atual.
    $user_new_email = User::where('email', $current_email)->first();
    if($user_new_email)
    {
      /*Envia uma mensagem ao e-mail antigo, informando
      a troca de e-mails e pedindo confirmação.*/
      $user_new_email->sendConfirmOldEmailNotification();
      /*O usuário então preenche qual e-mail ele gostaria de passar a usar.
      Esse e-mail ainda não está ativado, só é guardado no BD enquanto não há confirmação.*/
      $user_new_email->new_email = $request->new_email;
      //Salva a data e horário em que o código de confirmação passado no email foi gerado.
      $user_new_email->email_code_date = Carbon::now();
      /*Envia uma mensagem de notificação ao e-mail que o usuário gostaria de usar como novo,
      avisando da requisição e pedindo confirmação.*/
      $user_new_email->sendConfirmNewEmailNotification();
      //O novo e-mail é salvo no BD, em uma coluna diferente do e-mail atual.
      $user_new_email->save();
      //Response de sucesso.
      return response()->success($user_new_email);
    }
    else
    {
      //retorna uma mensagem de falha.
      $failure['message'] = 'E-mail inválido, tente novamente.';
      return response()->error($failure);
    }
  }

  //Função para confirmar que o usuário validou a troca tanto no e-mail novo quanto no antigo.
  public function newEmailConfirmed(Request $request)
  {
    //O usuário que quer mudar de e-mail é aquele que tem os códigos de confirmação de ambos os e-mails.
    $user_change_email = User::where('new_email_code', $request->new_email_code)->where('old_email_code', $request->old_email_code)->first();
    if($user_change_email)
    {
      //Se o pedido de confirmação de email tiver sido feito há menos de 24 horas...
      if ($user_change_email->email_code_date > Carbon::now()->subDay())
      {
        //Muda o e-mail antigo para o novo.
        $user_change_email->email = $user_change_email->new_email;
        //Muda o e-mail novo para null.
        $user_change_email->new_email = null;
        //Salva as alterações
        $user_change_email->save();
        $success['message'] = $user_change_email->nickname.' seu e-mail foi alterado com sucesso!';
        return response()->success($success);
      }
      else
      {
        //Muda o e-mail novo para null.
        $user_change_email->new_email = null;
        //Salva as alterações
        $user_change_email->save();
        $failure['message'] = $user_change_email->nickname.' seu token de alteração expirou, confirme seu e-mail novamente.';
        return response()->error($failure);
      }
    }
    else
    {
      //retorna uma mensagem de falha.
      $failure['message'] = 'Códigos inválidos, tente novamente.';
      return response()->error($failure);
    }
  }
}
