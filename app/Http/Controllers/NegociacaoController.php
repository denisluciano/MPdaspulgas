<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class NegociacaoController extends Controller
{
    public function index()
    {
        $categorias = DB::select('select a.titulo, a.descricao, a.data_, a.valor_inicial,
        a.e_de.nome as nome_usuario, a.e_de.email as email_usuario,
        a.possui_c.titulo as titulo_categoria, a.disponivel as disponivel,
        a.tipo, a.tempo_devolucao, a.id  from negociacoes a');

        //return $categorias;

        if(!$categorias){
            return "error";
        }
        return response()->json($categorias);
        //return view('welcome', compact('categorias'));
    }
    //
    public function store(Request $request){ //FUNCIONANDO

        //negociação herda de anuncio as caracteristicas, ou seja, mexemos só com negociacao e leilao
        //Pois anuncio serve apenas pra herda as caracteristicas

        //O id de negociacao e leilao fica na tabela anuncios

        $cons = "insert into negociacoes (titulo, descricao, data_, valor_inicial, e_de, possui_c,
         disponivel,tipo, tempo_devolucao) values ('$request->titulo','$request->descricao','$request->data_',
         '$request->valor_inicial',(select ref(u) from usuarios u where u.id = '$request->id_usuario'),
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
