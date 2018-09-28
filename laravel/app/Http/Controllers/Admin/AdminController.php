<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
Use App\Atividade;
use App\PacoteAtividade;
use App\UsuarioAtividade;
use App\Models\Admin\Lote;
use App\Models\Admin\Pacote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\Atividade\NovaAtividadePacoteNotification;
use App\Notifications\Atividade\UpdateAtividadePacoteNotification;

class AdminController extends Controller
{
		//Função para admins inscreverem usuários.
    public function inscreveUser($id_user, $id_ativ)
    {
      //Pega o usuário logado.
      $user_logado = Auth::user();
      //Se for um admin pode inserir novos usuários.
      if($user_logado->admin == 1)
      {
				//Pega o usuário passado na função
				$user = User::findOrFail($id_user);
				//Pega a atividade passada na função
				$atividade = Atividade::findOrFail($id_ativ);
				//Pega o pacote da atividade do user a ser inscrito.
				$atividade_pacote = PacoteAtividade::where('atividade_id', $atividade->id)->first();
				//Pega o lote desse usuário.
				$lote_usuario = Lote::findOrFail($user->lote_id);
				//Pega o pacote do usuário pelo lote.
				$pacote_usuario = Pacote::findOrFail($lote_usuario->pacote_id);
				//Variável para conferir se há registros repetidos no BD.
				$checa_repetido = UsuarioAtividade::where('usuario_id', $user->id)->where('atividade_id', $atividade->id)->first();
				//Se o número de vagas ocupadas for menor do que o de vagas totais, o usuário não pode ser inscrito.
				if($atividade->vagas_ocupadas < $atividade->vagas)
				{
					//Se o usuário já está inscrito na atividade ele não pode ser inscrito de novo.
	       	if(!$checa_repetido)
          {
						//Se o pacote da atividade não for o mesmo do usuário ele não pode ser inscrito.
						if($pacote_usuario->id == $atividade_pacote->pacote_id)
						{
							//Novo registro de "inscrição" no BD.
							$inscricao = new UsuarioAtividade;
							//Põe o id do usuário na inscrição. 
							$inscricao->usuario_id = $user->id;
							//Põe o id d aatividade na inscrição do usuário. 
       	      $inscricao->atividade_id = $atividade->id;

							//Salva o registro da inscrição no BD.
							$inscricao->save();
						
							//Preenche uma vaga da atividade.
							$atividade->vagas_ocupadas++;
							if($atividade->vagas_ocupadas == $atividade->vagas)
							{
								//Muda o status da atividade para "vagas esgotadas".
								$atividade->status = "Vagas Esgotadas!";
							}
							//Salva essa modificação do número de vagas no BD.
							$atividade->save();

							//Response bem-sucedido.
							return response()->success('Usuário Inscrito com Sucesso!');
						}
						//Se o pacote da atividade não for o mesmo do usuário ele não pode ser inscrito.
 	        	else
   	      	{
							//Response de erro caso a atividade não esteja no pacote do usuário.
     	        return response()->error('Essa atividade não faz parte do pacote deste usuário. Por favor selecione outra.');
						}
					}
					//Se o usuário já está inscrito na atividade ele não pode ser inscrito de novo.
					else
       		{
						//response de erro caso o usuário já esteja inscrito na atividade.
         		return response()->error('Este usuário já está inscrito na atividade.');
       		}
				}
				//Se o número de vagas ocupadas for igual ao de vagas totais, o usuário não pode ser inscrito.
				else
				{
					//Response de erro caso não hajam mais vagas na atividade.
					return response()->error('Não foi possível concluir a inscrição pois as vagas estão esgotadas.');
				}
			}
    	//Se não for um admin, não pode inserir novos usuários.
 			else
     	{
				//Response de erro caso não seja um admin.
     		return response()->error('ERRO. Operação não autorizada.', 403);
			}
		}
 
		//Função para admins removerem usuários de atividades.
    public function desinscreveUser($id_user, $id_ativ)
    {
      //Pega o usuário logado.
      $user_logado = Auth::user();
      //Pega o usuário passado na função.
      $user = User::findOrFail($id_user);
      //Pega a atividade passada na função.
      $activity = Atividade::findOrFail($id_ativ);
      //pega a inscrição a partir do ID.
      $userActivity = UsuarioAtividade::where('usuario_id', $user->id)->where('atividade_id', $activity->id)->first();
			//Se o usuário estiver inscrito na atividade.
			if($userActivity)
      {
        //Se for um admin pode inserir novos usuários.
        if($user_logado->admin == 1)
        {
					//Remove o usuário da atividade.
					UsuarioAtividade::destroy($userActivity->id);
					if($activity->vagas_ocupadas <= $activity->vagas)
					{
						//Muda o status da atividade para "vagas esgotadas".
						$activity->status = "Vagas Abertas.";
					}
					//Desocupa uma vaga da atividade.
					$activity->vagas_ocupadas--;
					//salva a alteração no número de vagas.
					$activity->save();
					//Response bem-sucedido.
          return response()->success('Usuário removido da atividade com sucesso!');
       	 }
        // Se não for um admin, mensagem de erro.
        else
        {
          return response()->error('ERRO. Operação não autorizada.', 403);
        }
			}
			//Se o usuário não estiver inscrito na atividade. 
      else
      {
				//Response de erro caso o usuário não esteja na atividade.
      	return response()->error('Este usuário não está inscrito na atividade.');
      }
		}
				
		public function insereAtividadePacote($id_ativ, $id_pacote)
    {
			//Pega o usuário logado.
			$user_logado = Auth::user();					

      $atividadePacote = new PacoteAtividade;
      $pacote = Pacote::findOrFail($id_pacote);
      $atividade = Atividade::findOrFail($id_ativ);
      $lote = Lote::findOrFail($pacote->lote_atual);
			$checa_repetido = PacoteAtividade::where('pacote_id', $pacote->id)->where('atividade_id', $atividade->id)->first();
			if($user_logado->admin == 1)
      {
	      if(!$checa_repetido)
  	    {
    		  $atividadePacote->pacote_id = $pacote->id;
      	  $atividadePacote->atividade_id = $atividade->id;
          $atividadePacote->save();
        	$usuariosPacote = User::where('lote_id', $lote->id)->get();
         	foreach($usuariosPacote as $user)
          {
            $user->notify(new NovaAtividadePacoteNotification());
 	        }
   	      return response()->success('Atividade inserida no pacote com Sucesso!');
     	  }
       	else
        {
          return response()->error('Esta atividade já faz parte do pacote.');
				}
			}
			else
      {
        return response()->error('ERRO. Operação não autorizada.', 403);
      }
   	}
}
