<?php

namespace App;

use Auth;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\Auth\ConfirmEmailNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    protected $fillable = [
        'nickname', 'email', 'password', 'confirmation_code', 'cpf', 'nome_completo', 'confirmd', 'admin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Função para criar novos usuários.
    public function createUsers(UserRequest $request)
    {
      $this->nickname = $request->nickname;
      $this->email = $request->email;
      $this->password = bcrypt($request->password);

      $this->save();
    }

    // Função para editar dados de usuários.
    public function updateUsers(UpdateUserRequest $request, User $user)
    {
      // Só modifica os dados que forem recebidos na request.
      if($request->nickname)
      {
        $this->nickname = $request->nickname;
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

    public function sendConfirmNotification(){
        $this->confirmation_code = Uuid::uuid4();
        $this->save();
        $this->notify(new ConfirmEmailNotification());
    }

    public function addNew($input)
    {
      $check = static::where('google_id',$input['google_id'])->first();
      if(is_null($check))
      {
        return static::create($input);
      }
      return $check;
    }
}
