<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Admin\Config;
use App\Http\Requests\Admin\UpdateConfigRequest as UpdateRequest;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function showDataEvento()
    {
      // Pega o usuário logado.
      $user = Auth::user();
      // Se for um admin pode inserir novos usuários.
      if($user->admin == 1)
      {
        $config = Config::find(1);
        $data_evento['data_inicio'] = $config->inicio_evento;
        $data_evento['data_fim'] = $config->fim_evento;
        return response()->success($data_evento);
      }
      else
      {
        return response()->error('ERRO. Operação não autorizada.', 403);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateInscricoes(UpdateRequest $request)
    {
        $config = Config::find(1);
                
        $resposta = $config->updateInscricoes($request);
        if(gettype($resposta) == 'string'){
            return response()->error($resposta, 400);    
        }
        
        return response()->success($config);            
        
    }

    public function updateEvento(UpdateRequest $request)
    {
        $config = Config::find(1);
        
        $resposta = $config->updateEvento($request);
        if(gettype($resposta) == 'string'){
            return response()->error($resposta, 400);    
        }
        
        return response()->success($config);            
        
    }

    public function abreInscricoes(){
        $config = Config::find(1);
        $resposta = $config->adminChangeStatus(0);
        if(gettype($resposta) == 'string'){
            return response()->error($resposta, 400);
        }
        return response()->success('Evento aberto com sucesso!');
    }

    public function fechaInscricoes(){
        $config = Config::find(1);
        $resposta = $config->adminChangeStatus(2);
        if(gettype($resposta) == 'string'){
            return response()->error($resposta, 400);
        }
        return response()->success('Evento fechado com sucesso!');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
