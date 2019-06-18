<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    //
    // public function store(Request $request){ //falta testar



    //     $cons = "insert into compras (e_de, do_anuncio, data_, precofim) values
    //     ((select ref(u) from usuarios u where u.email = '$request->email'),
    //     (select ref(an) from anuncios an where an.id = '$request->id'), '$request->data_',
    //     '$request->precofim')";

    //     $query =  DB::insert($cons);


    //     if($query){
    //         return response()->json($query);
    //     }else {
    //         return "erro na inserção";
    //     }

    // }
}
