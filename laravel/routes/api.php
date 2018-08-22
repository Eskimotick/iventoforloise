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
Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');

// Rotas para recuperar / redefinir senha.
Route::post('password/email', 'Auth\ForgotPasswordController@getResetToken');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Rota para confirmação de email
Route::post('confirm-mail', 'Auth\RegisterController@sendEmail')->name('confirm-mail');

// Visitantes podem ver a listagem de usuários.
Route::get('user/{id}', 'UserController@show');
Route::get('user', 'UserController@index');

// Grupo de rotas para usuários logados.
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'auth'
], function (){
    Route::post('logout', 'API\PassportController@logout');
});

// Rotas de log-in pelo FaceBook.
Route::group([
    'middleware' => 'web',
    'prefix' => 'auth'
], function (){
    Route::get('login/facebook', 'FacebookController@redirectToFacebook');
    Route::get('login/facebook/callback', 'FacebookController@handleFacebookCallback');
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
