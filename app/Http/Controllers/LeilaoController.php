<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class LeilaoController extends Controller
{
    //
    public function store(Request $request){ //funcionando


        $cons = "insert into leiloes (titulo, descricao, data_, valor_inicial, e_de, possui_c, disponivel,
        data_abertura, data_fim) values ('$request->titulo','$request->descricao','$request->data_',
        '$request->valor_inicial',(select ref(u) from usuarios u where u.email = '$request->email'),
        (select ref(an) from categorias an where an.titulo = '$request->titulo_ca'),'$request->disponivel',
        '$request->data_abertura', '$request->data_fim')";

        $query =  DB::insert($cons);


        if($query){
            return response()->json($query);
        }else {
            return "erro na inserção";
        }

    }
}
