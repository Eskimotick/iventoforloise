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
use App\Models\Admin\Campo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    protected $fillable = [
        'nickname', 'email', 'password', 'confirmation_code', 'password_reset_code', 'cpf', 'nome_completo', 'confirmed', 'admin'
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
    public function updateUsers($request, User $user)
    {

        //dd($request);

        // Só modifica os dados que forem recebidos na request.
        if($request->nickname)
        {
        $this->nickname = $request->nickname;
        }

        if($request->email)
        {
        $this->email = $request->email;
        }


        $campos = Campo::All();

        foreach ($campos as $campo){
            //Substitui o espaço dos names dos inputs por _
            $nome = str_replace(" ", "_", $campo->nome);
            //Verifica se o campo do foreach está sendo editado
            if($request[$nome]) {

                //Verifica se esse campo já foi preenchido pelo usuário
                if ($user->campos()->find($campo->id)) {
                    //Verifica se o campo tem a opção outro e se o usuário escolheu essa opção e preencheu
                    if (($campo->outro) && $request["outro-".$campo->id]){
                        //Preenche o campo com o conteudo outro do campo
                        $user->campos()->updateExistingPivot($campo->id, ['conteudo' => $request["outro-".$campo->id]]);
                    } else {
                        //Preenche o campo com o conteudo normal
                        $user->campos()->updateExistingPivot($campo->id, ['conteudo' => $request[$nome]]);
                    }
                    //Caso o usuário ainda não tenha preenchido essa opção
                } else{
                    //Verifica se o campo tem a opção outro e se o usuário escolheu essa opção e preencheu
                    if ($campo->outro && $request["outro-".$campo->id]){
                        //Preenche o campo com o conteudo outro do campo
                        $user->campos()->attach($campo->id, ['conteudo' => $request["outro-".$campo->id]]);
                    } else {
                        //Preenche o campo com o conteudo normal
                        $user->campos()->attach($campo->id, ['conteudo' => $request[$nome]]);
                    }
                }
            }
        }

      $this->save();
    }

    //Retorna os campos associados à esse usuário com o valor do atributo "conteudo" da tabela pivot
    public function campos(){
        return $this->belongsToMany(Campo::class, "users_campos")->withPivot("conteudo");
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
