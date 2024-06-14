<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class wordpressController extends Controller
{
    //
    public function index()
    {
        return view('dashboard.defend.wordpress.master');
    }
}
