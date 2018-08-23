<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Admin\Pacote;
use App\Http\Requests\Admin\StorePacoteRequest as StoreRequest;
use App\Http\Requests\Admin\UpdatePacoteRequest as UpdateRequest;




class PacoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pacotes = Pacote::all();
        return response()->success($pacotes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePacote(StoreRequest $request)
    {
        $novoPacote = new Pacote;
        $novoPacote->createPacote($request);
        
        return response()->success($novoPacote);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pacote = Pacote::find($id);

        if($pacote){
            return response()->success($pacote);
        }
        else{
            return response()->error('Pacote não encontrado, verifique se o pacote existe.', 400);
        }

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePacote(UpdateRequest $request, $id)
    {
        $pacote = Pacote::find($id);

        if($pacote){
            $pacote->updatePacote($request);
            return response()->success($pacote);
        }
        else{
            return response()->error('Pacote não encontrado, verifique se o pacote existe.', 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPacote($id)
    {
        $destroyPacote = Pacote::find($id);

        if($destroyPacote){
            $destroyPacote->delete();
            return response()->success('pacote deletado com sucesso!');
        }
        else{
            return response()->error('Pacote não encontrado, verifique se o pacote existe.', 400);
        }
    }
}
