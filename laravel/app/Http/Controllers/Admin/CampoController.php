<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateCampoRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CampoRequest;
use App\Models\Admin\Campo;
use App\Models\Admin\Item;

class CampoController extends Controller
{
    //Recebe um id de um campo e retorna o campo referente a esse campo em json.
    public function show($id)
    {
        // Acha o campo passado no parâmetro
        $campo = Campo::findOrFail($id);

        return response()->success($campo);
    }

    //Função para listar todos os campos do bd.
    public function index()
    {
        $campos = Campo::all();

        return response()->success($campos);
    }

    // Função para administradores inserirem novos campos manualmente.
    // Falta ajustar função para os itens para select
    public function store(CampoRequest $request)
    {

        $campo = new Campo;
        $campo->Create($request);

        return response()->success($campo);

    }

    /* Admins podem modificar as infos do campo. */
    public function update(UpdateCampoRequest $request, $id)
    {
        if($campo = Campo::find($id)){

            $campo->Edit($request);
            return response()->success($campo);

        }
        return response()->error('Esse campo não existe', 404);
    }

    /* Admins podem deletar o Campo*/
    public function delete($id)
    {

        if(Campo::destroy($id)){
            return response()->success('Campo deletado com sucesso');
        }
        return response()->error('Esse Campo já não existe', 404);
    }
}
