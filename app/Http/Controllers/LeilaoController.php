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
}
