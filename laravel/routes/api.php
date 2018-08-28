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
Route::get('user', 'UserController@index');
// Rotas de log-in e cadastro para visitantes.
Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');

// Grupo de rotas para password.
Route::group([
    'prefix' => 'password'
], function (){
    // Rotas para recuperar / redefinir senha.
    Route::post('/forgot', 'API\AuthController@forgotPassword');
    Route::post('/reset', 'API\AuthController@resetPassword');
});

Route::post('/resend', 'API\AuthController@resendConfirmation');

//Grupo de rotas para funções envolvendo e-mails.
Route::group([
    'prefix' => 'mail'
], function (){
    // Rota para confirmação de email.
    Route::post('confirm', 'API\AuthController@register')->name('confirm-mail');
    Route::post('confirmed', 'API\AuthController@confirmRegister');
    //Rotas para a troca de e-mail (mudar as URIs depois).
    Route::post('new', 'API\AuthController@requestNewEmail');
    Route::post('new/confirm', 'API\AuthController@newEmailConfirmed');
});

// Grupo de rotas para usuários logados.
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'auth'
], function (){
    Route::post('logout', 'API\AuthController@logout');
});

// Rotas de log-in pelo FaceBook e pelo Google.
Route::group([
    'middleware' => 'web',
    'prefix' => 'social/login'
], function (){
    Route::get('/facebook', 'API\FacebookController@redirectToFacebook');
    Route::get('/facebook/callback', 'API\FacebookController@handleFacebookCallback');
    Route::get('/google', 'API\GoogleController@redirectToGoogle');
    Route::get('/google/callback', 'API\GoogleController@handleGoogleCallback');
});

//Grupo de Rotas para o painel de usuário
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'users'
], function (){
    Route::get('{id}', 'UserController@show');
    Route::get('/', 'UserController@index');
    Route::post('/', 'UserController@store');
    Route::put('{id}', 'UserController@update');
    Route::delete('{id}', 'UserController@delete');

});

//Grupo de Rotas para o painel de admin
Route::group([//criar middleware para restringir acesso
  'prefix' => 'admin'
], function () {

    //Rotas de pacotes
    Route::group(['prefix' => 'pacotes'], function(){

        Route::get('/','PacoteController@index');                   //http://site.com/api/admin/pacotes/
        Route::get('{id}','PacoteController@showPacote');           //http://site.com/api/admin/pacotes/id
        Route::post('/', 'PacoteController@storePacote');           //http://site.com/api/admin/pacotes/
        Route::put('{id}', 'PacoteController@updatePacote');        //http://site.com/api/admin/pacotes/id
        Route::delete('{id}', 'PacoteController@destroyPacote');    //http://site.com/api/admin/pacotes/id
    });

    // rota de edição dos lotes
    Route::group(['prefix' => 'lotes'], function(){
        Route::put('{id}', 'LoteController@updateLote');            //http://site.com/api/admin/lotes/id
    });
    
    //rotas de atualizar configurações
    Route::put('inscricoes', 'ConfigController@updateInscricoes');      //http://site.com/api/admin/inscricoes
    Route::put('evento', 'ConfigController@updateEvento');              //http://site.com/api/admin/evento
    Route::put('abreinscricoes', 'ConfigController@abreInscricoes');    //http://site.com/api/admin/abreinscricoes
    Route::put('fechainscricoes', 'ConfigController@fechaInscricoes');  //http://site.com/api/admin/fechainscricoes
    

     //Rotas de hospedagens
     Route::group(['prefix' => 'hospedagens'], function(){

        Route::get('/','Admin\HospedagemController@index');                       //http://site.com/api/admin/hospedagens/
        Route::get('{id}','Admin\HospedagemController@showHospedagem');           //http://site.com/api/admin/hospedagens/id
        Route::post('/', 'Admin\HospedagemController@storeHospedagem');           //http://site.com/api/admin/hospedagens/
        Route::put('{id}', 'Admin\HospedagemController@updateHospedagem');        //http://site.com/api/admin/hospedagens/id
        Route::delete('{id}', 'Admin\HospedagemController@destroyHospedagem');    //http://site.com/api/admin/hospedagens/id
    });

    //Rotas de quartos
    Route::group(['prefix' => 'quartos'], function(){

        // Route::get('/','Admin\QuartoController@index');                   //http://site.com/api/admin/quartos/
        // Route::get('{id}','Admin\QuartoController@showQuarto');           //http://site.com/api/admin/quartos/id
        Route::post('/', 'Admin\QuartoController@storeQuarto');           //http://site.com/api/admin/quartos/
        // Route::put('{id}', 'Admin\QuartoController@updateQuarto');        //http://site.com/api/admin/quartos/id
        // Route::delete('{id}', 'Admin\QuartoController@destroyQuarto');    //http://site.com/api/admin/quartos/id
    });


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
