<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioAtividade extends Model
{
  protected $fillable = [
    'usuario_id', 'atividade_id', 'status'
  ];
}
