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

Route::post('users', 'UserController@cria');
Route::get('users/{user}/atualiza-medias', 'UserController@atualizaMedias');
Route::get('users/{user}/sugestoes', 'UserController@pegaSugestoes');

Route::post('avaliar', 'NotaController@avaliar');
Route::get('rodar-modelo', 'NotaController@rodarModelo');
