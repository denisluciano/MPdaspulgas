<?php

namespace App\Http\Controllers;
use App\Categoria;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    //
    public function index()
    {
        $categorias = DB::select('select a.titulo from categorias a');

        //return $categorias;

        if(!$categorias){
            return "error";
        }
        return response()->json($categorias);
        //return view('welcome', compact('categorias'));
    }
    public function store(Request $request){

        // $categorias = DB::insert('insert into categorias (titulo, prazo_max, tipo)
        // values (requesttitulo,30,requesttipo )');

        $categoria = DB::table('categorias')->insert(
            ['titulo' => $request->titulo, 'prazo_max' => $request->prazo_max, 'tipo' => $request->tipo]
        );

        if($categoria)
            return "sucesso";



        return response()->json($categoria);

    }
}
