<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeilaoController extends Controller
{
    //
    public function store(Request $request){ //falta testar


        $cons = "insert into leiloes (data_abertura, data_fim) values
        ($request->data_abertura, '$request->data_fim')";

        $query =  DB::insert($cons);


        if($query){
            return response()->json($query);
        }else {
            return "erro na inserção";
        }

    }
}
