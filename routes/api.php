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
Route::resource('/compra','CompraController');
Route::resource('/lance','LanceController');
Route::resource('/leilao','LeilaoController');
Route::resource('/negociacao','NegociacaoController');
Route::resource('/compra/n','compra_nController');
Route::resource('/compra/l','compra_lController');

