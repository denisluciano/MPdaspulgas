<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    //
    public function store(Request $request){//funcionando

        $cons = "insert into usuarios values ('$request->email','$request->senha','$request->cpf',
        '$request->nome','$request->apelido', lista_enderecos(endereco('$request->estado',
        '$request->bairro',$request->numero,'$request->cidade','$request->cep')),
        lista_telefones('$request->numero_cel'))";

        $query =  DB::insert($cons);


        if($query){
            return response()->json($query);
        }else {
            return "erro na inserção";
        }
    }
    public function show($id){


    }
}
