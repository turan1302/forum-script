<?php

namespace App\Http\Controllers\back\home;

use App\Http\Controllers\Controller;
use App\Models\QuestionsModel;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function index(){
        return view('back.home.index');
    }
}
