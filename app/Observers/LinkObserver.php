<?php

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    public function __construct(Link $link){
        //put the following code in construtor. It will be executed when change is saved or link is deleted
        Cache::forget($link->cache_key);
    }
    //When any change saved in links table, clear the cached data for given cache_key
    public function saved(Link $link){
        //Cache::forget($link->cache_key);
    }

    public function deleted(Link $link){
        //Cache::forget($link->cache_key);
    }
}
