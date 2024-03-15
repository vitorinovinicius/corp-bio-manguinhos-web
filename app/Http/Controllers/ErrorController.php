<?php

namespace App\Http\Controllers;

class ErrorController extends Controller
{
    public function error401(){
        return view('errors.401');
    }

    public function error404(){
        return view('errors.404');
    }
}
