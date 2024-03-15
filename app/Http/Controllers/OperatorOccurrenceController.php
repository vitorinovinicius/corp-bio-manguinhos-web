<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperatorOccurrenceController extends Controller
{


    public function store(Request $request)
    {
        $data = $request->all();
        print_r($data);
    }
}
