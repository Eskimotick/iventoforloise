<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Hospedagem;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHospedagemRequest as StoreRequest;
use App\Http\Requests\Admin\UpdateHospedagemRequest as UpdateRequest;
use App\Http\Resources\Admin\HospedagemResource;
use App\Http\Resources\Admin\QuartoResource;


class HospedagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hospedagens = Hospedagem::all();
        return response()->success(HospedagemResource::collection($hospedagens));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeHospedagem(StoreRequest $request)
    {
        $novaHospedagem = new Hospedagem;
        $novaHospedagem->createHospedagem($request);

        return response()->success(new HospedagemResource($novaHospedagem));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showHospedagem($id)
    {
        $hospedagem = Hospedagem::find($id);

        if($hospedagem){
            return response()->success(new HospedagemResource($hospedagem));
        }
        else{
            return response()->error('Hospedagem não encontrada, verifique se a mesma existe.', 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateHospedagem(UpdateRequest $request, $id)
    {
        $hospedagem = Hospedagem::find($id);

        if($hospedagem){
            $resposta = $hospedagem->updateHospedagem($request);

            if(gettype($resposta) == 'string'){
                return response()->error($resposta, 400);
            }

            return response()->success(new HospedagemResource($hospedagem));

        }
        else{
            return response()->error('Hospedagem não encontrada, verifique se a mesma existe.', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyHospedagem($id)
    {
        $hospedagem = Hospedagem::find($id);

        if($hospedagem){
            $hospedagem->delete();
            return response()->success('Hospedagem deletada com sucesso!');
        }
        else{
            return response()->error('Hospedagem não encontrada, verifique se a mesma existe.', 400);
        }
    }

    public function showQuartos($id){
        
        $hospedagem = Hospedagem::find($id);

        if(!$hospedagem){
            return response()->error('Hospedagem não encontrada, verifique se a mesma existe.', 400);
        }

        $quartos = $hospedagem->getQuartos();

        if($quartos->count() == 0){
            return response()->error('Esta hospedagem ainda não possui quartos.', 400);
        }

        return response()->success(QuartoResource::collection($quartos));

    }
}
