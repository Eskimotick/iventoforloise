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

// Rotas de log-in e cadastro para visitantes.
Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');

// Rotas para recuperar / redefinir senha.
// Route::post('password/email', 'Auth\ForgotPasswordController@getResetToken');
Route::post('password/forgot', 'API\AuthController@forgotPassword');
Route::post('password/reset', 'API\AuthController@resetPassword');

// Rota para confirmação de email.
Route::post('mail/confirm', 'API\AuthController@register')->name('confirm-mail');
Route::post('mail/confirmed', 'API\AuthController@confirmRegister');

//Rotas para a troca de e-mail (mudar as URIs depois).
Route::post('mail/new', 'API\AuthController@confirmNewEmail');
Route::post('mail/new/confirm', 'API\AuthController@newEmailConfirmed');

// Visitantes podem ver a listagem de usuários.
Route::get('user/{id}', 'UserController@show');
Route::get('user', 'UserController@index');

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
    'prefix' => 'auth'
], function (){
    Route::get('login/facebook', 'API\FacebookController@redirectToFacebook');
    Route::get('login/facebook/callback', 'API\FacebookController@handleFacebookCallback');
    Route::get('login/google', 'API\GoogleController@redirectToGoogle');
    Route::get('login/google/callback', 'API\GoogleController@handleGoogleCallback');
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
