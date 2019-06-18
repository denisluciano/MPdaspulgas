<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class Compra_lController extends Controller
{
    //
    public function store(Request $request){ //falta testar



        $cons = "insert into compras_l (e_de, do_leilao, data_, precofim) values
        ((select ref(u) from usuarios u where u.email = '$request->email'),
        (select ref(an) from leiloes an where an.id = '$request->do_leilao'), '$request->data_',
        '$request->precofim')";

        $query =  DB::insert($cons);


        if($query){
            return response()->json($query);
        }else {
            return "erro na inserção";
        }

    }
}
