<?php

namespace App\Models\Traits;

use App\Models\Topic;
use App\Models\Reply;
use Carbon\Carbon;
use Cache;
use DB;
use Arr;

trait ActiveUserHelper{
    //Used to store temporary user data
    protected $users = [];

    //configuration info
    protected $topic_weight = 4;//The score of each topic
    protected $reply_weight =1;
    protected $pass_days = 7;//in past 7 days
    protected $user_num = 6;//How many active users we get

    //configuration for cache
    protected $cache_key = 'jiaforum_active_users';
    protected $cache_expire_in_seconds = 65 * 60;

    //Retieve the active users from cache
    public function getActiveUsers(){
        //use cache_key to get the data, if there is data, return it,
        //otherwise, it will call the function to calculate the active users, return it will automatically cache it
        return Cache::remember($this->cache_key, $this->cache_expire_inseconds, function(){
            return $this->calculateActiveUsers();
        });
    }

    public function calculateAndCacheActiveUsers(){
        //get the list of active users
        $active_users = $this->calculateActiveUsers();
        //Cache this list
        $this->cacheActiveUsers($active_users);
    }

    //Get the users who got the highest socre by posting topics and replies
    private function calculateActiveUsers(){
        $this->calculateTopicScore();
        $this->calculateReplyScore();

        //Sort the array on score(sort the users[] according to each user's score)
        $users = Arr::sort($this->users, function($user){
            return $user['score'];
        });

        //We need the array to be sorted in desc, hightest score at the front
        //so we need to reverse it and 'true' will keep the array's key not changed
        //Second param default is false
        $users = array_reverse($users, true);

        //only get a number of users we need
        //array_slice ( array $array , int $offset [, int $length = NULL [, bool $preserve_keys = FALSE ]] ) : array
        //the offset parameter denotes the (starting)position in the array, not the key.
        $users = array_slice($users, 0, $this->user_num, true);

        //Build a new empty collect
        $active_users = collect();

        foreach($users as $user_id => $user){
            $user = $this->find($user_id);//This trait will be used by User model, so use find() here is ok.

            //If there is this user in database
            if($user){
                //put this into collect from the end
                $active_users->push($user);

            }
        }
        return $active_users;
    }

    private function calculateTopicScore(){
        //Get users from topics table, who posted topic within the given ($pass_days) days
        //And their topics number in this period
        $topic_users = Topic::query()->select(DB::raw('user_id, count(*) as topic_count'))
                                     ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                     ->groupBy('user_id')
                                     ->get();

        //calculate the score of topics
        foreach($topic_users as $value){
            $this->users[$value->user_id]['score'] = $value->topic_count * $this->topic_weight;
        }
    }

    private function calculateReplyScore(){
        //Get users from replies table, who post reply within the given ($pass_days) days
        //And their replies number in this period
        $reply_users = Reply::query()->select(DB::raw('user_id, count(*) as reply_count'))
                                     ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                     ->groupBy('user_id')
                                     ->get();

        //Calculate the score of replies
        foreach($reply_users as $value){
            $reply_score = $value->reply_count * $this->reply_weight;
            if(isset($this->users[$value->user_id])){
                $this->users[$value->user_id]['score'] += $reply_score;
            }else{
                $this->users[$value->user_id]['score'] = $reply_score;
            }
        }
    }

    private function cacheActiveUsers($active_users){
        //Store the data into cache
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_seconds);
    }
}
