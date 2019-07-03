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
        a.e_de.nome as nome_usuario, value(t) as telefone,  a.e_de.email as email_usuario,
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
        a.tipo, a.tempo_devolucao, a.id, a.foto, value(t) as telefone from negociacoes a, table(a.e_de.telefones) t
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
        a.tipo, a.tempo_devolucao, a.id, a.foto, value(t) as telefone  from negociacoes a, table(a.e_de.telefones) t
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
    public function negociacoes_Usuario($id){
        $cons = "select
        a.titulo as titulo_negoc, a.descricao as descricao_negoc, a.foto as foto_negoc,
        a.valor_inicial as valor_negoc, a.tipo as tipo_negoc, a.disponivel as disponivel_negoc,
        a.possui_c.titulo as titulo_c_negoc, a.data_ as data_negoc, a.tempo_devolucao as tempo_negoc,
        a.id as id_negoc
        from negociacoes a where a.e_de.id = '$id'";

        $tt = DB::select($cons);

        //return $categorias;

        if(!$tt){
            return "error";
        }
        return response()->json($tt);
        //return view('welcome', compact('categorias'));

    }
    public function finalizarCompra(Request $request){
        $cons2 = "update negociacoes a set a.disponivel = 0
            where a.id = $request->id_negoc";

            $query2 = DB::update($cons2);
            if($query2){
                return response()->json($query2);
            }else {
                return "erro na inserção";
            }

    }
}
