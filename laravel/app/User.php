<?php

namespace App;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    protected $fillable = [
        'name', 'email', 'password', 'ativo'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Função para criar novos usuários.
    public function createUsers(UserRequest $request)
    {
      $this->name = $request->name;
      $this->email = $request->email;
      $this->password = bcrypt($request->password);

      $this->save();
    }

    // Função para editar dados de usuários.
    public function updateUsers(UpdateUserRequest $request, User $user)
    {
      // Só modifica os dados que forem recebidos na request.
      if($request->name)
      {
        $this->name = $request->name;
      }

      if($request->email)
      {
        $this->email = $request->email;
      }

      $this->save();
    }

    // Função para deletar usuários.
    public function deleteUsers(User $user)
    {
      // Deleta o usuário passado na função.
      User::destroy($user->id);
    }

}
