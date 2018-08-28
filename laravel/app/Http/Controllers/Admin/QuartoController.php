<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Hospedagem;
use App\Models\Admin\Quarto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuartoRequest as StoreRequest;

class QuartoController extends Controller
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
    public function storeQuarto(StoreRequest $request)
    {
        $hospedagem = Hospedagem::find($request->hospedagem);
        if(!$hospedagem){
            return response()->error('Hospedagem não encontrada, verifique se a mesma existe.', 400);
        }
        
        //pega o maior id na tabela quarto que tenha a mesma hospedagem para listar somente
        // os quartos novos gerados aqui, que terão id maior que o id da tabela.
        $maiorId = Quarto::where('hospedagem_id', $hospedagem->id)->max('id');
        $maiorId = $maiorId == null ? 0 : $maiorId;

        $resposta = $hospedagem->validaCriacaoQuartos($request);

        if(gettype($resposta) == 'string'){
            return response()->error($resposta, 400);
        }

        //pega os novos quartos que acabaram de ser criados.
        $novosQuartos = Quarto::where('hospedagem_id', $hospedagem->id)
                        ->where('id', '>', $maiorId)->get();

        return response()->success($novosQuartos);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showQuarto($id)
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
    public function updateQuarto(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyQuarto($id)
    {
        $quarto = Quarto::find($id);

        if($quarto){
            $quarto->delete();
            return response()->success('Quarto deletada com sucesso!');
        }
        else{
            return response()->error('Quarto não encontrada, verifique se a mesma existe.', 400);
        }
    }
}
