<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class LanceController extends Controller
{

    //
    public function store(Request $request){ //funcionando

        $datatt = date('Y-m-d');

        $cons = "insert into lances (e_de, do_leilao, data_, valor) values
        ((select ref(u) from usuarios u where u.id = '$request->id_usuario'),
        (select ref(le) from leiloes le where le.id = '$request->id_leilao'), '$datatt',
        '$request->valor')";

        $query =  DB::insert($cons);




        if($query){

            //Pegar o id do maior lance do determinado leilao apos grava-lo
            $cons_max = "select max(a.id) as id_max from lances a where a.do_leilao.id = $request->id_leilao  ";
            $query_max = DB::select($cons_max);
            $max_id =  $query_max[0]->id_max;

            //gravar maior lance como ref de leilao
            $cons2 = "update leiloes set maior_lance = (select ref(u) from lances u where u.id = $max_id) where id = $request->id_leilao";
            $query2 = DB::update($cons2);
            if($query2){
                return response()->json($query2);
            }else {
                return "erro na inserção";
            }
        }

    }
    //retorna todos lances de um dado usuario
    public function lancesUsuario($id){

        $cons = "select a.e_de.nome as nome_usuario, a.e_de.email as email_usuario,
        a.do_leilao.titulo as titulo_leilao, a.do_leilao.descricao as descricao_leilao, a.data_,
         a.valor, a.id  from lances a where a.e_de.id = '$id'";

        $categorias = DB::select($cons);

        //return $categorias;

        if(!$categorias){
            return "error";
        }
        return response()->json($categorias);
        //return view('welcome', compact('categorias'));
    }
    //retorna todos lances de um dado leilao
    public function lancesLeilao($id){
        $cons = "select a.e_de.nome as nome_usuario, a.e_de.email as email_usuario,
        a.do_leilao.titulo as titulo_leilao, a.do_leilao.descricao as descricao_leilao, a.data_,
         a.valor, a.id  from lances a where a.do_leilao.id = '$id'";

        $categorias = DB::select($cons);

        //return $categorias;

        if(!$categorias){
            return "error";
        }
        return response()->json($categorias);
        //return view('welcome', compact('categorias'));

    }
}
