<?php

namespace App\Http\Controllers;
use App\Test;

use Illuminate\Http\Request;


class TestController extends Controller
{
    //
    public function index()
    {
        return response(Test::all()->jsonSerialize());
    }
}
