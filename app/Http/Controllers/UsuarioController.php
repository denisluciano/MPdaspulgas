<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index(){

    }
    //
    public function store(Request $request){//funcionando

        //return var_dump((integer)$request->endereco['numero']);
        $estado = $request->endereco['estado'];
        $rua = $request->endereco['rua'];
        $numero = $request->endereco['numero'];
        $bairro = $request->endereco['bairro'];
        $cep = $request->endereco['cep'];
        $cidade = $request->endereco['cidade'];
        $telefone = ['123123','213213'] ;
        $tell = "";
        //return "hh ". $cidade. " tt";

        foreach ($telefone as $key => $value) {
            if($key != 0)
                $tell = $tell. ','. $value;
            else {
                $tell = $tell. $value;
            }

        }
        //return $tell;

        $cons = "insert into usuarios(email, senha, cpf, nome, apelido, enderecos, telefones)
        values ('$request->email','$request->password','$request->cpf',
        '$request->nome','$request->apelido', lista_enderecos(endereco('$estado',
        '$bairro',$numero,'$cidade','$cep')),
        lista_telefones('$tell'))";

        $query =  DB::insert($cons);


        if($query){
            //return "sucessfull";
            $cons = "select a.email, a.nome, a.cpf, a.nome, a.apelido, a.id
            from usuarios a where a.email = '$request->email' and a.senha = '$request->password'";

            $query2 = DB::select($cons);

            if($query2){
                return[
                'ok' => true,
                'usuario' => response()->json($query2)
                ];
            }else{
                return['ok' => false];
            }


        }else {
            return "erro na inserção";
        }
    }

    public function show($id){
    }

    public function autentica(Request $request){
        $cons = "select a.email, a.nome, a.cpf, a.nome, a.apelido, a.id
        from usuarios a where a.email = '$request->email' and a.senha = '$request->password'";

        $query = DB::select($cons);

        if($query){
            return[
            'ok' => true,
            'usuario' => response()->json($query)
            ];
        }else{
            return['ok' => false];
        }
    }
}
