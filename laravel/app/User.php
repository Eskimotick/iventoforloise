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

use App\Models\Admin\Lote;
use App\Models\Admin\Quarto;
use App\Models\Admin\Pacote;


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

    ### Parte de hospedagens e quartos ###

    public function getQuartos(){
      $lote = Lote::find($this->lote_id);
      $pacote = Pacote::find($lote->pacote_id);
      // $quartos = $pacote->belongsToMany('App\Models\Admin\Quarto','pacotes_quartos');
      $quartos = $pacote->quartos()->get();
      
      return $quartos;

    }

    public function alocaUserQuarto($quartoId){

      if($this->quarto_id != null){
        return 'user já está alocado em um quarto.';
      }  
      
      $quarto = Quarto::find($quartoId);
      if(!$quarto){
        return 'Quarto não encontrado, verifique se o mesmo existe.';
      }

      $resposta = $quarto->preencheVaga();

      if(gettype($resposta) == 'string'){
        return $resposta;
      }

      $this->quarto_id = $quartoId;
      $this->save();

      $resposta = array($this->nickname, $quarto->nome);

      return $resposta;
        
    }

    public function desalocaUserQuarto(){

      if($this->quarto_id == null){
        return 'user não está alocado em um quarto.';
      }

      $quarto = Quarto::find($this->quarto_id);
      
      if(!$quarto){
        return 'Quarto não encontrado, verifique se o mesmo existe.';
      }

      $quarto->removeVaga();

      $this->quarto_id = null;
      $this->save();

      $resposta = array($this->nickname, $quarto->nome);

      return $resposta;
    }

    public function showQuarto($id){
      
      $quarto = Quarto::find($id);

        if($quarto){
            return $quarto;
        }
        else{
            return 'Quarto não encontrado, verifique se o mesmo existe.';
        }
    }

    ### fim Parte de hospedagens e quartos ###


    //verifica se o cpf é valido
    public static function validar_cpf($cpf)
    {
    
        $cpf = preg_replace('/[^0-9]/', '', (string) $cpf);

        $invalidos = array('00000000000',
            '11111111111',
            '22222222222',
            '33333333333',
            '44444444444',
            '55555555555',
            '66666666666',
            '77777777777',
            '88888888888',
            '99999999999');
        if (in_array($cpf, $invalidos))
            return false;

        // Valida tamanho
        if (strlen($cpf) != 11)
            return false;
        // Calcula e confere primeiro dígito verificador
        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Calcula e confere segundo dígito verificador
        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf{$i} * $j;
        $resto = $soma % 11;
        return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
    }

}
