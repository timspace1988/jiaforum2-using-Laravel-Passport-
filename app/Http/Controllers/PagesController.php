<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //process the display on home page
    public function root (){
        return view('pages.root');
    }
}
