<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'nome','campo_id'
    ];


    //retorna o campo a qual esse item pertence
    public function campo()
    {
        return $this->belongsTo('App\Models\Admin\Campo');
    }

    //Retorna todos os usuários que escolheram esse item no campo pertencente a esse item
    public function users()
    {
        return $this->campo()->UsersWhereConteudo($this->id);
    }


    //Cria um novo item
    public function Create($newItem, $campoId){

        $this->nome = $newItem;
        $this->campo_id = $campoId;
        $this->save();

    }

    //Edita esse item
    public function Edit($data){

        if($data->nome){
            $this->nome = $data->nome;
        }
        $this->save();

    }

}
