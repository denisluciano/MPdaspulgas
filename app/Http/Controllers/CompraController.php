<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    //
    public function store(Request $request){



        $cons = "insert into compras values ((select ref(u) from usuarios u where u.email = '$request->email'),
        '(select ref(an) from anuncios an where an.id = '$request->id'), $request->data_,'$request->precofim,')";

        $usuario =  DB::insert($cons);


        if($usuario){
            return response()->json($usuario);
        }else {
            return "erro na inserção";
        }

    }
}
