<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Visitantes podem ver a listagem de usuários.
Route::get('user/{id}', 'UserController@show');
//http://site.com/api/user/id
Route::get('user', 'UserController@index');
//http://site.com/api/user

// Rotas de log-in e cadastro para visitantes.
Route::post('login', 'API\AuthController@login');
//http://site.com/api/login
Route::post('register', 'API\AuthController@register');
//http://site.com/api/register

// Grupo de rotas para password.
Route::group([
    'prefix' => 'password'
], function (){
    // Rotas para recuperar / redefinir senha.
    Route::post('/forgot', 'API\AuthController@forgotPassword');
    //http://site.com/api/password/forgot
    Route::post('/reset', 'API\AuthController@resetPassword');
    //http://site.com/api/password/reset
});



//Grupo de rotas para funções envolvendo e-mails.
Route::group([
    'prefix' => 'mail'
], function (){

    // Rota para confirmação de email.
    Route::post('confirm', 'API\AuthController@register')->name('confirm-mail');
    //http://site.com/api/mail/confirm
    Route::post('confirmed', 'API\AuthController@confirmRegister');
    //http://site.com/api/mail/confirmed
    Route::post('resend', 'API\AuthController@resendConfirmation');
    //http://site.com/api/mail/resend

    //Rotas para a troca de e-mail (mudar as URIs depois).
    Route::post('new', 'API\AuthController@requestNewEmail');
    //http://site.com/api/mail/new/
    Route::post('new/confirm', 'API\AuthController@newEmailConfirmed');
    //http://site.com/api/mail/new/confirm
});

// Grupo de rotas para usuários logados.
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'auth'
], function (){
    Route::post('logout', 'API\AuthController@logout');
    //http://site.com/api/auth/logout
});

// Rotas de log-in pelo FaceBook e pelo Google.
Route::group([
    'middleware' => 'web',
    'prefix' => 'social/login'
], function (){
    Route::get('/facebook', 'API\FacebookController@redirectToFacebook'); //http://site.com/api/social/login/facebook
    Route::get('/facebook/callback', 'API\FacebookController@handleFacebookCallback'); //http://site.com/api/social/login/facebook/callback
    Route::get('/google', 'API\GoogleController@redirectToGoogle');
    //http://site.com/api/social/login/google
    Route::get('/google/callback', 'API\GoogleController@handleGoogleCallback'); //http://site.com/api/social/login/google/callback
});

//Grupo de Rotas para o painel de usuário
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'users'
], function (){
    Route::get('{id}', 'UserController@show');
    //http://site.com/api/users/id
    Route::get('/', 'UserController@index');
    //http://site.com/api/users/
    Route::post('/', 'UserController@store');
    //http://site.com/api/users/
    Route::put('{id}', 'UserController@update');
    //http://site.com/api/users/id
    Route::delete('{id}', 'UserController@delete');
    //http://site.com/api/users/id
    Route::post('inscreve-atividade/{id}', 'UserController@inscreveAtividadePacote');
    //http://site.com/api/users/inscreve-atividade/id
    Route::post('remove-atividade/{id}', 'UserController@desinscreveAtividade');
    //http://site.com/api/users/desinscreve-atividade/id
});

Route::group([
    'middleware' => 'auth:api',
], function (){
    Route::get('activity', 'UserController@myPackageActivities');
});

//Grupo de rotas para atividades
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'atividades'
], function (){
    Route::get('{id}', 'AtividadesController@show');
    //http://site.com/api/atividades/id
    Route::get('/', 'AtividadesController@index');
    //http://site.com/api/atividades/
    Route::post('/', 'AtividadesController@store');
    //http://site.com/api/atividades/
    Route::put('{id}', 'AtividadesController@update');
    //http://site.com/api/atividades/id
    Route::delete('{id}', 'AtividadesController@delete');
    //http://site.com/api/atividades/id
});



//Grupo de Rotas para o painel de admin
Route::group([//criar middleware para restringir acesso
  'middleware' => 'auth:api',
  'prefix' => 'admin'
], function () {

    //Rotas de pacotes
    Route::group(['prefix' => 'pacotes'], function(){

        Route::get('/','PacoteController@index');
        //http://site.com/api/admin/pacotes/
        Route::get('{id}','PacoteController@showPacote');
        //http://site.com/api/admin/pacotes/id
        Route::post('/', 'PacoteController@storePacote');
        //http://site.com/api/admin/pacotes/
        Route::put('{id}', 'PacoteController@updatePacote');
        //http://site.com/api/admin/pacotes/id
        Route::delete('{id}', 'PacoteController@destroyPacote');
        //http://site.com/api/admin/pacotes/id
    });

    // rota de edição dos lotes
    Route::group(['prefix' => 'lotes'], function(){
        Route::put('{id}', 'LoteController@updateLote');
        //http://site.com/api/admin/lotes/id
    });

    //rotas de atualizar configurações
    Route::put('inscricoes', 'ConfigController@updateInscricoes');
    //http://site.com/api/admin/inscricoes
    Route::put('evento', 'ConfigController@updateEvento');
    //http://site.com/api/admin/evento
    Route::put('abreinscricoes', 'ConfigController@abreInscricoes');    //http://site.com/api/admin/abreinscricoes
    Route::put('fechainscricoes', 'ConfigController@fechaInscricoes');  //http://site.com/api/admin/fechainscricoes

    //Rotas para inscrever e desisncrever usuários em atividades
    Route::post('inscricao-atividade/{id_user}-{id_ativ}', 'Admin\AdminController@inscreveUser');
    Route::post('remove-atividade/{id}', 'Admin\AdminController@desinscreveUser');

});



/*  Modelo de Grupo de rotas
 *  Route::group([
 *      'middleware' => 'example',
 *      'prefix' => 'example'
 *  ], function() {
 *
 *      Route::get('{id}', 'ExampleController@getExample'); //url => https://site.com/api/example/1
 *      Route::get('all', 'ExampleController@getAll');      //url => https://site.com/api/example/all
 *      Route::post('/', 'ExampleController@create');       //url => https://site.com/api/example/
 *      Route::put('{id}', 'ExampleController@update');     //url => https://site.com/api/example/1
 *      Route::delete('{id}', 'ExampleController@delete');  //url => https://site.com/api/example/1
 *
 *  });
 */
