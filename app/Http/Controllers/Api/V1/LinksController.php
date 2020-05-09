<?php

namespace App\Http\Controllers\Api\V1;

//use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Resources\LinkResource;

class LinksController extends Controller
{
    //Get resources recommendation link
    public function index(Link $link){

        //getAllCached is a function of model "Link", it will get all cached links using cache_key, otherwise it will execute a function
        //to retrieve the links from database
        $links = $link->getAllCached();
        return LinkResource::collection($links);

    }
}
