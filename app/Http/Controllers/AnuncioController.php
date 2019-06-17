<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnuncioController extends Controller
{
    //
    public function store(Request $request){


        $cons = "insert into anuncios (titulo, descricao, data_, valor_inicial, e_de, possui_c, disponivel) values ('$request->titulo','$request->descricao','$request->data_',
        '$request->valor_inicial',(select ref(u) from usuarios u where u.email = '$request->email'),
        (select ref(an) from categorias an where an.titulo = '$request->titulo_ca'),'$request->disponivel')";

        $usuario =  DB::insert($cons);


        if($usuario){
            return response()->json($usuario);
        }else {
            return "erro na inserção";
        }

    }
}
