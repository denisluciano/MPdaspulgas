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
        $categorias = DB::select('select * from categorias');

        //return $categorias;

        if(!$categorias){
            return "error";
        }

        return view('welcome', compact('categorias'));
    }
}
