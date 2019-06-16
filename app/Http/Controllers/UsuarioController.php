<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    //
    public function store(Request $request){

        // $categorias = DB::insert('insert into categorias (titulo, prazo_max, tipo)
        // values (requesttitulo,30,requesttipo )');
        $cons = "insert into usuarios values ('$request->email','$request->senha','$request->cpf',
        '$request->nome','$request->apelido', lista_enderecos(endereco('$request->estado',
        '$request->bairro',$request->numero,'$request->cidade','$request->cep')),
        lista_telefones('$request->numero_cel'))";

        $usuario =  DB::insert($cons);


        if($usuario)
            return "sucesso";


        return response()->json($usuario);

    }
}
