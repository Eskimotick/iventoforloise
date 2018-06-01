<?php

namespace App\Http\Controllers;

use App\User;
use JWTAuth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Excepptions\JWTException;

class AuthController extends Controller
{

  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['login', 'register']]);
  }

  /**
  * Retorna a token (ou erro) pra tentativa de login
  *
  * @param  Request $request Illuminate\Http\Request
  * @return \Illuminate\Http\JsonResponse
  */
  public function login(Request $request)
  {
    $dados = $request->dados;
    $validator = Validator::make($request->dados, [
      'email' => 'required',
      'password' => 'required'
    ]);

    if ($validator->fails()) {
      return response()->error('Dados de login incompletos ou inválidos', 400, $validator->errors());
    }

    // se não houver usuário com aquele e-mail
    if ( count(User::where('email', $dados->email)->get()) ) {
      $credentials = array(
        'email' => $dados->email,
        'password' => $dados->password
      );
    }
    else {
      return response()->error('Credenciais não cadastradas no sistema.', 404);
    }

    // caso usuário marque "lembrar de mim" no login, aumentar duracao da token
    if ($dados->remember){
      JWTAuth::factory()->setTTL(525600);
    }
    else {
      JWTAuth::factory()->setTTL(600);
    }

    try {
      if (! $token = JWTAuth::attempt($credentials)){
        return response()->error('Credenciais não autorizadas.', 401);

      }
    } catch (JWTException $e) {
      return response()->error('Não foi possível criar token, tente novamente mais tarde.', 500);
    }

    return response()->success([
      'token' => $token
    ]);
  }

  /**
  * Desloga o usuário
  *
  * @return \Illuminate\Http\JsonResponse
  */
  public function logout()
  {
    auth()->logout();

    return response()->success([
      'message' => 'Logout realizado com sucesso.'
    ]);
  }

  /**
  * Retorna o usuário de uma token
  *
  * @return \Illuminate\Http\JsonResponse
  */
  public function me()
  {
    return response()->success(JWTAuth::user());
  }

  /**
  * Aumenta a duração da token
  *
  * @param  Request $request Illuminate\Http\Request
  * @return [type]           [description]
  */
  public function refresh(Request $request)
  {
    return response()->success([
      'token' => auth()->refresh()
    ]);
  }

}
