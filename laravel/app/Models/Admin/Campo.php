<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Http\Controllers\Admin\ItemController;
use App\Models\Admin\Item;

class Campo extends Model
{
    protected $fillable = [
        'nome','tipo','outro'
    ];

    /* Função para retornar os itens desse campo caso ele seja do tipo select
    public function selectItems(){
        return $this->hasMany('App\Models\Auth\SelectItem\SelectItem');
    }*/

    public  function Users(){
        return $this->belongsToMany(User::class, "users_campos")->withPivot("conteudo");
    }


    //Retorna todos os usuários que inseriram o conteudo desse campo igual ao parâmetro deste método
    public function UsersWhereConteudo($conteudo){
        return $this->Users()->wherePivot('conteudo',$conteudo);
    }

    //Cria um novo campo
    public function Create($newCampo){

        //Passando os dados da request para o novo campo
        $this->nome = $newCampo->nome;
        $this->tipo = $newCampo->tipo;
        $this->outro = $newCampo->outro;
        $this->save();

        if($newCampo->tipo == 'select'){
            //Criando os Itens Pertencentes a esse Campo
            for($i = 0; $i < $newCampo->qtd; $i++){
                //Pegando cada item passado por controller e criando no bd
                $item = new Item;
                $item->Create($newCampo['item'.$i], $this->id);
            }
        }


    }

    //Edita esse campo
    public function Edit($data){

        if($data->nome){
            $this->nome = $data->nome;
        }
        if($data->tipo){
            $this->tipo = $data->tipo;
        }
        if($data->outro){
            $this->outro = $data->outro;
        }

        $this->save();

    }


}
