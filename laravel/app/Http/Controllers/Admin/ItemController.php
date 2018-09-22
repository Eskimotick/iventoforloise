<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Admin\Campo;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Item;
use Illuminate\Support\Facades\DB;
use Validator;

class ItemController extends Controller
{

    //Retorna o item solicitado por id
    public function show($id){
        if($item = Item::find($id))
            return response()->success($item);
        return response()->error('Item não encontrado', 404);
    }

    //Retorna os Itens que pertencem ao campo enviado
    public function index($campo_id){
        if(Item::where('campo_id',$campo_id)->get())
            return response()->success(Item::where('campo_id',$campo_id)->get());
        return response()->error('Este campo não possui itens', 404);
    }

    //Cria um novo item associado ao id do campo enviado
    public static function store(Request $request, $campoId){

        if(Campo::find($campoId)){
            $item = new Item;
            $item->Create($request->nome, $campoId);
            return response()->success($item);
        }

        return response()->error('Campo não encontrado', 404);
    }

    //Edita um item existente com o id enviado
    public function update(UpdateItemRequest $request, $id){

        $item = Item::find($id);

        $item->Edit($request);

        return response()->success($item);

    }

    //Deleta o item com id igual ao enviado
    public function delete($id){

        if(Item::find($id)) {
            Item::destroy($id);
            return response()->success('Item removido com sucesso');
        }
        return response()->error('Esse item já não existe', 404);
    }
}
