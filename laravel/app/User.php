<?php

namespace App;

use Auth;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Laravel\Passport\HasApiTokens;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Notifications\Notifiable;
use App\Notifications\Auth\Email\ConfirmEmailNotification;
use App\Notifications\Auth\Email\EmailConfirmedNotification;
use App\Notifications\Auth\Password\PasswordResetNotification;
use App\Notifications\Auth\Password\PasswordChangedNotification;
use App\Notifications\Auth\ChangeEmail\NewEmail\ConfirmNewEmailNotification;
use App\Notifications\Auth\ChangeEmail\OldEmail\ConfirmOldEmailNotification;
use App\Notifications\Auth\ChangeEmail\NewEmail\NewEmailConfirmedNotification;
use App\Notifications\Auth\ChangeEmail\OldEmail\OldEmailConfirmedNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    protected $fillable = [
        'nickname', 'email', 'password', 'confirmation_code', 'password_reset_code', 'cpf', 'nome_completo', 'confirmd', 'admin'
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

    public function sendConfirmEmailNotification(){
      $this->confirmation_code = Uuid::uuid4();
      $this->save();
      $this->notify(new ConfirmEmailNotification());
    }

    public function sendEmailConfirmedNotification(){
      $this->notify(new EmailConfirmedNotification());
    }

    public function sendPasswordNotification(){
      $this->password_reset_code = Uuid::uuid4();
      $this->save();
      $this->notify(new PasswordResetNotification());
    }

    public function sendPasswordChangedNotification(){
      $this->notify(new PasswordChangedNotification());
    }

    public function sendConfirmNewEmailNotification(){
      $this->new_email_code = Uuid::uuid4();
      $this->save();
      $this->notify(new ConfirmNewEmailNotification());
    }

    public function sendNewEmailConfirmedNotification(){
      $this->notify(new NewEmailConfirmedNotification());
    }

    public function sendConfirmOldEmailNotification(){
      $this->old_email_code = Uuid::uuid4();
      $this->save();
      $this->notify(new ConfirmOldEmailNotification());
    }

    public function sendOldEmailConfirmedNotification(){
      $this->notify(new OldEmailConfirmedNotification());
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
