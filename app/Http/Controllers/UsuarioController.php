<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    //
    public function store(Request $request){//funcionando

        $cons = "insert into usuarios(email, senha, cpf, nome, apelido, enderecos, telefones)
        values ('$request->email','$request->senha','$request->cpf',
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
    public function autentica(Request $request){
        $cons = "select a.email, a.nome, a.cpf, a.nome, a.apelido, a.id
        from usuarios a where a.email = '$request->email' and a.senha = '$request->senha'";

        $query = DB::select($cons);

        if($query){
            return[
            'ok' => true,
            'usuario' => response()->json($query)
            ];
        }else{
            return['ok' => false];
        }
    }
}
