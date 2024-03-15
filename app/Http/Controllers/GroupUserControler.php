<?php namespace App\Http\Controllers;

use Artesaos\Defender\Facades\Defender;

class GroupUserControler extends Controller {

    public function index(){
        $groups = Defender::rolesList();
        return view('group_user.index',compact('groups'));
    }
}