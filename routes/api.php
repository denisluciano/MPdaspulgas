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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/usuario','UsuarioController');
Route::resource('/categoria','CategoriaController');
Route::resource('/anuncio','AnuncioController');
Route::resource('/lance','LanceController');
Route::resource('/leilao','LeilaoController');
Route::resource('/negociacao','NegociacaoController');
Route::resource('/compran','compra_nController');
Route::resource('/compral','compra_lController');


Route::get('/negociacao1','negociacaoController@indexVenda');
Route::get('/negociacao2','negociacaoController@indexEmprestimo');
Route::get('/negociacao3','negociacaoController@indexDoacao');

Route::get('/lancesusuario/{id}','LanceController@lancesUsuario');
Route::get('/lancesleilao/{id}','LanceController@lancesLeilao');
Route::get('/compra/nusuario/{id}','compra_nController@compras_nUsuario');
Route::get('/compra/lusuario/{id}','compra_lController@compras_lUsuario');
Route::post('/autentica', 'UsuarioController@autentica');
