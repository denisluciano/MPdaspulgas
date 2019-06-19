<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class Compra_nController extends Controller
{
    //
    public function store(Request $request){ //funcionando

        $datatt = date('Y-m-d');

        $cons = "insert into compras_n (e_de, do_negoc, data_, precofim) values
        ((select ref(u) from usuarios u where u.id = '$request->id_usuario'),
        (select ref(an) from negociacoes an where an.id = '$request->do_negoc'), '$datatt',
        '$request->precofim')";

        $query =  DB::insert($cons);


        if($query){
            return response()->json($query);
        }else {
            return "erro na inserção";
        }

    }
    //Essa relacao ta errada, essa tabela tem ser com lance pra pegar ultimo lance ???
    //falta terminar aqui
    public function compras_nUsuario($id){
        $cons = "select a.e_de.nome as nome_usuario, a.e_de.email as email_usuario,
        a.do_leilao.titulo as titulo_leilao, a.do_leilao.descricao as descricao_leilao,
        a.data_, a.precofim, a.id  from compras_n a where a.e_de.id = '$id'";

        $categorias = DB::select($cons);

        //return $categorias;

        if(!$categorias){
            return "error";
        }
        return response()->json($categorias);
        //return view('welcome', compact('categorias'));

    }
}
