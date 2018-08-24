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
        if($resposta){
            return response()->error($resposta, 400);    
        }
        
        return response()->success($config);            
        
    }

    public function updateEvento(UpdateRequest $request)
    {
        $config = Config::find(1);
        
        $resposta = $config->updateEvento($request);
        if($resposta){
            return response()->error($resposta, 400);    
        }
        
        return response()->success($config);            
        
    }

    public function abreInscricoes(){
        $config = Config::find(1);
        $config->adminChangeStatus(0);

        return response()->success('Evento aberto com sucesso!');
    }

    public function fechaInscricoes(){
        $config = Config::find(1);
        $config->adminChangeStatus(2);

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
