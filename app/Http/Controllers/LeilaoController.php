<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class LeilaoController extends Controller
{
    public function index()
    {
        $categorias = DB::select('select a.titulo, a.descricao, a.data_, a.valor_inicial,
        a.e_de.nome as nome_usuario,  a.e_de.email as email_usuario,
        a.possui_c.titulo as titulo_categoria, a.disponivel as disponivel,
        a.data_abertura, a.data_fim, a.id, a.foto, a.maior_lance.e_de.nome as nome_us_lance_v,
        a.maior_lance.valor as valor_lance_v, a.maior_lance.data_ as data_lance_v  from leiloes a');

        //return $categorias;

        if(!$categorias){
            return "error";
        }
        return response()->json($categorias);
        //return view('welcome', compact('categorias'));
    }
    //
    public function store(Request $request){ //funcionando

        $datatt = date('Y-m-d');
        $datafim =  date('Y-m-d', strtotime('+1 months', strtotime($datatt)));

        $cons = "insert into leiloes (titulo, descricao, data_, valor_inicial, e_de, possui_c, disponivel,
        data_abertura, data_fim, foto) values ('$request->titulo','$request->descricao','$datatt',
        '$request->valor_inicial',(select ref(u) from usuarios u where u.id = '$request->id_usuario'),
        (select ref(an) from categorias an where an.titulo = '$request->titulo_ca'),'1',
        '$request->data_abertura', '$datafim', '$request->foto')";

        $query =  DB::insert($cons);


        if($query){
            return response()->json($query);
        }else {
            return "erro na inserção";
        }

    }
    public function leilao_Usuario($id){
        $cons = "select
        a.titulo as titulo_leilao, a.descricao as descricao_leilao, a.foto as foto_leilao,
        a.valor_inicial as valor_leilao, a.disponivel as disponivel_leilao,
        a.possui_c.titulo as titulo_c_leilao, a.data_abertura as data_abertura_leilao,
        a.data_fim as data_fim_leilao, a.maior_lance.e_de.nome as nome_u_maior_lance,
        a.maior_lance.valor as valor_maior_lance, a.id as id_leilao
        from leiloes a where a.e_de.id = '$id'";

        $tt = DB::select($cons);

        //return $categorias;

        if(!$tt){
            return "error";
        }
        return response()->json($tt);
        //return view('welcome', compact('categorias'));

    }
    public function encerrarLeilao(Request $request){
        $datatt = date('Y-m-d');
        //return var_dump($request);

        //Pegar o id do maior lance do determinado leilao apos grava-lo
        $cons_max = "select max(a.id) as id_max from lances a where a.do_leilao.id = $request->id_leilao  ";
        $query_max = DB::select($cons_max);


        if($query_max){ //se pessoas tiverem dado lances entra aqui registrar compra tipo leilao
            $max_id =  $query_max[0]->id_max;

            //consulta saber valor max do lance
            $cons_val = "select a.valor as valor_max_lance from lances a where a.id = $max_id";
            $query_val = DB::select($cons_val);
            $val_lance =  $query_val[0]->valor_max_lance;


            //criando uma compra maior lance
            $cons = "insert into compras_l (e_de, do_leilao, data_, precofim) values
            ((select ref(u) from usuarios u where u.id = '$request->id_usuario'),
            (select ref(an) from leiloes an where an.id = '$request->id_leilao'), '$datatt',
            '$request->val_lance')";

            $query =  DB::insert($cons);
        }


        if($query){
            $cons2 = "update leiloes a set disponivel = 0
            where a.id = $request->id_leilao";

            $query2 = DB::update($cons2);
            if($query2){
                return response()->json($query2);
            }else {
                return "erro na inserção";
            }


        }else {
            return "erro na inserção";
        }

    }
}
