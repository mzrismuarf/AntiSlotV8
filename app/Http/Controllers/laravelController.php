<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class laravelController extends Controller
{
    //

    public function index()
    {
        return view('dashboard.defend.laravel.master');
    }
}
