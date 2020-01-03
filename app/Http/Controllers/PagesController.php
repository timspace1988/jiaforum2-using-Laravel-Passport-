<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //process the display on home page
    public function root (){
        return view('pages.root');
    }

    public function permissionDenied(){
        //Recheck if the current user has the permission, redirect to admin page
        //Because after unlogged-in user sign in, it will be automatically redirected to previous page(permission_denied page), so you need to recheck it
        //we define permission => function(){...} in config/administrator.php,
        //config('administrator.permission')() is actually permission()
        //config('administrator') will return the function, but doesn't execute
        if(config('administrator.permission')()){
            return redirect(url(config('administrator.uri')), 302);
        }

        //otherwise use the permission denied page
        return view('pages.permission_denied');
    }
}


