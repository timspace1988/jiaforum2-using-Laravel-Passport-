<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Link extends Model
{
    protected $fillable = ['title', 'link'];

    public $cache_key = 'jiaforum_links';

    protected $cache_expire_in_seconds = 1440 * 60;

    public function getAllCached(){
        //Try getting the cache_key's corresponding data, if we can get data, then we return it
        //Otherwise, it will executethe function(){} to get all data in links table and automatically cache it for given seconds
        return Cache::remember($this->cache_key, $this->cache_expire_in_seconds, function(){
            return $this->all();
        });
    }
}
