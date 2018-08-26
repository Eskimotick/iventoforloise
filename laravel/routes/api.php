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
Route::group([
  'prefix' => 'admin'
], function () {
  //rotas aqui
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
