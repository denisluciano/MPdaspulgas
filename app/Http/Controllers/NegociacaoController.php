<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NegociacaoController extends Controller
{
    //
    public function store(Request $request){ //falta testar


        $cons = "insert into negociacoes (tipo, tempo_devolucao) values
        ($request->tipo, '$request->devolucao')";

        $query =  DB::insert($cons);


        if($query){
            return response()->json($query);
        }else {
            return "erro na inserção";
        }

    }
}
