<?php

namespace App\Http\Middleware;

use Closure;
use Auth;


class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user){
            //Checa se existe um usuário logado
            return response()->error('É necessário estar logado', 401);
        } else if(!$user->admin){
            //Checa se o usuário é admin
            return response()->error('Você não tem permissão para realizar essa ação', 403);
        }


        return $next($request);
    }
}
