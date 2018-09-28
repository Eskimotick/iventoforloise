<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Hospedagem;
use App\Models\Admin\Quarto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuartoRequest as StoreRequest;
use App\Http\Requests\Admin\UpdateQuartoRequest as UpdateRequest;

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
        $quarto = Quarto::find($id);

        if($quarto){
            return response()->success($quarto);
        }
        else{
            return response()->error('Quarto não encontrado, verifique se o mesmo existe.', 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateQuarto(UpdateRequest $request, $id)
    {
        $quarto = Quarto::find($id);

        if(!$quarto){
            return response()->error('Quarto não encontrado, verifique se o mesmo existe.', 400);
        }

        $resposta = $quarto->updateQuarto($request);

        if(gettype($resposta) == 'string'){
            return response()->error($resposta, 400);
        }

        return response()->success($resposta);
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
            return response()->success('Quarto deletado com sucesso!');
        }
        else{
            return response()->error('Quarto não encontrada, verifique se o mesmo existe.', 400);
        }
    }

    public function destroyAllQuartos(Request $request){
        
        $quartos = $request->quartos;
        $listaQuartos = explode(',', $quartos);
        //fazer algum tipo de verificação antes de deletar os quartos, para ver se a lista existe, talvez?
        Quarto::destroy($listaQuartos);

        return response()->success('Os seguintes quartos foram deletados com sucesso! lista: '.$quartos);
    }

    public function adminAlocaUser(Request $request, $id){

        $quarto = Quarto::find($id);
        if(!$quarto){
            return response()->error('Quarto não encontrado, verifique se o mesmo existe.', 400);
        }

        $resposta = $quarto->alocaUser($request->cpf);

        if(gettype($resposta) == 'string'){
            return response()->error($resposta, 400);
        }

        $resposta = implode('/', $resposta);
        return response()->success('User alocado com sucesso! user/quarto => '.$resposta);

    }

    public function adminDesalocaUser(Request $request){

        $quarto = new Quarto;
        $resposta = $quarto->desalocaUser($request->cpf);

        if(gettype($resposta) == 'string'){
            return response()->error($resposta, 400);
        }

        $resposta = implode('/', $resposta);
        return response()->success('User desalocado com sucesso! user/quarto => '.$resposta);
    }


}
