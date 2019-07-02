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
            //Altera pra indisponível assim que compra
            $cons2 = "update negociacoes set disponivel = 0 where id = $request->do_negoc";
            $query2 = DB::update($cons2);
            if($query2){
                return response()->json($query2);
            }else {
                return "erro na inserção";
            }
        }

    }
    //Essa relacao ta errada, essa tabela tem ser com lance pra pegar ultimo lance ???
    //falta terminar aqui
    public function compras_nUsuario($id){
        $cons = "select a.e_de.nome as nome_usuario, a.e_de.email as email_usuario,
        a.do_negoc.titulo as titulo_negoc, a.do_negoc.descricao as descricao_negoc,
        a.do_negoc.tipo as tipo_negoc, a.data_, a.precofim, a.id
        from compras_n a where a.e_de.id = '$id'";

        $tt = DB::select($cons);

        //return $categorias;

        if(!$tt){
            return "error";
        }
        return response()->json($tt);
        //return view('welcome', compact('categorias'));

    }
}
