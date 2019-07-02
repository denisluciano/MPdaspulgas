<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class NegociacaoController extends Controller
{
    public function indexVenda()
    {
        $categorias = DB::select('select a.titulo, a.possui_c.titulo as categoria_titulo,
        a.possui_c.prazo_max as categoria_prazo,a.possui_c.tipo as categoria_tipo, a.descricao,
        a.data_, a.valor_inicial,
        a.e_de.nome as nome_usuario, value(t) as telefones,  a.e_de.email as email_usuario,
        a.possui_c.titulo as titulo_categoria, a.disponivel as disponivel,
        a.tipo, a.tempo_devolucao, a.id, a.foto  from negociacoes a, table(a.e_de.telefones) t
        where a.tipo = 1 and a.disponivel = 1');

        //return $categorias;

        if(!$categorias){
            return "error";
        }
        return response()->json($categorias);
        //return view('welcome', compact('categorias'));
    }
    public function indexEmprestimo()
    {
        $categorias = DB::select('select a.titulo, a.descricao, a.data_, a.valor_inicial,
        a.possui_c.titulo as categoria_titulo,
        a.possui_c.prazo_max as categoria_prazo,a.possui_c.tipo as categoria_tipo,
        a.e_de.nome as nome_usuario,  a.e_de.email as email_usuario,
        a.possui_c.titulo as titulo_categoria, a.disponivel as disponivel,
        a.tipo, a.tempo_devolucao, a.id, a.foto, value(t) as telefones from negociacoes a, table(a.e_de.telefones) t
        where a.tipo = 2 and a.disponivel = 1');

        //return $categorias;

        if(!$categorias){
            return "error";
        }
        return response()->json($categorias);
        //return view('welcome', compact('categorias'));
    }
    public function indexDoacao()
    {
        $categorias = DB::select('select a.titulo, a.descricao, a.data_, a.valor_inicial,
        a.possui_c.titulo as categoria_titulo,
        a.possui_c.prazo_max as categoria_prazo,a.possui_c.tipo as categoria_tipo,
        a.e_de.nome as nome_usuario,  a.e_de.email as email_usuario,
        a.possui_c.titulo as titulo_categoria, a.disponivel as disponivel,
        a.tipo, a.tempo_devolucao, a.id, a.foto, value(t) as telefones  from negociacoes a, table(a.e_de.telefones) t
        where a.tipo = 3 and a.disponivel = 1');

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

        $datatt = date('Y-m-d');
        $datafim =  date('Y-m-d', strtotime('+1 months', strtotime($datatt)));

        $cons = "insert into negociacoes (titulo, descricao, data_, valor_inicial, e_de, possui_c,
         disponivel,tipo, tempo_devolucao,foto) values ('$request->titulo','$request->descricao','$datatt',
         '$request->valor_inicial',(select ref(u) from usuarios u where u.id = '$request->id_usuario'),
         (select ref(an) from categorias an where an.titulo = '$request->titulo_ca'),1
         ,$request->tipo, '$request->tempo_devolucao','$request->foto')";

        $query =  DB::insert($cons);


        if($query){
            return response()->json($query);
        }else {
            return "erro na inserção";
        }

    }
}
