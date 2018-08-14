<?php

namespace App\Http\Controllers;

use Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class FacebookController extends Controller
{

    // Redireciona o usuário para a página de autenticação do Facebook.
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Cotém as informações do usuário do Facebook.
    public function handleFacbookCallback(FacebookService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        Auth::user($user);
        $user->token;
        return redirect()->to('/user');
    }
}
