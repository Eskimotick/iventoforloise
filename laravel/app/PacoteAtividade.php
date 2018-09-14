<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PacoteAtividade extends Model
{
  protected $fillable = [
    'pacote_id', 'atividade_id'
  ];
}
