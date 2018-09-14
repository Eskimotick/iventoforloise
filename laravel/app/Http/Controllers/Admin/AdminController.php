<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
Use App\Atividade;
use App\UsuarioAtividade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    public function inscreveUser($id_user, $id_ativ)
    {
        // Pega o usuário logado.
        $user_logado = Auth::user();
        // Se for um admin pode inserir novos usuários.
        if($user_logado->admin == 'true')
        {
            dd($user_logado);
            $user = User::findOrFail($id_user);
            $atividade = Atividade::findOrFail($id_ativ);
            $inscricao = new UsuarioAtividade;
            $inscricao->usuario_id = $user->id;
            $inscricao->atividade_id = $atividade->id;
            $inscricao->status = 'ok';

            $inscricao->save();
            return response()->success('Usuário Inscrito com Sucesso!');
        }
        // Se não for, mensagem de erro.
        else
        {
            return response()->error('ERRO. Operação não autorizada.', 403);
        }
    }

    public function desinscreveUser(UsuarioAtividade $userActivity)
    {
        // Pega o usuário logado.
        $user_logado = Auth::user();
        dd($user_logado);
        // Se for um admin pode inserir novos usuários.
        if($user_logado->admin == 'true')
        {
            UsuarioAtividade::destroy($user->id);

            return response()->success('Usuário Inscrito com Sucesso!');
        }
        // Se não for, mensagem de erro.
        else
        {
            return response()->error('ERRO. Operação não autorizada.', 403);
        }
    }
}
