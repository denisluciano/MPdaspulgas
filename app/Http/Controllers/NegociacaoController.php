<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class NegociacaoController extends Controller
{
    //
    public function store(Request $request){ //FUNCIONANDO

        //negociação herda de anuncio as caracteristicas, ou seja, mexemos só com negociacao e leilao
        //Pois anuncio serve apenas pra herda as caracteristicas

        //O id de negociacao e leilao fica na tabela anuncios

        $cons = "insert into negociacoes (titulo, descricao, data_, valor_inicial, e_de, possui_c,
         disponivel,tipo, tempo_devolucao) values ('$request->titulo','$request->descricao','$request->data_',
         '$request->valor_inicial',(select ref(u) from usuarios u where u.email = '$request->email'),
         (select ref(an) from categorias an where an.titulo = '$request->titulo_ca'),'$request->disponivel'
         ,$request->tipo, '$request->tempo_devolucao')";

        $query =  DB::insert($cons);


        if($query){
            return response()->json($query);
        }else {
            return "erro na inserção";
        }

    }
}
