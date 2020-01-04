<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

trait LastActiveAtHelper{
    //Cache related things
    protected $hash_prefix = 'jiaforum_last_active_at_';
    protected $field_prefix = 'user_';

    public function recordLastActiveAt(){
        //Get today's date
        $date = Carbon::now()->toDateString();

        //The name of the hash table
        //e.g. jiaforum_last_active_at_2018-06-02
        //Users who logged in this day, their last active time will be store in this table
        $hash = $this->getHashFromDateString($date);
        //dd(Redis::hGetAll($hash));
        //The field name e.g. user_6
        $field = $this->getHashField();

        //The current time e.g.2019-06-02 08:36:16
        $now = Carbon::now()->toDateTimeString();

        //Store data in Redis's given hash table, if the field(user_x) has already existed, it will update it
        Redis::hSet($hash, $field, $now); //hSet($table, $key, $value);
    }

    //Synchronize user's last active time from Redis(Redis的cache数据在内存) to database
    public function syncUserActiveAt(){
        //Get yesterday's date e.g. 2018-06-08
        $yesterday_date = Carbon::yesterday()->toDateString();

        //Redis hash table's name
        $hash = $this->getHashFromDateString($yesterday_date);

        //Get all data from Redis's given hash table
        $dates = Redis::hGetAll($hash);

        foreach($dates as $user_id => $active_at){
            $user_id = str_replace($this->field_prefix, '', $user_id);//user_1 -> 1

            //Only if the user is existing in database, we update its last_active_at field
            if($user = $this->find($user_id)){
                $user->timestamps = false;//temperoily disable the maintaince on updated_at, otherwise it will be updated each time when we update last_active_at
                $user->last_active_at = $active_at;
                $user->save();
            }
        }

        //When the database has synchronized yesterday's data, we can delete the yesterday's data from Redis
        Redis::del($hash);//We delete the hash table for yesterday while continue storing and updating data in today's table
    }

    //We write an Accessor here, getFooAttribute($value),
    //We can simpley call ->foo() to get the attribute value we want
    //here we will call $user->lastActiveAt()
    public function getLastActiveAtAttribute($value){
        //Get tody's hash table name
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        //Get the field name
        $field = $this->getHashField();

        //Get the data from Redis, if there is no data, then get the original data from database
        $datetime = Redis::hGet($hash, $field) ? : $value;//$value is the original data from database

        //If the datetime is not null(user has successfully logined at least for onece), return a Carbon instace
        if($datetime){
            return new Carbon($datetime);
            //As we return a Carbon instance, on pages, we can directly use ->diffForHumans()
        }else{
            //Otherwise use user's registration time
            return $this->created_at;
        }

    }

    public function getHashFromDateString($date){
        //Hash table name in Redis e.g. jiaforum_last_active_at_2018-06-08
        return $this->hash_prefix . $date;
    }

    public function getHashField(){
        //field name in hash table e.g. user_1
        return $this->field_prefix . $this->id;
    }
}
