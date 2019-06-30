<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class Compra_lController extends Controller
{
    //
    public function store(Request $request){ //falta testar

        $datatt = date('Y-m-d');


        $cons = "insert into compras_l (e_de, do_leilao, data_, precofim) values
        ((select ref(u) from usuarios u where u.id = '$request->id_usuario'),
        (select ref(an) from leiloes an where an.id = '$request->do_leilao'), '$datatt',
        '$request->precofim')";

        $query =  DB::insert($cons);


        if($query){
            return response()->json($query);
        }else {
            return "erro na inserção";
        }

    }
    public function compras_lUsuario($id){
        $cons = "select a.e_de.nome as nome_usuario, a.e_de.email as email_usuario,
        a.do_leilao.titulo as titulo_leilao, a.do_leilao.descricao as descricao_leilao,
        a.do_leilao.data_fim as data_fim, a.data_, a.precofim, a.id
        from compras_l a where a.e_de.id = '$id'";

        $tt = DB::select($cons);

        //return $categorias;

        if(!$tt){
            return "error";
        }
        return response()->json($tt);
        //return view('welcome', compact('categorias'));

    }
}
