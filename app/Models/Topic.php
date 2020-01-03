<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id','excerpt', 'slug'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    //Check scope on document
    //Note:Topic::withOrder() and $topic->withOrder(), actually pass Topic/$topic as first param($query)into the function
    public function scopeWithOrder($query, $order){
        switch($order){
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }
    }

    public function scopeRecentReplied($query){
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query){
        return $query->orderBy('created_at', 'desc');
    }

    //Generate topics.show link
    //On html page, it will use this method to create link with slug (SEO friendly url)
    public function link($params = []){
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }

    public function replies(){
        return $this->hasMany(Reply::class)->recent();
    }

    //Update the topic's reply_count
    public function updateReplyCount(){
        $this->reply_count = $this->replies->count();
        $this->save();
    }
}
