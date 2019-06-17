<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class LanceController extends Controller
{
    //
    public function store(Request $request){ //falta testar


        $cons = "insert into lances (e_de, do_leilao, data_, valor) values
        ((select ref(u) from usuarios u where u.email = '$request->email'),
        '(select ref(le) from leiloes le where le.id = '$request->id'), $request->data_,
        '$request->valor')";

        $query =  DB::insert($cons);


        if($query){
            return response()->json($query);
        }else {
            return "erro na inserção";
        }

    }
}
